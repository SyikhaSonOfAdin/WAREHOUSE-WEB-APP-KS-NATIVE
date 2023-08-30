const loading = '<div class="flex w-full h-full items-center justify-center"><img src="../Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';

// DEFAULT FUNCTION
const form = document.getElementById("modal");
form.addEventListener("submit", function (event) {
    event.preventDefault();

    getUsedTableContent();
    getIC();
})


// DELETE AND GET TABLE 
async function getUsedTableContent() {
    var selectedSpool = document.getElementById("spool").value;
    var selectedIdentCode = document.getElementById("identCode").value;
    var selectedMir = document.getElementById("Mir").value;
    var selectedDate = document.getElementById("date").value;
    var selectedQty = document.getElementById("qty").value;
    var selectedFitter = document.getElementById("by").value;
    var selectedWho = document.getElementById("by_who").value;

    try {
        const response = await fetch("../API/Get_Issued/usedTable.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "selectedSpool=" + selectedSpool + "&selectedIdentCode=" + selectedIdentCode + "&selectedMir=" + selectedMir + "&selectedDate=" + selectedDate + "&selectedQty=" + selectedQty + "&selectedFitter=" + selectedFitter + "&selectedWho=" + selectedWho
        })

        if (response.ok) {
            const data = await response.text();
            document.getElementById("usedTable").innerHTML = data;
        }
    } catch (error) {
        console.log(error);
    }
}

function editButton(event) {
    event.preventDefault();

    const search = document.getElementById('search').value;
    const Index = event.target.parentNode.querySelector('[name="changeIndex"]').value;

    var xhr1 = new XMLHttpRequest(); // Objek pertama untuk get_usedpageEdit.php
    xhr1.open("POST", "../API/Get_Issued/get_usedpageEdit.php", true);
    xhr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr1.onreadystatechange = function () {
        if (xhr1.readyState == 4 && xhr1.status == 200) {
            warn_Delete();
            if (search != '') {
                tableInit()
            } else {
                getUsedTableContent();
            }
        }
    };
    xhr1.send("selectedIndex=" + Index);
}



// ISSUED FORM FUNCTION
document.getElementById("spool").disabled = true;
document.getElementById("identCode").disabled = true;
document.getElementById("Mir").disabled = true;

function searchSpool() {
    var selectedValue = document.getElementById("spoolSearch").value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../API/Get_Issued/get_AllSpool.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = xhr.responseText;
            document.getElementById("spool").innerHTML = data;
            document.getElementById("spool").disabled = false;
            document.getElementById("spool").classList.remove("hover:cursor-not-allowed");
        }
    };
    xhr.send("selectedValue=" + selectedValue);
}

function getIC() {
    var selectedValue = document.getElementById("spool").value;

    const xhr = new XMLHttpRequest();
    if (selectedValue !== "") {
        xhr.open("POST", "../API/Get_Issued/get_icbySearch.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var data = xhr.responseText;
                document.getElementById("identCode").innerHTML = data;
                document.getElementById("identCode").disabled = false;
                document.getElementById("identCode").classList.remove("hover:cursor-not-allowed");
            }
        };
        xhr.send("selectedValue=" + selectedValue);
    } else {
        document.getElementById("identCode").disabled = true;
        document.getElementById("identCode").classList.add("hover:cursor-not-allowed");
    }
}

function searchIdentCode() {
    var selectedValue = document.getElementById("spool").value;
    var selected = document.getElementById("identCodeSearch").value;

    // Kirim data selectedValue ke file PHP menggunakan AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../API/Get_Issued/get_icbySearch.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = xhr.responseText;
            document.getElementById("identCode").innerHTML = data;
        }
    };
    xhr.send("selectedValue=" + selectedValue + "&selected=" + selected);
}

function getMir() {
    var selectedValue = document.getElementById("identCode").value;
    var selectedSpool = document.getElementById("spool").value;

    // Kirim data selectedValue ke file PHP menggunakan AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../API/Get_Issued/get_mirBySpool.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = xhr.responseText;
            document.getElementById("Mir").innerHTML = data;
            document.getElementById("Mir").disabled = false;
            document.getElementById("Mir").classList.remove("hover:cursor-not-allowed");
        }
    };
    xhr.send("selectedValue=" + selectedValue + "&selectedSpool=" + selectedSpool);
}

async function warning() {
    var selectedIdentCode = document.getElementById("identCode").value;
    var selectedQty = document.getElementById("qty").value;
    if (selectedIdentCode !== "" && selectedIdentCode !== null) {
        const Quantity = await getQuantity();
        if (Quantity - selectedQty < 0) {
            warn_Stock(selectedIdentCode, Quantity);
        }
    }
}

function getQuantity() {
    var selectedIdentCode = document.getElementById("identCode").value;
    var selectedMir = document.getElementById("Mir").value;
    var selectedSpool = document.getElementById("spool").value;
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../API/Get_Issued/get_UsedQty.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var qty = xhr.responseText;
                resolve(qty);
            } else if (xhr.readyState == 4) {
                reject("Error");
            }
        };
        xhr.send(
            "selectedIdentCode=" + selectedIdentCode + "&selectedMir=" + selectedMir + "&selectedSpool=" + selectedSpool
        );
    });
}

function getQty() {
    const e = document.getElementById("qty");

    var selectedIdentCode = document.getElementById("identCode").value;
    var selectedMir = document.getElementById("Mir").value;
    var selectedSpool = document.getElementById("spool").value;


    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../API/Get_Issued/get_UsedQty.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var qty = xhr.responseText;
            e.value = qty;
            warning();
        } else if (xhr.readyState == 4) {
            reject("Error");
        }
    };
    xhr.send(
        "selectedIdentCode=" + selectedIdentCode + "&selectedMir=" + selectedMir + "&selectedSpool=" + selectedSpool + "&GetReal_Quantity=" + "active"
    );
}

// DOWNLOAD MECHANISM 
const downloadButton = document.getElementById('downloadBtn');
const process = document.getElementById('downloadProcess');
downloadButton.addEventListener('click', async () => {
    downloadButton.disabled = true;
    process.classList.replace("hidden", "block");
    // Lakukan permintaan unduhan ke halaman server yang melakukan pemrosesan data
    try {
        const response = await fetch('../Report/issuedReport.php');
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
        downloadLink.download = 'Issued.xlsx'; // Nama file yang akan diunduh
        downloadLink.click();
        // Hapus URL blob setelah file diunduh
        downloadButton.disabled = false;
        process.classList.replace("block", "hidden");
        URL.revokeObjectURL(url);
    } catch (error) {
        console.error('Terjadi kesalahan:', error);
        downloadButton.disabled = false;
        process.classList.replace("block", "hidden");
    }
});

// TABLE INITIALIZATION
async function tableInit() {
    const search = document.getElementById('search').value;
    const based_on = document.getElementById('based_on').value;

    try {
        const response = await fetch('../API/Get_Issued/usedTable.php', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "search=" + search + "&based_on=" + based_on + "&s=true"
        });

        if (response.ok) {
            document.getElementById("usedTable").innerHTML = loading;
            const data = await response.text();
            document.getElementById("usedTable").innerHTML = data;
        }
    } catch (error) {
        throw error;
    }
}

tableInit().then(() => {
    console.log('get table succeeded');
})

const searchBar = document.getElementById('searchBar') ;
// SEARCH MCHANISM 
searchBar.addEventListener('submit', async (e) => {
    e.preventDefault();
    tableInit();

})