const container = document.getElementsByClassName("carrousel_container_client");
const bouton = document.getElementsByClassName("bouton_client");
let nombre_images = 5; //5 images
let position = 0; //position
let tailleWidth = 100; //100% = taille container
let unite = "%" //unite (px,%,em...)
let deplacerImage = tailleWidth/nombre_images;
let activer_carrousel = true;

//Afficher masquer les fleches
let controlerBoutons = () => {
    if (position === (-nombre_images+1)) {
        bouton[0].style.visibility = "hidden";
    } else {
        bouton[0].style.visibility = "visible";
    }
    if (position === 0 ) {
        bouton[1].style.visibility = "hidden";
    } else {
        bouton[1].style.visibility = "visible";
    }
}

let reculer = () => {
    if (position > (-nombre_images + 1)) {
        position--;
    }
    for (let i = 0; i < container.length; i++) {
        container[i].style.transform = "translate("+position*deplacerImage+unite+")";
        //transition
        container[i].style.transition = "all 0.5s ease";
    }
    controlerBoutons();
}

let avancer = () => {
    if (position < 0) {
        position++;
    }
    for (let i = 0; i < container.length; i++) {
        container[i].style.transform = "translate("+position*deplacerImage+unite+")";
        //transition
        container[i].style.transition = "all 0.5s ease";
    }
    controlerBoutons();
}


if (activer_carrousel) {
    const dots = document.getElementsByClassName("clientDot_dot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].style.visibility = 'hidden';
    }

    let courant = null;
    //Taille container d'image * nbr
    for (let i = 0; i < container.length; i++) {
        container[i].style.width = (tailleWidth*nombre_images)+unite;
        courant = container[i];
    }

    //Creer les images
    for (let i = 1; i <= nombre_images; i++) {
        let div = document.createElement("div");
        div.className = "photo_client";
        //div.style.backgroundColor = ".couleur"+i;
        div.style.backgroundImage = "url('build/images/carrouselAutomatique/im_2"+i+".png')";
        //div.className += " couleur"+i;
        courant.appendChild(div);
    }

    controlerBoutons();
    bouton[0].addEventListener('click', reculer);
    bouton[1].addEventListener('click', avancer);
} else {
    bouton[0].style.visibility = "hidden";
    bouton[1].style.visibility = "hidden";
}




