var frama = 1;
shfaq(frama);

function nderro(n) {
  shfaq(frama += n);
 
}

function shfaq(n) {
 var i;
  var x = document.getElementsByClassName("frama");
  if (n > x.length) {frama = 1}
  if (n < 1) {frama = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  console.log(frama-1);
  x[frama-1].style.display = "flex";
  x[frama-1].style.justifyContent = "center";
    
}