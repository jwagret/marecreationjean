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

    let reculer = () => {
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
        let lien = document.createElement("a");
        let image = document.createElement("img");
        image.src = "build/images/carrouselManuel/im"+i+".jpg";
        image.alt = "image_im"+i;
       // image.className = "imgHeader";
        image.className += " imgCarrousel";
        lien.href = "#";
        lien.className = "photo";
        // lien.style.backgroundImage = "url('build/images/carrouselManuel/im"+i+".jpg')";
        //lien.className += " couleur"+i;
        lien.appendChild(image);
        container.appendChild(lien);
    }
   // afficherMasquer();
   //  boutonGauche.addEventListener('click', reculer);
   //  boutonDroite.addEventListener('click', avancer);
}

