<?php
session_start();
$display = "hidden";
if (isset($_SESSION["login"]) == "true") {
  $parameter = $_SESSION["role"];
  $username = $_SESSION["name"];
  if ($parameter != "helper") {
    $display = "block";
  }
} else {
  header("Location: ../../index.php");
}

require '../../function.php';
$user = "root";
$pass = "";
$db = "kokohsemesta";
$table = "material_receive_hein";


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kokoh Semesta</title>
  <link rel="stylesheet" href="../../style.css" />
  <link rel="stylesheet" href="../../src/tailwind.css">
  <link rel="icon" href="../../Assets/Logo_single.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,700&family=Days+One&family=Inter:wght@400;700;800;900&family=Poppins:wght@100;200;300;400;500;700&display=swap"
    rel="stylesheet" />
</head>

<body>

  <div id="modal" class="hidden w-full h-full z-20 bg-black/20">
      <div class="flex w-full h-full justify-center items-center">
      <form class="flex flex-col gap-3 bg-white w-[90%] md:w-1/2 lg:w-1/4 rounded px-8 p-6 shadow">
            <div class="w-full text-center text-lg uppercase font-semibold">
              Material Waste
            </div>
            <div class="w-full">
              <label for="identCode">Ident Code <span class="text-red-500">*</span></label>
              <input required type="text" id="identCode" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>
            <div class="w-full">
              <label for="hitNumber">Hit Number <span class="text-red-500">*</span></label>
              <input required type="text" id="hitNumber" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>
            <div class="w-full">
              <label for="length">Length <span class="text-red-500">*</span></label>
              <input required type="text" id="length" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>
            <div class="w-full">
              <label for="date">Date <span class="text-red-500">*</span></label>
              <input required type="date" id="date" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>
            <div class="w-full">
              <label for="area">Area <span class="text-red-500">*</span></label>
              <input required type="text" id="area" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>
            <div class="w-full">
              <input hidden required type="text" value="<?= $username ?>" id="user" class="w-1/2 px-3 py-1 outline-none rounded-s border focus:border-[#3f43bd]">
            </div>
            <div class="w-full flex gap-2 mt-4">
                <button type="submit" class="w-full py-[5px] px-[15px] bg-[#2E3192] text-white hover:bg-[#3f43bd] rounded">Submit</button>
                <button id="cancel" type="reset" class="w-full py-[5px] px-[15px] bg-[#cf3131] hover:bg-[#e24949] text-white rounded" >Cancel</button>
            </div>
        </form>
      </div>
  </div>

  <div id="navbar">
    <div id="nav-content">
      <div id="title">
        <img src="../../Assets/Logo_single.png" alt="Kokoh Semesta" />
        <h1>KOKOH SEMESTA :</h1>
        <h1>HEIN PROJECT</h1>
      </div>
      <a href="../../login.php" id="login"
        class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-neutral-100 rounded">
        <?php echo $username ?>
      </a>
    </div>
  </div>

  

  <form id="searchBar" class="search-form" action="" method="post">
    <div class="relative mt-2 rounded-md shadow-sm">
      <input type="search" id="search" name="search"
        class="block mx-2 w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-400 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] sm:text-sm sm:leading-6"
        placeholder="Search by" />
      <div class="absolute inset-y-0 right-0 flex items-center">
        <select name="based_on" id="based_on"
          class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] sm:text-sm">
          <option value="IDENT_CODE">Ident Code</option>
          <option value="mir">MIR No</option>
          <option value="qty">Quantity</option>
          <option value="tanggal">Date</option>
          <option value="uploader">By</option>
          <option value="surat_jalan">Surat Jalan</option>
        </select>
      </div>
    </div>
  </form>


  <div class="mt-4 uppercase text-start w-[83%] font-semibold text-xl text-gray-700 flex justify-between">
    Material Receive
    <div class="flex flex-col gap-1 md:flex-row">
      <button id="downloadBtn"
        class="flex flex-row gap-1 items-center text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-[#2E3192] hover:text-white rounded disabled:bg-gray-100 disabled:text-gray-400">
        <svg id="downloadProcess" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
          class="hidden" style="
            margin: auto;
            background: none;
            shape-rendering: auto;
            animation-play-state: running;
            animation-delay: 0s;
          " width="17px" height="17px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
          <circle cx="50" cy="50" fill="none" stroke="#2e3192" stroke-width="10" r="35"
            stroke-dasharray="164.93361431346415 56.97787143782138"
            style="animation-play-state: running; animation-delay: 0s">
            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s"
              values="0 50 50;360 50 50" keyTimes="0;1" style="animation-play-state: running; animation-delay: 0s">
            </animateTransform>
          </circle>
        </svg>
        <h1>download data</h1>
      </button>
      <?php if ($parameter != "helper"): ?> 
          <button id="modalButton"
            class="<?php echo $display ?> text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-[#2E3192] hover:text-white rounded">
            input
          </button>
      <?php endif; ?>
    </div>
  </div>
  <div id="table" class="flex justify-center sm:flex-col lg:flex-row">
    <div id="receiveTable" class="relative min-h-screen overflow-x-auto shadow-md mx-2 my-4 sm:rounded-lg bg-white flex-grow">
    </div>
  </div>

  <div id="footer">
    <h3 class="text-center">
      Copyright © 2023 Syikha Creative Production. All Right Reserved
    </h3>
  </div>
  
  <script src="../../JS/receive-waste.js"></script>
</body>

</html>