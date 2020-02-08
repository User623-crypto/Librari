
window.onclick=function(event)
{
    if(event.target==document.getElementById("forma"))
    document.getElementById("forma").style.display="none";
}
window.onload=function (event) {
    document.getElementById("forma").style.display="none";
    
}

function Hyr() {
    document.getElementById("hyrID").style.display="block";
    document.getElementById("rregID").style.display="none";
    document.querySelector(".mblidh .rr_h .hyr").style="background-color: rgba(155, 148, 148, 0.712);font-weight: bold;";
    document.querySelector(".mblidh .rr_h .rreg").style="background-color: rgb(240, 226, 226);font-weight:normal;";
    
    
}

function Rreg() {
    document.getElementById("hyrID").style.display="none";
    document.getElementById("rregID").style.display="block";
    document.querySelector(".mblidh .rr_h .rreg").style="background-color: rgba(155, 148, 148, 0.712);font-weight: bold;";
    document.querySelector(".mblidh .rr_h .hyr").style="background-color: rgb(240, 226, 226);font-weight:normal;";
    
}
function forma() {
    document.getElementById("forma").style.display="block";
}

