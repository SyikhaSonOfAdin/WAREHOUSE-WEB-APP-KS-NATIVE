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