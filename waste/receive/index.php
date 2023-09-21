<?php
session_start();
require '../../function.php';

getCookie();

$display = "hidden";
$username = "login";
$parameter = "helper";
if (isset($_SESSION["login"]) == "true") {
  $parameter = $_SESSION["role"];
  $username = $_SESSION["name"];
  $display = "block";
}

$resultNew = selectAll("material_kine");

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

  <!-- MODAL FOR INPUT ITEMS -->
  <div id="modal" class="hidden w-full h-full z-20 bg-black/20">
      <div class="flex w-full h-full justify-center items-center">
      <form id="formInput" class="flex flex-col gap-3 bg-white w-[90%] md:w-1/2 lg:w-1/4 rounded px-8 p-6 shadow">
            <div class="w-full text-center text-lg uppercase font-semibold">
              Material Waste Transaction
            </div>
            <div class="w-full">
              <label for="identCode">Ident Code <span class="text-red-500">*</span></label>
              <div class="w-full flex">
              <input type="text" id="identCodeSearch" oninput="searchIdentCode()" placeholder="Ident Code"
                    class="pl-2 border-r-0 border border-gray-300 text-gray-600 font-medium w-[50%] rounded-s focus:outline-0  focus:ring focus:ring-[#2E3192] focus:border-[#2E3192]">
                <div class="right-0 w-[60%]">
                    <select name="identcode" id="identCode"
                        class="border border-gray-300 text-gray-600 font-semibold text-sm rounded-e focus:outline-0  focus:ring focus:ring-[#2E3192] focus:border-[#2E3192] block w-full p-2.5"
                        placeholder="..." onchange="getDescription()" required>
                        <option value="">-</option>
                        <?php while ($id = mysqli_fetch_assoc($resultNew)): ?>
                                <option value="<?php echo $id["IDENT_CODE"]; ?>"><?php echo $id["IDENT_CODE"]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
              </div>
            </div>
            <div class="w-full">
              <textarea disabled id="description" cols="30" rows="2" class="w-full px-3 py-1 text-sm outline-none rounded border disabled:opacity-50"></textarea>
              <!-- <input disabled type="text" id="description" class="w-full px-3 py-1 outline-none rounded border disabled:opacity-50"> -->
            </div>
            <div class="w-full">
              <label for="heatNumber">Heat Number <span class="text-red-500">*</span></label>
              <input required type="text" id="heatNumber" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>
            <div class="w-full flex">
              <div class="w-full">
                <label for="length">Length <span class="text-red-500">*</span></label>
                <input required type="text" id="length" placeholder="MM" class="w-full px-3 py-1 border-r-0 outline-none rounded-s border focus:ring focus:ring-[#3f43bd]">
              </div>
              <div class="w-full">
                <label for="width">Width</label>
                <input type="text" id="width"  placeholder="MM" class="w-full px-3 py-1 outline-none rounded-e border focus:ring focus:ring-[#3f43bd]">
              </div>
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

  <!-- MODAL FOR ISSUED ITEMS -->
  <div id="issuedModal" class="hidden w-full h-full z-20 bg-black/20">
      <div class="flex w-full h-full justify-center items-center">
      <form id="issuedFormInput" class="flex flex-col gap-3 bg-white w-[90%] md:w-1/2 lg:w-1/4 rounded px-8 p-6 shadow">
            <div class="w-full text-center text-lg uppercase font-semibold">
              Issued Waste
            </div>
              
            <div class="w-full">
              <label for="heatNumber">Nesting No <span class="text-red-500">*</span></label>
              <input required type="text" id="nestingNo" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>            
            <div class="w-full">
              <label for="date">Date <span class="text-red-500">*</span></label>
              <input required type="date" id="issuedDate" class="w-full px-3 py-1 outline-none rounded border focus:ring focus:ring-[#3f43bd]">
            </div>            
            <div class="w-full">
              <input hidden required type="text" value="<?= $username ?>" id="userIssued" class="w-1/2 px-3 py-1 outline-none rounded-s border focus:border-[#3f43bd]">
            </div>
            <div class="w-full flex gap-2 mt-4">
                <button type="submit" class="w-full py-[5px] px-[15px] bg-[#2E3192] text-white hover:bg-[#3f43bd] rounded">Submit</button>
                <button id="cancelIssued" type="reset" class="w-full py-[5px] px-[15px] bg-[#cf3131] hover:bg-[#e24949] text-white rounded" >Cancel</button>
            </div>
        </form>
      </div>
  </div>

  <div id="navbar">
    <div id="nav-content">
      <div id="title">
        <img src="../../Assets/Logo_single.png" alt="Kokoh Semesta" />
        <h1>KMS :</h1>
        <h1>KINE PROJECT</h1>
      </div>
      <div class="flex">
      <?php if (isset($_SESSION["login"]) == "true"): ?>           
          <a href="../issued/" id="login"
            class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-neutral-100 rounded">
            Waste Issued
          </a>
      <?php endif; ?>
        <a href="../../login-waste.php" id="login"
          class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-neutral-100 rounded">
          <?php echo $username ?>
        </a>
      </div>      
    </div>
  </div>

  

  <form id="searchBar" class="search-form" action="" method="post">
    <div class="relative mt-2 rounded-md shadow-sm">
      <input type="search" id="search" name="search"
        class="block mx-2 w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-400 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-0  focus:ring-2 focus:ring-[#2E3192] sm:text-sm sm:leading-6"
        placeholder="Search by" />
      <div class="absolute inset-y-0 right-0 flex items-center">
        <select name="based_on" id="based_on"
          class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:outline-0  focus:ring-2 focus:ring-[#2E3192] sm:text-sm">
          <option value="IDENT_CODE">Ident Code</option>
          <option value="heatNumber">Heat Number</option>
          <option value="length">Length</option>
          <option value="width">Width</option>
          <option value="date">Date</option>
          <option value="uploader">By</option>
          <option value="area">Area</option>
        </select>
      </div>
    </div>
  </form>


  <div class="mt-4 uppercase text-start w-[83%] font-semibold text-xl text-gray-700 flex justify-between">
    Waste Material
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
                class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-[#2E3192] hover:text-white rounded">
                input
              </button>
      <?php else : ?>
        <button id="modalButton"
          class="hidden text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-[#2E3192] hover:text-white rounded">
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
  
  <script src="../../JS/mt.js"></script>
  <script src="../../JS/receive-waste.js"></script>
  <script src="../../JS/receive-waste-style-controller.js"></script>
</body>

</html>