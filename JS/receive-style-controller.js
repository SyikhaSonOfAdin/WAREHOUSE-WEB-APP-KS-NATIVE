function imageButtonReceive(event) {
    event.preventDefault();

    const Index = event.target.parentNode.querySelector('[name="changeIndex"]').value;

    ImageModalHandler(Index);
}

function deleteImageModal() {
    const modal = document.getElementById('ImageModal').remove()
}

async function ImageModalHandler(id) {
    try {
        const response = await fetch('../API/Get_Receive/get_ImageInModal.php', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: "id=" + id
        })
        if (response.ok) {
            const data = await response.text();
            const newElement = document.createElement('div');
            newElement.id = 'ImageModal' ;
            newElement.innerHTML = data;
            document.body.appendChild(newElement);
        }
    } catch (error) {
        console.log(error);
    }
}

function uploadImage() {
    const formData = new FormData();
    const fileInput = document.getElementById('image');
    const elementId = document.getElementById('elementId').value ;

    formData.append('image', fileInput.files[0]);
    formData.append('id', elementId);

    // Buat objek XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Tangani respons dari permintaan
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText); // Tampilkan respons pada konsol
            tableInit() ;
        } else {
            console.error('Terjadi kesalahan saat mengunggah gambar.');
            tableInit() ;
        }
    }

    // Tentukan metode, URL, dan apakah asinkron
    xhr.open('POST', '../uploaded/uploadImage.php', true);

    // Kirim FormData
    xhr.send(formData);

    return false; // Mencegah form di-submit secara otomatis
}