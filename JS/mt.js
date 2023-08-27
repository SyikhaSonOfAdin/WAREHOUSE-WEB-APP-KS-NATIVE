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

const element = document.getElementById("warn_Delete")
// LAIN LAIN
function warn_Delete() {
    element.classList.replace("-right-80", "right-5")
    setTimeout(function () {
        element.classList.replace("right-5", "-right-80")
    }, 5000)
}
function warn_Delete_Dissapear() {
    element.classList.replace("right-5", "-right-80")
}






