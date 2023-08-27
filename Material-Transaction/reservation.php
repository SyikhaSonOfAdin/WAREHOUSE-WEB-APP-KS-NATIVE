<?php
session_start();
$display = "hidden";
if (isset($_SESSION["login"]) == "true") {
    $parameter = $_SESSION["role"];
    $username = $_SESSION["name"];
    if ($parameter == "manager" || $parameter == "developer") {
        $display = "block";
    }
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
                <h1>KINE PROJECT</h1>
            </div>
            <a href="../login.php" id="login"
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
                    class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#2E3192] sm:text-sm">
                    <option value="IDENT_CODE">IDENT CODE</option>
                    <option value="batch">MIR No</option>
                    <option value="spool">Spool</option>
                    <option value="bm_qty">Quantity</option>
                </select>
            </div>
        </div>
    </form>


    <?php include './component/menu.php' ?>
    <?php if ($parameter == "manager" || $parameter == "developer"): ?>
        <div class="w-[85%] flex flex-col lg:flex-row lg:justify-center">
            <div class="mb-3">
                <label for="formFile" class="mb-2 inline-block text-neutral-700">Upload Excel file that contains Ident Code
                    with Spool in it!</label>
                <form action="../uploaded/excel_Reservation.php" method="post" enctype="multipart/form-data"
                    class="flex flex-col md:flex-row">
                    <input
                        class="relative mb-3 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                        type="file" id="formFile" name="excelFile" accept=".xlsx, .xls" />
                    <input type="submit" value="Upload"
                        class="mx-3 mb-3 py-[5px] px-[15px] bg-gray-300 text-gray-500 hover:bg-[#2E3192] hover:text-white hover:border-[#2E3192] rounded disabled:cursor-not-allowed disabled:opacity-50" />
                </form>
            </div>
        </div>
    <?php endif; ?>

    <div class="mt-4 uppercase text-start w-[83%] font-semibold text-xl text-gray-700 flex justify-between">
        Reservation
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
                            values="0 50 50;360 50 50" keyTimes="0;1"
                            style="animation-play-state: running; animation-delay: 0s">
                        </animateTransform>
                    </circle>
                </svg>
                <h1>download data</h1>
            </button>
        </div>
    </div>
    <div id="table" class="flex flex-col justify-center min-h-screen lg:flex-row">
        <div class="relative h-max flex overflow-x-auto shadow-md mx-2 my-4 rounded-lg bg-white flex-grow">
            <table class="w-full h-max text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">MIR No</th>
                        <th scope="col" class="px-6 py-3">Spool</th>
                        <th scope="col" class="px-6 py-3">Ident Code</th>
                        <th scope="col" class="px-6 py-3">Quantity</th>
                    </tr>
                </thead>
                <tbody id="mirSpoolTable">

                </tbody>
            </table>
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
    <script src="../JS/allData.js"></script>
</body>

</html>