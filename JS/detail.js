const urlParams = new URLSearchParams(window.location.search);
const ic = urlParams.get('ic');
const p = urlParams.get('p');


async function get_Detail(p, ic) {
    const parameter = p ;
    const identCode = ic ;
    try {
        const response = await fetch("./API/Get_Detail/get_Detail.php", {
            method: "POST",
            headers:  {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "p=" + p + "&ic=" + ic
        }) ;

        if ( response.ok ) {
            const data = await response.text() ;
            document.getElementById("detail").innerHTML = data ;
        }
    } catch (err) {
        console.log(err) ;
    }
}
function loading() {
    const loadingBar = '<div class="flex w-full items-center justify-center"><img src="./Assets/Spinner-1s-200px (1).gif" class="w-[50px] md:w-[100px]" alt="Loading..."></div>';
    document.getElementById("detail").innerHTML = loadingBar ;
    get_Detail(p, ic) ;

}

loading() ;
