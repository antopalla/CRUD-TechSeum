var slideIndex = 0;

function plusDivs(n) {
  mostraImmagine(slideIndex += n);
}

function mostraImmagine(n) {
  var immagini = document.getElementsByClassName("mySlides");
  if (n >= immagini.length) {
      slideIndex = 0;
  }
  if (n < 0) {
      slideIndex = immagini.length - 1;
  }
  document.getElementById("immagineDaMostrare").src = immagini[slideIndex].src;
}
