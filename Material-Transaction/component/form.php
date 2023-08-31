<?php
$resultNew = selectAll("material_kine");
?>

<div class="fixed z-10 w-full h-full bg-black bg-opacity-40 items-center hidden" id="modalbg">
    <form method="post" action="" id="modal"
        class="absolute z-20 bg-white my-8 w-[40%] shadow-lg border border-gray-300 p-8 flex flex-col items-center rounded-lg lg:w-[25%]"
        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="mb-6 w-full text-xl font-semibold uppercase text-gray-700 flex">
            <img src="../Assets/Logo_single.png" alt="" class="w-7 mr-2">
            material receive
        </div>
        <div class="mb-6 w-full">
            <label for="identCode" class="block mb-2 text-sm text-gray-900">Ident Code *</label>
            <div class="w-full flex">
                <input type="text" id="identCodeSearch" oninput="searchIdentCode()" placeholder="Ident Code"
                    class="bg-gray-50 pl-2 border-r-0 border border-gray-300 text-gray-600 font-medium w-[50%] rounded-l-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] focus:border-[#2E3192]">
                <div class="right-0 w-[60%]">
                    <select name="identcode" id="identCode"
                        class="bg-gray-50 border border-gray-300 text-gray-600 font-semibold text-sm rounded-r-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] focus:border-[#2E3192] block w-full p-2.5"
                        placeholder="" onchange="getDropdown2Options()" required>
                        <option value="">-</option>
                        <?php while ($id = mysqli_fetch_assoc($resultNew)): ?>
                            <option value="<?php echo $id["IDENT_CODE"]; ?>"><?php echo $id["IDENT_CODE"]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-6 w-full">
            <label for="Mir" class="block mb-2 text-sm font-medium text-gray-900">MIR No.*</label>
            <select name="mir" id="Mir" onchange="getQty()"
                class="bg-gray-50 border border-gray-300 text-gray-600 font-semibold text-sm rounded-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] focus:border-[#2E3192] block w-full p-2.5 hover:cursor-not-allowed"
                required>
            </select>
        </div>

        <div class="w-full mb-6">
            <label for="date" class="block mb-2 text-sm font-medium text-gray-900">Date *</label>
            <input datepicker name="date" id="date" type="date"
                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] focus:border-[#2E3192] block pl-10 p-2.5"
                placeholder="Select date" required />
        </div>
        <div class="w-full flex justify-between mb-3">
            <div class="w-full mr-1">
                <label for="qty" class="block mb-2 text-sm font-medium text-gray-900">Quantity *</label>
                <input name="qty" type="text" id="qty"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] focus:border-[#2E3192] block w-full p-2.5"
                    placeholder="" required />
            </div>
            <div class="w-full ml-1">
                <label for="suratJalan" class="block mb-2 text-sm font-medium text-gray-900">Surat Jalan</label>
                <input name="suratJalan" type="text" id="by"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] focus:border-[#2E3192] block w-full p-2.5"
                    placeholder="" />
            </div>
           
        </div>
        <div class="w-full mb-3">
            <label for="area" class="block mb-2 text-sm font-medium text-gray-900">Area</label>
                <input name="area" id="area" type="text"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-0 focus:ring-inset focus:ring-2 focus:ring-[#2E3192] focus:border-[#2E3192] block p-2.5"
                    placeholder="Area" />

        </div>
        <input hidden name="by" id="by_who" type="text" value="<?php echo $username ?>" />
        <!-- CHANGE FORM -->
        <?php if ($parameter == "manager" || $parameter == "developer"): ?>
            <!-- <div class="w-full text-sm text-red-500 mb-3 hover:cursor-pointer hover:underline" onclick="changeForm()">
                Upload data here!
            </div> -->
        <?php endif; ?>
        <div class="w-full flex justify-between">
            <button name="tombolSubmit" type="submit"
                class="mr-1 text-white font-semibold bg-[#2E3192] hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Submit
            </button>
            <button onclick="dissapear()" type="reset"
                class="ml-1 text-white font-semibold bg-[#cf3131] hover:bg-[#e24949] focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
                Cancel
            </button>
        </div>
    </form>

    <?php if ($parameter == "manager" || $parameter == "developer"): ?>
        <div class="mb-3 fixed z-10 w-full h-full bg-black bg-opacity-20 items-center hidden" id="newID">
            <form action="../uploaded/excel_Receive.php" method="post" enctype="multipart/form-data"
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
                <input type="button" value="Cancel" onclick="dissapear()"
                    class="w-full mx-3 mb-3 py-[5px] px-[15px] bg-[#cf3131] hover:bg-[#e24949] text-white rounded" />
            </form>
        </div>
    <?php endif; ?>

</div>