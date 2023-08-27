// VARIABEL DECLARATION 
const loading = '<div class="flex fixed w-[85%] items-center justify-center"><img src="../Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';

const whatItIs = document.getElementById("searchBar");
const e = document.getElementById("historyTable");



whatItIs.addEventListener("submit", function (event) {
    event.preventDefault();

    loadData();
})




async function get_Table() {
    const what = document.getElementById("search").value;
    const based = document.getElementById("based").value;
    try {
        const response = await fetch("../API/Get_History/get_HistoryTable.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "what=" + what + "&based=" + based
        })
        if (response.ok) {
            const data = await response.text();
            e.innerHTML = data;
        }
    } catch (error) {
        console.log(error);
    }
}

function loadData() {
    e.innerHTML = loading;

    get_Table();
}

loadData();

function changeClass(clickedDiv) {
    // Cari semua elemen dengan class "div-item"
    const divItems = document.getElementsByClassName("div-item");

    // Loop melalui semua elemen dengan class "div-item"
    for (let i = 0; i < divItems.length; i++) {
        // Cek apakah elemen saat ini sama dengan elemen yang ditekan
        if (divItems[i] === clickedDiv) {
            // Jika iya, tambahkan class baru ke div yang ditekan
            divItems[i].classList.replace("h-[98px]", "h-max");
            divItems[i].classList.add("shadow-md");
            divItems[i].classList.add("scale-105");
            divItems[i].classList.add("z-10");
        } else {
            divItems[i].classList.remove("shadow-md");
            // Jika tidak, hapus class "h-max" dari elemen lainnya
            divItems[i].classList.remove("h-max");
            divItems[i].classList.remove("scale-105");
            divItems[i].classList.remove("z-10");
            // Dan tambahkan kembali class "h-[200px]"
            divItems[i].classList.add("h-[98px]");
        }
    }
}
