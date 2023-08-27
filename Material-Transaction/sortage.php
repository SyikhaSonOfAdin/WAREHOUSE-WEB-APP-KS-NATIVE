<?php
session_start();
$display = "hidden";
if (isset($_SESSION["login"]) == "true") {
  $parameter = $_SESSION["role"];
  $username = $_SESSION["name"];
  $display = "block";
} else {
  header("Location: ../index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kokoh Semesta</title>
  <link rel="stylesheet" href="../style.css" />
  <link rel="icon" href="../Assets/Logo_single.png" />
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
        <img src="../Assets/Logo_single.png" alt="Kokoh Semesta" />
        <h1>KOKOH SEMESTA :</h1>
        <h1>HEIN PROJECT</h1>
      </div>
      <a href="../login.php" id="login"
        class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-neutral-100 rounded">
        <?php echo $username ?>
      </a>
    </div>
  </div>

  <?php include './component/alert.php' ?>

  <form id="searchBar" class="search-form" action="" method="post">
    <div class="relative mt-2 rounded-md shadow-sm">
      <input type="search" id="search" name="search"
        class="block mx-2 w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-400 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] sm:text-sm sm:leading-6"
        placeholder="Search by" />
      <div class="absolute inset-y-0 right-0 flex items-center">
        <select name="based_on" id="based"
          class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] sm:text-sm">
          <option value="batch">MIR No</option>
          <option value="IDENT_CODE">IDENT CODE</option>
        </select>
      </div>
    </div>
  </form>
  <?php include './component/menu.php' ?>
  <div class="mt-4 uppercase text-start w-[83%] font-semibold text-xl text-gray-700 flex justify-between">
    Sortage Material
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
    </div>
  </div>

  <div id="history" class="w-[85%] min-h-screen flex flex-col flex-wrap gap-2 lg:flex-row">
    <div id="sortage" class="relative w-full h-max flex overflow-x-auto shadow-md mx-2 my-4 rounded-lg bg-white">
    </div>
  </div>

  <div id="footer">
    <h1 class="text-center">
      This App is on develop! please report immediately if you found bug!
    </h1>
    <h3 class="text-center">
      Copyright © 2023 Syikha Creative Production. All Right Reserved
    </h3>
  </div>
  <script src="../JS/sortage.js"></script>
</body>

</html>