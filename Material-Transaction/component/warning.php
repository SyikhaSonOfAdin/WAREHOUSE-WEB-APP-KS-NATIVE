<div id="warn_Stock"
    onclick="warn_Stock_Dissapear()"
    class="z-20 fixed p-3 -right-80 flex font-semibold text-white w-[250px] h-[125px] bg-red-500 hover:scale-95 hover:bg-red-400 hover:cursor-pointer rounded-md bottom-5 items-center justify-evenly transition-all duration-200 ease-in-out">
    <div class="self-start">
        <script src="https://cdn.lordicon.com/bhenfmcm.js"></script>
        <lord-icon src="https://cdn.lordicon.com/wdqztrtx.json" trigger="loop" delay="2000" colors="primary:#ffffff"
            state="hover" style="width: 50px; height: 50px">
        </lord-icon>
    </div>
    <div class="w-[90%] mx-3">
        <h5>WARNING!</h5>
        <div class="text-sm font-normal">Exceeding warehouse stock!<br><strong id="icWarn">Ident Code</strong> <br> Stock : <span id="stockWarn"></span></div>
    </div>
</div>
<script>
    const element2 = document.getElementById("warn_Stock");
    function warn_Stock(ic, stock) {
        document.getElementById("icWarn").innerText = ic ;
        document.getElementById("stockWarn").innerText = stock ;
        element2.classList.replace("-right-80", "right-5");
        setTimeout(function () {
            element2.classList.replace("right-5", "-right-80");
        }, 10000);
    }
    function warn_Stock_Dissapear() {
        element2.classList.replace("right-5", "-right-80");
    }
</script>