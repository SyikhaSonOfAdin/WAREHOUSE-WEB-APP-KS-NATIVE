// FUNGSI UNTUK MEMUNCULKAN FORM
const trigger = () => {
    modalbg.style = "display : flex;";
    document.body.style.overflow = 'hidden';
}


// FUNGSI UNTUK MENGHILANGKAN FORM
const dissapear = () => {
    modalbg.style = "display : none;"
    document.body.style.overflow = 'auto';
    document.getElementById("modal").style.display = "flex";
    document.getElementById("newID").style.display = "none";
}
const changeForm = () => {
    document.getElementById("modal").style.display = "none";
    document.getElementById("newID").style.display = "flex";
}

// LAIN LAIN
function warn_Delete() {

    const element = document.querySelectorAll('[id="warn_Delete"]');
    element.forEach((warning) => {
        warning.classList.replace("-right-80", "right-5") ;
        setTimeout(function () {
            warning.classList.replace("right-5", "-right-80")
        }, 5000)
    })
    
}
function warn_Delete_Dissapear() {
    const element = document.getElementById("warn_Delete")
    element.classList.replace("right-5", "-right-80")
}

function createWarn() {
    // Buat elemen <div>
    var warnDelete = document.createElement("div");

    // Atur atribut dan kelas
    warnDelete.id = "warn_Delete";
    warnDelete.className = "fixed flex font-semibold text-white w-[250px] h-[60px] bg-red-500 hover:bg-red-400 hover:cursor-pointer rounded-md -right-80 bottom-5 items-center justify-evenly transition-all duration-500 ease-in-out z-50";
    warnDelete.onclick = warn_Delete_Dissapear;

    // Buat elemen <div> dalam elemen <div> utama
    var innerDiv = document.createElement("div");
    innerDiv.className = "flex items-center justify-center w-6 h-6 rounded-full border-[3px] border-white";
    innerDiv.textContent = "i";
    warnDelete.appendChild(innerDiv);

    var textNode = document.createTextNode("Data has been deleted");
    warnDelete.appendChild(textNode);

    // Tambahkan elemen <div> ke dalam dokumen
    document.body.appendChild(warnDelete);
    setTimeout(() => {
        warn_Delete()
    }, 100)
}





