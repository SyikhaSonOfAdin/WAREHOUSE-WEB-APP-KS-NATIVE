const modalBg  = document.getElementById('modal-bg') ;
const modalBg2 = document.getElementById('modal-bg-input') ;

const trigger = () => {
    modalBg.classList.toggle('hidden');
    modalBg.classList.toggle('fixed');
}
const triggerInput = () => {
    modalBg2.classList.toggle('hidden');
    modalBg2.classList.toggle('fixed');
}

function deleteItems(element) {
    const items_id = element.getAttribute('items-id') ;
    toDelete(items_id) ;
}

async function toDelete(items_id) {
    try {
        const response = await fetch('../API/Get_Reservation/get_DeleteItems.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'id=' + items_id
        })
        if (response.ok) {
            const result = await response.text() ;
            if ( result != 'denied' ) {
                // console.log(result) ;
                createWarn() ;
                get_mirSpoolData() ;
            }
        }
    } catch (err) {
        console.log(err) ;
    }
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






