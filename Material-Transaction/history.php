<?php
session_start() ;
$display = "hidden";
if ( isset($_SESSION["login"]) == "true" ) {
  $parameter = $_SESSION["role"];
  $username = $_SESSION["name"] ;
  $display = "block" ;
} else {
  header("Location: ../index.php") ;
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
  <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
</head>

<body>
  <div id="navbar">
    <div id="nav-content">
      <div id="title">
        <img src="../Assets/Logo_single.png" alt="Kokoh Semesta" />
        <h1>KOKOH SEMESTA :</h1>
        <h1>KINE PROJECT</h1>
      </div>
      <a href="../login.php" id="login"
        class="text-xs text-gray-700 uppercase border font-bold mx-3 py-[5px] px-[15px] bg-white hover:bg-neutral-100 rounded">
        <?php echo $username ?>
      </a>
    </div>
  </div>

  <form id="searchBar" class="search-form"  action="" method="post">
    <div class="relative mt-2 rounded-md shadow-sm">
      <input type="search" id="search" name="search"
      class="block mx-2 w-full rounded-md border-0 py-1.5 pl-7 pr-20 text-gray-400 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] sm:text-sm sm:leading-6"
        placeholder="Search by" />
      <div class="absolute inset-y-0 right-0 flex items-center">
        <select name="based_on" id="based"
        class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] sm:text-sm">
          <option value="IDENT_CODE">Ident Code</option>
          <option value="spool">Spool No</option>
        </select>
      </div>
    </div>
  </form>
  <?php include './component/menu.php' ?>
  <div class="mt-4 uppercase text-start w-[83%] font-semibold text-xl text-gray-700 flex justify-between">
    Material Transaction History
  </div>
  
  <div id="history" class="w-[85%] flex flex-col min-h-screen flex-wrap gap-2 lg:flex-row">
    <div id="historyTable" class="w-[100%] ">
    </div>
  </div>

  <div id="footer">
    <h3 class="text-center">
      Copyright © 2023 Syikha Creative Production. All Right Reserved
    </h3>
  </div>
  <script src="../JS/history.js"></script>
</body>

</html>