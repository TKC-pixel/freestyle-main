document.getElementById("start").addEventListener("click",function(e){
    document.querySelector(".popContent").style.opacity="1";
    document.body.style.background="rgba(0,0,0,0.5";
    document.querySelector(".left").style.opacity="0.5";
    document.querySelector(".right").style.opacity="0.5";
});
document.getElementById("close").addEventListener("click",function(){
    document.querySelector(".popContent").style.opacity="0";
    document.body.style.background="rgba(0,0,0,0)";
    document.querySelector(".left").style.opacity="1";
    document.querySelector(".right").style.opacity="1";
});
document.getElementById("logout").addEventListener("click", function(event) {
    event.preventDefault();
    if (confirm("Are you sure you want to logout?")) {
        window.location.href = "sign.php";
    }
});


