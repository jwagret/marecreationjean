import 'bootstrap/dist/js/bootstrap.min.js';

//burger menu
const burger = document.querySelector('.burger');
const navbar = document.querySelector('.navbar');

    let toggleMenu = () => {
        navbar.classList.toggle('open-nav');
        burger.classList.toggle('menu');
    }

burger.addEventListener('click', toggleMenu);

//carrousel
//Initialisation
const container = document.getElementById("carrousel_container");
const boutonGauche = document.getElementById("btn_gauche");
const boutonDroite = document.getElementById("btn_droite");
let nbr = 5; //5 images
let position = 0; //position

    //Taille container d'image * nbr
    container.style.width = (800*nbr)+"px";
    //Creer les images
    for (let i = 1; i <= nbr; i++) {
       let  div = document.createElement("div");
       div.className = "photo";
       div.style.backgroundImage = "url('build/images/im"+i+".png')";
       div.className += " couleur"+i;
       container.appendChild(div);
    }

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

    let reculer = () => {
        if (position > (-nbr + 1)) {
            position--;
        }
        container.style.transform = "translate("+position*800+"px)";
        //transition
        container.style.transition = "all 0.5s ease";
        afficherMasquer();
    }

    let avancer = () => {
        if (position < 0) {
            position++;
        }
        container.style.transform = "translate("+position*800+"px)";
        //transition
        container.style.transition = "all 0.5s ease";
        afficherMasquer();
    }

    let slideIndex = 0;
    let automatique = () => {
        let slides = document.getElementsByClassName("photo");
        let dots = document.getElementsByClassName("dot");

        for (let i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slideIndex++;

        if (slideIndex > slides.length) {
            slideIndex = 1;
        }

        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
            if (dots[i].className !== " active") {
                dots[i].style.backgroundColor = "#bbb";
            }
        }

        slides[slideIndex-1].style.display = 'block';
        dots[slideIndex-1].className += " active";
        dots[slideIndex-1].style.backgroundColor = getComputedStyle( slides[slideIndex-1],null).backgroundColor;
        setTimeout(automatique, 2000); //2 secondes
    }
automatique();
// afficherMasquer();
// boutonGauche.addEventListener('click', reculer);
// boutonDroite.addEventListener('click', avancer);