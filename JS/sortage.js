// VARIABEL DECLARATION 
const loading = '<div class="flex fixed w-[85%] items-center justify-center"><img src="../Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';

const whatItIs = document.getElementById("searchBar") ;
const e = document.getElementById("sortage") ;



whatItIs.addEventListener("submit", function(event) {
    event.preventDefault() ;

    loadData() ;
})





async function get_Table() {
    const what = document.getElementById("search").value ;
    const based = document.getElementById("based").value ;

    try {
        const response = await fetch( "../API/Get_Sortage/get_sortage.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            } ,
            body: "what=" + what + "&based=" + based 
        })
        if ( response.ok ) {
            const data = await response.text() ;
            e.innerHTML = data ;
        }
    } catch (error) {
        console.log(error) ;
    }
}

function loadData() {
    e.innerHTML = loading ;

    get_Table() ;
}

loadData() ;

// DOWNLOAD MECHANISM 
const downloadButton = document.getElementById('downloadBtn') ;
const process = document.getElementById('downloadProcess') ;
downloadButton.addEventListener('click', async () => {
    downloadButton.disabled = true;
    process.classList.replace("hidden", "block");
    // Lakukan permintaan unduhan ke halaman server yang melakukan pemrosesan data
    try {
        const response = await fetch('../Report/sortageReport.php');
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
        downloadLink.download = 'Sortage.xlsx'; // Nama file yang akan diunduh
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