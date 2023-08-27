function uploadImage() {
    const formData = new FormData();
    const fileInput = document.getElementById('image');
    const elementId = document.getElementById('elementId').value ;

    // Pastikan ada gambar yang dipilih sebelum melanjutkan
    if (fileInput.files.length === 0) {
        document.getElementById('status').textContent = 'Pilih gambar terlebih dahulu.';
        return;
    }

    formData.append('image', fileInput.files[0]);
    formData.append('id', elementId);

    // Buat objek XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Tentukan metode, URL, dan apakah asinkron
    xhr.open('POST', 'upload.php', true);

    // Tangani kejadian saat permintaan selesai
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('status').textContent = xhr.responseText;
        } else {
            document.getElementById('status').textContent = 'Terjadi kesalahan saat mengunggah gambar.';
        }
    };

    // Kirim FormData
    xhr.send(formData);
}

const form = document.getElementById('uploadForm').addEventListener('submit', (e) => {
    e.preventDefault() ;

    uploadImage() ;
})

function deleteImageModal() {
    const modal = document.getElementById('ImageModal').remove()
}

// function activateInputImageModal() {
//     // Buat elemen <div> utama
//     const modalOverlay = document.createElement('div');
//     modalOverlay.className = 'fixed top-0 w-full h-screen z-10 bg-black bg-opacity-30';

//     // Buat elemen <div> konten
//     const modalContent = document.createElement('div');
//     modalContent.className = 'flex justify-center items-center w-full h-full';
//     modalContent.setAttribute('data-aos', 'fade-down');
//     modalContent.setAttribute('data-aos-delay', '500');

//     // Buat elemen <div> panel
//     const modalPanel = document.createElement('div');
//     modalPanel.className = 'w-[90%] md:w-[50%] lg:w-[25%] bg-white p-6 flex flex-col justify-center items-center gap-4';

//     // Buat elemen <img>
//     const imageElement = document.createElement('img');
//     imageElement.src = '../Assets/Logo_single.png';
//     imageElement.alt = '';

//     // Buat elemen <input>
//     const inputElement = document.createElement('input');
//     inputElement.type = 'file';
//     inputElement.className = 'w-full border outline-none rounded';

//     // Susun elemen-elemen
//     modalPanel.appendChild(imageElement);
//     modalPanel.appendChild(inputElement);
//     modalContent.appendChild(modalPanel);
//     modalOverlay.appendChild(modalContent);

//     // Masukkan elemen modalOverlay ke dalam dokumen
//     document.body.appendChild(modalOverlay);

//     AOS.refresh();
// }

