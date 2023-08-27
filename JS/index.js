// VARIABEL DECLARATION 
const loading = '<div class="flex fixed w-[85%] items-center justify-center"><img src="./Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';

tableSummary();

// SUMMARY PAGE FUNCTION DECLARATION
async function get_summaryData() {
    const selectedValue = document.getElementById("search").value;
    const based_on = document.getElementById("based_on").value;

    try {
        const response = await fetch("./API/Get_WareHouse/get_warehouseTable.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "search=" + selectedValue + "&based_on=" + based_on
        });

        if (response.ok) {
            const data = await response.text();
            document.getElementById("tableContent").innerHTML = data;
            document.getElementsByTagName("body")[0].classList.remove("overflow-hidden");
        } else {
            throw new Error("Error fetching data");
        }
    } catch (error) {
        console.error(error);
    }
}


function tableSummary() {
    document.getElementsByTagName("body")[0].classList.add("overflow-hidden");
    document.getElementById("tableContent").innerHTML = loading;

    get_summaryData();
}



// SUMMARY PAGE ONLY
const search = document.getElementById("searchBar");
search.addEventListener("submit", function (event) {
    event.preventDefault();

    tableSummary()
})
// DOWNLOAD MECHANISM 
const downloadButton = document.getElementById('downloadBtn') ;
const process = document.getElementById('downloadProcess') ;
downloadButton.addEventListener('click', async () => {
    downloadButton.disabled = true;
    process.classList.replace("hidden", "block");
    // Lakukan permintaan unduhan ke halaman server yang melakukan pemrosesan data
    try {
        const response = await fetch('./Report/warehouseReport.php');
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
        downloadLink.download = 'Warehouse.xlsx'; // Nama file yang akan diunduh
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