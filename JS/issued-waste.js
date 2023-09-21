const modalHandler = document.getElementById('modalButton') ;
const modal = document.getElementById('modal') ;
const cancel = document.getElementById('cancel') ;
const loading = '<div class="flex w-full h-full items-center justify-center"><img src="../../Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';

// modalHandler.addEventListener('click', () => {
//     modal.classList.toggle('fixed')
//     modal.classList.toggle('hidden')
// })
// cancel.addEventListener('click', () => {
//     modal.classList.toggle('fixed')
//     modal.classList.toggle('hidden')
// })

function editButtonReceive(event) {
    event.preventDefault();

    const Index = event.target.parentNode.querySelector('[name="changeIndex"]').value;

    var xhr1 = new XMLHttpRequest();
    xhr1.open("POST", "../../API/Get_Waste/get_wasteDelete.php", true);
    xhr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr1.onreadystatechange = function () {
        if (xhr1.readyState == 4 && xhr1.status == 200) {
            const response = xhr1.responseText;
            if (response == "deleted") {
                getTabel().then(() => {
                    createWarn();
                })
            } else {
                getTabel().then(() => {
                    createWarnFailed();
                })
            }
        }
    };
    xhr1.send("selectedIndex=" + Index + "&process=issued");
}

async function getTabel() {
    const search = document.getElementById('search').value;
    const based_on = document.getElementById('based_on').value;

    try {
        const response = await fetch('../../API/Get_Waste/wasteIssuedTable.php', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "search=" + search + "&based_on=" + based_on + "&s=true"
        });

        if (response.ok) {
            document.getElementById("receiveTable").innerHTML = loading;
            const data = await response.text();
            document.getElementById("receiveTable").innerHTML = data;
        }
    } catch (error) {
        throw error;
    }
}

searchBar.addEventListener('submit', async (e) => {
    e.preventDefault();
    getTabel();

})

getTabel()