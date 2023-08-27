
<div class="fixed z-10 w-full h-full bg-black bg-opacity-40 items-center hidden" id="modalbg">
    <?php if ($parameter == "manager" || $parameter == "developer"): ?>
        <div class="mb-3 fixed z-10 w-full h-full bg-black bg-opacity-20 items-center" id="newID">
            <form action="./uploaded/excel.php" method="post" enctype="multipart/form-data"
                class="absolute z-20 bg-white my-8 w-[90%] md:w-[40%] shadow-lg border border-gray-300 p-8 flex flex-col items-center rounded-lg lg:w-[25%]"
                style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                <div
                    class="mb-3 flex font-semibold p-3 text-white w-full h-max bg-red-500 hover:bg-red-400 rounded-md items-center justify-evenly transition-all duration-200 ease-in-out">
                    <div class="w-[93%]">
                        <h4 class="w-full text-center border-b border-b-white mb-2">WARNING!</h4>
                        <div class="text-sm font-normal text-justify">You will be making <strong>changes to all existing
                                data in the table</strong>. Therefore, please ensure that you have downloaded all the
                            existed data and modified it according to your needs! Also, make sure that the column headers
                            comply with the specified requirements.</div>
                    </div>
                </div>
                <label for="formFile" class="mb-2 inline-block text-neutral-700">
                    Only Excel or .xlsx, .xls File! with right Template!
                </label>
                <input
                    class="relative mb-3 block w-full min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none disabled:cursor-not-allowed disabled:opacity-50"
                    type="file" id="formFile" name="excelFile" accept=".xlsx, .xls" required />
                <input type="submit" value="Upload"
                    class="w-full mx-3 mb-3 py-[5px] px-[15px] bg-[#2E3192] text-white hover:bg-[#3f43bd] rounded" />
                <input type="reset" value="Cancel" onclick="dissapear()"
                    class="w-full mx-3 mb-3 py-[5px] px-[15px] bg-[#cf3131] hover:bg-[#e24949] text-white rounded" />
            </form>
        </div>
    <?php endif; ?>
</div>

</div>