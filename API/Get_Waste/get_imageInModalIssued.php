<?php
session_start() ;
require '../../function.php' ;

$table = 'waste_hein_issued' ;
$connection = conn() ;
$response = '' ;

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if (isset($_POST["id"])) {
        $id = $_POST["id"] ;
        $query = "SELECT * FROM $table WHERE id = '$id'" ;
    }
    $raw = mysqli_query($connection, $query) ;
    while ($result = mysqli_fetch_assoc($raw) ) {

        $response .= '<div class="fixed left-0 top-0 w-full h-screen z-10 bg-black bg-opacity-30">
                        <div class="flex justify-center items-center w-full h-full">
                            <div class="w-[90%] md:w-[50%] lg:w-[25%] bg-white rounded flex flex-col justify-center items-center overflow-hidden">
                                <div class="w-full flex">
                                    <div class="text-xl font-bold hover:bg-red-500 p-4 hover:text-white hover:cursor-pointer" onclick="deleteImageModal()">
                                        <img src="../../Assets/x-symbol-svgrepo-com.svg" class="w-4" alt="">
                                    </div>
                                </div>
                                <form id="uploadForm" onsubmit="return uploadImage()" class="w-full flex flex-col justify-center items-center p-6 gap-4">
                                    <h1 class="font-semibold text-xl uppercase">'
                                     . $result["IDENT_CODE"] .   
                                    '</h1>
                                    <img src="../../uploaded/Receive/waste_evidence_images/' . $result["image_id"] . '" alt="">';                                    
                                    $response .= '
                                </form>          
                            </div>
                        </div>
                    </div>' ;
    }
    echo $response ;
}