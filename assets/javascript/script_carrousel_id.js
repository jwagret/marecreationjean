const container = document.getElementById("carrousel_container");
const boutonGauche = document.getElementById("btn_gauche");
const boutonDroite = document.getElementById("btn_droite");
let nbr = 5; //5 images
let position = 0; //position
let tailleWidth = 100; //100% = taille container
let unite = "%" //unite (px,%,em...)
let deplacerImage = tailleWidth/nbr;
let activer = false;

//Afficher masquer les fleches
let afficherMasquer = () => {
    if (position === (-nbr+1)) {
        boutonGauche.style.visibility = "hidden";
    } else {
        boutonGauche.style.visibility = "visible";
    }
    if (position === 0 ) {
        boutonDroite.style.visibility = "hidden";
    } else {
        boutonDroite.style.visibility = "visible";
    }
}

//ACTIVER LE CARROUSEL
if (activer) {
    const dots = document.getElementsByClassName("manuelDot");
    for (let i = 0; i < dots.length; i++) {
        dots[i].style.visibility = 'hidden';
    }

    let reculer = () => {
        console.log("coucou");
        if (position > (-nbr + 1)) {
            position--;
        }
        container.style.transform = "translate("+position*deplacerImage+unite+")";
        //transition
        container.style.transition = "all 0.5s ease";
        afficherMasquer();
    }

    let avancer = () => {
        if (position < 0) {
            position++;
        }
        container.style.transform = "translate("+position*deplacerImage+unite+")";
        //transition
        container.style.transition = "all 0.5s ease";
        afficherMasquer();
    }

    //Taille container d'image * nbr
    container.style.width = (tailleWidth*nbr)+unite;
    //Creer les images
    for (let i = 1; i <= nbr; i++) {
        let _div = document.createElement("div");
        let image = document.createElement("img");
        _div.className = "photo";
        _div.style.backgroundImage = "url('build/images/carrouselAutomatique/im_2"+i+".png')";
        _div.style.backgroundColor = " couleur"+i;
        //div.className += " couleur"+i;
        container.appendChild(_div);
    }

   afficherMasquer();
    boutonGauche.addEventListener('click', reculer);
    boutonDroite.addEventListener('click', avancer);
} else {
    boutonGauche.style.visibility = "hidden";
    boutonDroite.style.visibility = "hidden";
}

