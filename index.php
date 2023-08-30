<?php
session_start();
require './function.php';

getCookie();

$display = "hidden";
$username = "login";
$parameter = "";
if (isset($_SESSION["login"]) == "true") {
  $parameter = $_SESSION["role"];
  $username = $_SESSION["name"];
  $display = "block";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kokoh Semesta</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="./Assets/Logo_single.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400;1,700&family=Days+One&family=Inter:wght@400;700;800;900&family=Poppins:wght@100;200;300;400;500;700&display=swap"
    rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div id="navbar">
    <div id="nav-content">
      <div id="title">
        <img src="./Assets/Logo_single.png" alt="Kokoh Semesta" />
        <h1>KOKOH SEMESTA :</h1>
        <h1>KINE PROJECT</h1>
      </div>
      <div class="flex">
        <a href="./Material-Transaction/receive.php" id="login"
          class="<?php echo $display ?> text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-neutral-100 rounded">
          Material-Transaction
        </a>
        <a href="./login.php" id="login"
          class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-neutral-100 rounded">
          <?php echo $username ?>
        </a>
      </div>
    </div>
  </div>
  <form id="searchBar" class="search-form" method="post">
    <div class="relative mt-2 rounded-md shadow-sm">
      <input type="search" id="search" name="search"
        class="block mx-2 w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-400 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] sm:text-sm sm:leading-6"
        placeholder="Search by" />
      <div class="absolute inset-y-0 right-0 flex items-center">
        <select name="based_on" id="based_on"
          class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
          <option value="IDENT_CODE">IDENT CODE</option>
          <option value="description">Description</option>
        </select>
      </div>
    </div>
  </form>
  <div class="mt-4 uppercase text-start w-[83%] font-semibold text-xl text-gray-700 flex justify-between">
    Warehouse
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
      <?php if ($parameter == "manager" || $parameter == "developer"): ?>
            <a class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-[#2E3192] hover:text-white rounded"
              href="./optimize.php">
              optimize stock
            </a>
      <?php endif; ?>
      <?php if ($parameter == "manager" || $parameter == "developer"): ?>
            <button onclick="trigger()" id="modalButton"
              class="<?php echo $display ?> text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-[#2E3192] hover:text-white rounded">
              upload
            </button>
      <?php endif; ?>
    </div>
  </div>
  <?php include './Material-Transaction/component/indexForm.php' ?>
  <div id="table" class="flex justify-center sm:flex-col lg:flex-row min-h-screen">
    <div class="relative overflow-x-auto  mx-2 my-4 sm:rounded-lg bg-white flex-grow">
      <table class="w-full text-sm text-left text-gray-500 shadow-md">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
          <tr>
            <th scope="col" class="px-6 py-3">No.</th>
            <th scope="col" class="px-6 py-3">Ident Code</th>
            <th scope="col" class="px-6 py-3">Description</th>
            <th scope="col" class="px-6 py-3">MIR</th>
            <th scope="col" class="px-6 py-3">Receive</th>
            <th scope="col" class="px-6 py-3">balance</th>
            <th scope="col" class="px-6 py-3">Issued</th>
            <th scope="col" class="px-6 py-3">Stock</th>
          </tr>
        </thead>
        <tbody id="tableContent">

        </tbody>
      </table>
    </div>
  </div>

  <div id="footer">
    <h3 class="text-center">
      Copyright © 2023 Syikha Creative Production. All Right Reserved
    </h3>
  </div>
        
  <!-- SUCCESS COMPONENT -->
  <div id="successComponent" class="z-50 fixed -bottom-full p-4 bg-green-500/70 rounded-md transition-all duration-500">
        <div class="flex justify-center items-center gap-4">
          <img src="./Assets/check.png" alt="" class="w-12">
          <h1 class="text-sm font-bold text-white">
            Upload Completed Successfully
          </h1>
        </div>
    </div>
        <!-- WARNING component -->
    <div id="warn_Stock" onclick="warn_Stock_Dissapear()"
      class="z-20 fixed p-3 -right-80 flex font-semibold text-white w-[250px] h-[125px] bg-red-500 hover:scale-95 hover:bg-red-400 hover:cursor-pointer rounded-md bottom-5 items-center justify-evenly transition-all duration-200 ease-in-out">
      <div class="self-start">
        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
        <lord-icon src="https://cdn.lordicon.com/wdqztrtx.json" trigger="loop" delay="2000" colors="primary:#ffffff"
          state="hover" style="width: 50px; height: 50px">
        </lord-icon>
      </div>
      <div class="w-[90%] mx-3">
        <h5 class="font-bold">DENIED!</h5>
        <div class="text-sm font-normal">
          <strong id="icWarn">
            Inappropriate Templates!
          </strong> <br>
          <span class="text-xs">
            Please upload a file with the correct template.
          </span>
        </div>
      </div>
    </div>
  <script src="./JS/mt.js"></script>
  <script src="./JS/index.js"></script>
</body>

</html>