const anotherloading = '<div class="flex fixed w-[85%] items-center justify-center"><img src="../Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';


tableAllMirData() ;


// RESERVATION PAGE ONLY
const search =  document.getElementById("searchBar") ;
search.addEventListener("submit", function(event) {
    event.preventDefault() ;

    tableAllMirData()     
})


// ALL DATA PAGE FUNCTION DECLARATION
async function get_mirSpoolData() {
    const selectedValue = document.getElementById("search").value;
    const based_on = document.getElementById("based_on").value;
    
    try {
        const response = await fetch("../API/Get_Reservation/mirSpoolTable.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "search=" + selectedValue + "&based_on=" + based_on
        });

        if (response.ok) {
            const data = await response.text();

            document.getElementById("mirSpoolTable").innerHTML = data;
            document.getElementsByTagName("body")[0].classList.remove("overflow-hidden");
        } else {
            throw new Error("Error fetching data");
        }

    } catch (error) {
        console.error(error);
    }
}

function tableAllMirData() {
    document.getElementsByTagName("body")[0].classList.add("overflow-hidden");
    document.getElementById("mirSpoolTable").innerHTML = anotherloading;
    
    get_mirSpoolData() ;
}

// DOWNLOAD MECHANISM 
const downloadButtonReservation = document.getElementById('downloadBtn') ;
const process = document.getElementById('downloadProcess') ;
downloadButtonReservation.addEventListener('click', async () => {
    downloadButtonReservation.disabled = true;
    process.classList.replace("hidden", "block");
    // Lakukan permintaan unduhan ke halaman server yang melakukan pemrosesan data
    try {
        const response = await fetch('../Report/reservationReport.php');
        if (!response.ok) {
            throw new Error('Gagal mengunduh data.');
        }
        // Jika permintaan berhasil, ambil file data yang dihasilkan dari server
        const blob = await response.blob();
        // Buat URL blob untuk file data
        const url = URL.createObjectURL(blob);
        // Buat elemen <a> baru untuk mengunduh file
        const downloadLink = document.createElement('a');
        downloadLink.href = url;
        downloadLink.download = 'Reservation.xlsx'; // Nama file yang akan diunduh
        downloadLink.click();
        // Hapus URL blob setelah file diunduh
        downloadButtonReservation.disabled = false;
        process.classList.replace("block", "hidden");
        URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Terjadi kesalahan:', error);
        downloadButtonReservation.disabled = false;
        process.classList.replace("block", "hidden");
    } 
});

// UPLOAD MECHANISM
const form = document.getElementById('uploadForm') ;
const submitButton = document.getElementById('submitButton');
form.addEventListener('submit', (e) => {
    e.preventDefault();
    submitButton.disabled = true;
    upload() ;

})
// UPLOAD MECHANISM 
function upload(){
    const additional = document.getElementById('keterangan').value ;
    const getFile = document.getElementById('formFile') ;

    const dataFile = new FormData() ;
    dataFile.append('file', getFile.files[0])
    dataFile.append('additional', additional)

    warn_Stock_Dissapear() ;
    // success_Component() ;

    const xhr = new XMLHttpRequest();
        xhr.open('POST', '../uploaded/excel_Reservation.php', true);

        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    if (xhr.responseText != 'Denied') {
                        tableAllMirData() ;
                        success_Component() ;
                        setTimeout(() => {
                            success_Component() ;
                        }, 3000)
                    } else {
                        warn_Stock();
                    }
                } else {
                    console.error('Error during XMLHttpRequest:', xhr.status, xhr.statusText);
                }

                submitButton.disabled = false;
            }
        };

        xhr.send(dataFile);
    
}

// INPUT MECHANISM
const inputForm = document.getElementById('inputForm');
inputForm.addEventListener('submit', (e) => {
    e.preventDefault();
    inputNew() ;
})
// INPUT MECHANISM
async function inputNew() {
    const mir = document.getElementById('mir').value ;
    const spool = document.getElementById('spool').value ;
    const ic = document.getElementById('ic').value ;
    const qty = document.getElementById('qty').value ;

    try {
        const response = await fetch('../API/Get_Reservation/add_newItems.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'mir=' + encodeURIComponent(mir) + '&spool=' + encodeURIComponent(spool) + '&qty=' + encodeURIComponent(qty) + '&ic=' + encodeURIComponent(ic)
        })
        if (response.ok) {
            const result = await response.text() ;
            if (result != 'denied') {
                tableAllMirData() ;
                document.getElementById('qty').value = '' ;                
            }
        }
    } catch (err) {
        console.log(err) ;
    }
    
}
// WARNING COMPONENT
const element2 = document.getElementById("warn_Stock");
function warn_Stock() {
    element2.classList.replace("-right-80", "right-5");
    setTimeout(function () {
        element2.classList.replace("right-5", "-right-80");
    }, 10000);
}
function warn_Stock_Dissapear() {
    element2.classList.replace("right-5", "-right-80");
}

// SUCCESS COMPONENT 
const element3 = document.getElementById('successComponent');
function success_Component() {
    if (element3.classList.contains('-bottom-full')) {
        element3.classList.replace('-bottom-full', 'bottom-3');
    } else {
        element3.classList.replace('bottom-3', '-bottom-full');
    }
}
