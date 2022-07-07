//Carrousel automatique
const container = document.getElementsByClassName("carrousel_container_manuel");
let btnClasse = document.getElementsByClassName("bouton_manuel");
let totalImages = 5; //5 images
let tailleWidth = 20; //100% = taille container
let unite = "%"; //unite (px,%,em...)
let activer_carrousel_auto = true;

let slide_Index = 0;
let automatique = () => {
  for (let i = 0; i < btnClasse.length; i++) {
    btnClasse[i].style.visibility = "hidden";
  }
  //Tableaux
  let slides_classe = document.getElementsByClassName("my_photo");
  let dots_classe = document.getElementsByClassName("manuelDot_dot");

  console.log(slides_classe);

  for (let i = 0; i < slides_classe.length; i++) {
    slides_classe[i].style.display = "none";
  }

  slide_Index++;

  if (slide_Index > slides_classe.length) {
    slide_Index = 1;
  }

  for (let i = 0; i < dots_classe.length; i++) {
    dots_classe[i].className = dots_classe[i].className.replace(" active", "");
    if (dots_classe[i].className !== " active") {
      dots_classe[i].style.backgroundColor = "#bbb";
    }
  }

  slides_classe[slide_Index - 1].style.display = "block";
  dots_classe[slide_Index - 1].className += " active";
  dots_classe[slide_Index - 1].style.backgroundColor = getComputedStyle(
    slides_classe[slide_Index - 1],
    null
  ).backgroundColor;
  setTimeout(automatique, 2000); //2 secondes
};

let creerImage = () => {
  let courant = null;
  //Taille container d'image * nbr
  for (let i = 0; i < container.length; i++) {
    container[i].style.width = tailleWidth * totalImages + unite;
    courant = container[i];
  }
  //Creer les images
  for (let i = 1; i <= totalImages; i++) {
    let div = document.createElement("div");
    div.className = "my_photo";
    // div.style.backgroundColor = ".couleur"+i;
    div.style.backgroundImage =
      "url('build/images/carrouselManuel/im" + i + ".png')";
    //div.className += " couleur"+i;
    courant.appendChild(div);
  }
};
//ACTIVER LE CARROUSEL
if (activer_carrousel_auto) {
  creerImage();
  automatique();
}
