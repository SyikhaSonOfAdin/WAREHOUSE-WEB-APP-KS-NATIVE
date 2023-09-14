<?php
require './function.php' ;
session_start();

$username = "login";
$parameter = "" ;
$display = "hidden" ;
if (isset($_SESSION["login"]) == "true") {
  $parameter = $_SESSION["role"];
  $username = $_SESSION["name"];
  $display = "block";
}


$ic = $_GET["ic"] ;
$p = $_GET["p"] ;

if ( $p == 'stock' ) {
    $p = 'remaining spool' ;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo $p ?></title>
  <link rel="stylesheet" href="./style.css" />
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
        <!-- <h1>KOKOH SEMESTA :</h1> -->
        <h1>PM2S</h1>
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
  <div class="w-[85%] flex flex-col min-h-screen py-5">
    <div class="w-full flex justify-between">
        <h1 class="text-gray-700 text-lg font-bold">
            <?php echo $ic ?>
        </h1>
        <h1 class="text-gray-700 uppercase text-lg font-black">
            <?php echo $p ?>
        </h1>
    </div>
    <div id="detail" class="relative flex-col lg:flex-row h-max flex overflow-x-auto shadow-md mx-2 my-4 rounded-lg bg-white">
        
    </div>
  </div>

  <div id="footer">
    <h3 class="text-center">
      Copyright © 2023 Syikha Creative Production. All Right Reserved
    </h3>
  </div>
  <script src="./JS/detail.js"></script>
</body>

</html>