<?php
session_start() ;
require '../../function.php' ;

$table = 'material_receive_hein' ;
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
                                        <img src="../Assets/x-symbol-svgrepo-com.svg" class="w-4" alt="">
                                    </div>
                                </div>
                                <form id="uploadForm" onsubmit="return uploadImage()" class="w-full flex flex-col justify-center items-center p-6 gap-4">
                                    <h1 class="font-semibold text-xl uppercase">'
                                     . $result["IDENT_CODE"] .   
                                    '</h1>
                                    <img src="../Uploaded/Receive/Images/' . $result["image_id"] . '" alt="">
                                    <div class="">' ;
                                    if ($_SESSION["role"] != 'helper') {
                                    $response .= '<label
                                    for="formFile"
                                    class="mb-2 inline-block text-neutral-700"
                                    >Select Image File!</label
                                    >
                                    <input
                                        class="relative m-0 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none "
                                        type="file"
                                        id="image" />
                                    </div>
                                    <button type="button" onclick="uploadImage()" class="w-full py-2 bg-[#2E3192] text-white font-semibold border rounded">Upload</button>
                                    <input type="hidden" value="' . $result["id"] . '" name="id" id="elementId" class="w-full border outline-none rounded">' ;    
                                    }
                                    $response .= '
                                </form>          
                            </div>
                        </div>
                    </div>' ;
    }
    echo $response ;
}