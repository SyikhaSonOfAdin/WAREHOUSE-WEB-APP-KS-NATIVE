// DECLARATION VARIABEL
document.getElementById("Mir").disabled = true;
const downloadButton = document.getElementById('downloadBtn') ;
const process = document.getElementById('downloadProcess') ;
const searchBar = document.getElementById('searchBar') ;
const loading = '<div class="flex w-full h-full items-center justify-center"><img src="../Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';


// DELETE FUNCTION
async function getReceiveTableContent() {
  var selectedIdentCode = document.getElementById("identCode").value;
  var selectedMIR = document.getElementById("Mir").value;
  var selectedDate = document.getElementById("date").value;
  var selectedQty = document.getElementById("qty").value;
  var selectedSuratJalan = document.getElementById("by").value;
  var selectedWho = document.getElementById("by_who").value;

  const response = await fetch("../API/Get_Receive/receiveTable.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "selectedIdentCode=" + selectedIdentCode + "&selectedMIR=" + selectedMIR + "&selectedDate=" + selectedDate + "&selectedQty=" + selectedQty + "&selectedSuratJalan=" + selectedSuratJalan + "&selectedWho=" + selectedWho
  });

  if (response.ok) {
    const data = await response.text();
    document.getElementById("receiveTable").innerHTML = data;
  } else {
    throw new Error("Error fetching data");
  }
}

function editButtonReceive(event) {
  event.preventDefault();

  const Index = event.target.parentNode.querySelector('[name="changeIndex"]').value;

  var xhr1 = new XMLHttpRequest(); 
  xhr1.open("POST", "../API/Get_Receive/get_receivepageEdit.php", true);
  xhr1.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr1.onreadystatechange = function () {
    if (xhr1.readyState == 4 && xhr1.status == 200) {
      if (document.getElementById('search').value != '') {
        tableInit() ;
      } else {
        getReceiveTableContent();
      }
      console.log(Index)
      createWarn() ;
    }
  };
  xhr1.send("selectedIndex=" + Index);
}




// FUNGSI FUNGSI FORM RECEIVE
const form = document.getElementById("modal") ;
form.addEventListener("submit", (event) => {
  event.preventDefault() ;

  getReceiveTableContent() ;
  getDropdown2Options() ;
})

function searchIdentCode() {
  var selectedValue = document.getElementById("identCodeSearch").value;


  // Kirim data selectedValue ke file PHP menggunakan AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../API/Get_Receive/get_identCode.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var data = xhr.responseText;
      document.getElementById("identCode").innerHTML = data;
    }
  };
  xhr.send("selectedValue=" + selectedValue);
}

function getDropdown2Options() {
  var selectedValue = document.getElementById("identCode").value;

  // Kirim data selectedValue ke file PHP menggunakan AJAX
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../API/Get_Receive/get_mir.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var data = xhr.responseText;
      document.getElementById("Mir").innerHTML = data;
      document.getElementById("Mir").disabled = false;
      document.getElementById("Mir").classList.remove("hover:cursor-not-allowed");
    }
    else {
      document.getElementById("Mir").disabled = true;
      document.getElementById("Mir").classList.add("hover:cursor-not-allowed");
    }
  };
  xhr.send("selectedValue=" + selectedValue);
}

function getQty() {
  var selectedICValue = document.getElementById("identCode").value;
  var selectedMIRValue = document.getElementById("Mir").value;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "../API/Get_Receive/get_receiveqty.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      var data = xhr.responseText;
      document.getElementById("qty").value = data;
    }
  };
  xhr.send("selectedICValue=" + selectedICValue + "&selectedMIRValue=" + selectedMIRValue);
}


// DOWNLOAD MECHANISM 
downloadButton.addEventListener('click', async () => {
    downloadButton.disabled = true;
    process.classList.replace("hidden", "block");
    // Lakukan permintaan unduhan ke halaman server yang melakukan pemrosesan data
    try {
        const response = await fetch('../Report/receiveReport.php');
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
        downloadLink.download = 'Receive.xlsx'; // Nama file yang akan diunduh
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

// TABLE INITIALIZATION
async function tableInit() {
  const search = document.getElementById('search').value ;
  const based_on = document.getElementById('based_on').value ;

  try {
    const response = await fetch('../API/Get_Receive/receiveTable.php', {
      method: 'POST' ,
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "search=" + search + "&based_on=" + based_on + "&s=true"
    }) ;

    if (response.ok) {
      document.getElementById("receiveTable").innerHTML = loading ;
      const data = await response.text() ;
      document.getElementById("receiveTable").innerHTML = data ;
    }
  } catch (error) {
    throw error;
  }
}

tableInit().then(() => {
  console.log('get table succeeded');
})

// SEARCH MCHANISM 
searchBar.addEventListener('submit', async (e) => {
  e.preventDefault();
  tableInit() ;

})