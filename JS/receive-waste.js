const modalHandler = document.getElementById('modalButton');
const modal = document.getElementById('modal');
const cancel = document.getElementById('cancel');

// const issuedModalHandler = document.getElementById('issuedModalButton');
const issuedModal = document.getElementById('issuedModal');
const issuedCancel = document.getElementById('cancelIssued');

const loading = '<div class="flex w-full h-full items-center justify-center"><img src="../../Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';

modalHandler.addEventListener('click', () => {
    modal.classList.toggle('fixed')
    modal.classList.toggle('hidden')
})
cancel.addEventListener('click', () => {
    modal.classList.toggle('fixed')
    modal.classList.toggle('hidden')
})


issuedCancel.addEventListener('click', () => {
    issuedModal.classList.toggle('fixed')
    issuedModal.classList.toggle('hidden')
})

// INPUT MECHANISM
async function inputItems() {
    var selectedIdentCode = document.getElementById("identCode").value;
    var description = document.getElementById("description").value;
    var selectedHeatNumber = document.getElementById("heatNumber").value;
    const length = document.getElementById('length').value;
    const width = document.getElementById('width').value;
    var selectedDate = document.getElementById("date").value;
    var selectedArea = document.getElementById("area").value;
    var selectedWho = document.getElementById("user").value;

    const response = await fetch("../../API/Get_Waste/get_wasteInput.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: 'id=' + selectedIdentCode + '&desc=' + description + '&heatNumber=' + selectedHeatNumber + '&length=' + length + '&width=' + width + '&date=' + selectedDate + '&area=' + selectedArea + '&by=' + selectedWho
    });

    if (response.ok) {
        const data = await response.text();
        // console.log(data);
        getTabel();
        // document.getElementById("receiveTable").innerHTML = data;
    } else {
        throw new Error("Error fetching data");
    }
}


function searchIdentCode() {
    var selectedValue = document.getElementById("identCodeSearch").value;


    // Kirim data selectedValue ke file PHP menggunakan AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../API/Get_Receive/get_identCode.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = xhr.responseText;
            document.getElementById("identCode").innerHTML = data;
        }
    };
    xhr.send("selectedValue=" + selectedValue);
}

function getDescription() {
    var selectedValue = document.getElementById("identCode").value;

    // Kirim data selectedValue ke file PHP menggunakan AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../../API/Get_Waste/get_description.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var data = xhr.responseText;
            document.getElementById("description").value = data;
            document.getElementById("description").innerText = data;
        }
    };
    xhr.send("id=" + selectedValue);
}

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
    xhr1.send("selectedIndex=" + Index + "&process=receive");
}
    
function issuedModalPop(index) {
    issuedModal.classList.toggle('fixed')
    issuedModal.classList.toggle('hidden')

    const issuedForm = document.getElementById('issuedFormInput');
    issuedForm.addEventListener('submit', (event) => {
        issuedButton(event, index) ;
        issuedModal.classList.toggle('fixed')
        issuedModal.classList.toggle('hidden')
    })

}

function issuedButton(event, id) {
    event.preventDefault();

    // const Index = event.target.parentNode.querySelector('[name="issuedIndex"]').value;
    const Index = id;
    const date = document.getElementById('issuedDate').value;
    const nestingNo = document.getElementById('nestingNo').value;
    const user = document.getElementById('userIssued').value;

    var xhr1 = new XMLHttpRequest();
    xhr1.open("POST", "../../API/Get_Waste/get_toIssued.php", true);
    xhr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr1.onreadystatechange = function () {
        if (xhr1.readyState == 4 && xhr1.status == 200) {
            const response = xhr1.responseText;
            if (response == "deleted") {
                getTabel().then(() => {
                    createWarnIssued();
                })
            } else {
                getTabel().then(() => {
                    createWarnFailed();
                })
            }
            console.log(response);
        }
    };
    xhr1.send( "selectedIndex=" + Index + "&issuedDate=" + date + "&nestingNo=" + nestingNo + "&userIssued=" + user );
}

async function getTabel() {
    const search = document.getElementById('search').value;
    const based_on = document.getElementById('based_on').value;

    try {
        const response = await fetch('../../API/Get_Waste/wasteTable.php', {
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

const formInput = document.getElementById('formInput')
formInput.addEventListener('submit', (e) => {
    e.preventDefault();
    inputItems();
})

// SEARCH MCHANISM 
searchBar.addEventListener('submit', async (e) => {
    e.preventDefault();
    getTabel();

})

getTabel()