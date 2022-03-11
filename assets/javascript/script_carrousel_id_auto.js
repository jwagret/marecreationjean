//Carrousel automatique
const container = document.getElementById("carrousel_container");
let btn = document.getElementsByClassName("bouton");
let nombre = 5; //5 images
let tailleWidth = 20; //100% = taille container
let unite = "%" //unite (px,%,em...)
let activerIdAuto = true;

let slideIndex = 0;

//ACTIVER LE CARROUSEL
if (activerIdAuto) {
    let creerImage = () => {
        //Taille container d'image * nbr
        container.style.width = (tailleWidth*nombre)+unite;
        //Creer les images
        for (let i = 1; i <= nombre; i++) {
            let div = document.createElement("div");
            div.className = "photo";
            div.style.backgroundImage = "url('build/images/carrouselAutomatique/im_2"+i+".png')";
            //div.className += " couleur"+i;
            container.appendChild(div);
        }
    }

    let automatique = () => {
        for (let i = 0; i < btn.length; i++) {
            btn[i].style.visibility = "hidden";
        }
        //Tableaux
        let slides = document.getElementsByClassName("photo");
        let dots = document.getElementsByClassName("autoDot_dot");

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

        slides[slideIndex-1].style.display = 'inline-flex';
        dots[slideIndex-1].className += " active";
        dots[slideIndex-1].style.backgroundColor = getComputedStyle( slides[slideIndex-1],null).backgroundColor;
        setTimeout(automatique, 2000); //2 secondes

        console.log(slideIndex, slideIndex-1);
    }

    creerImage();
    automatique();
}
