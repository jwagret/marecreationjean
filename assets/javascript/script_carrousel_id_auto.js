//Carrousel automatique
const container = document.getElementById("carrousel_container");
let btn = document.getElementsByClassName("bouton");
let nombre = 5; //5 images
let tailleWidth = 100; //100% = taille container
let unite = "%" //unite (px,%,em...)
let activerIdAuto = false;


let slideIndex = 0;

//ACTIVER LE CARROUSEL
if (activerIdAuto) {
    let automatique = () => {
        for (let i = 0; i < btn.length; i++) {
            btn[i].style.visibility = "hidden";
        }
        //Tableaux
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

        slides[slideIndex-1].style.display = 'inline-flex';
        dots[slideIndex-1].className += " active";
        dots[slideIndex-1].style.backgroundColor = getComputedStyle( slides[slideIndex-1],null).backgroundColor;
        setTimeout(automatique, 2000); //2 secondes
    }

    //Taille container d'image * nbr
    container.style.width = (tailleWidth*nombre)+unite;
    //Creer les images
    for (let i = 1; i <= nombre; i++) {
        let  lien = document.createElement("a");
        // let image = document.createElement("img");
        // image.src = "build/images/carrouselManuel/im"+i+".jpg";
        //image.alt = "image_im"+i;
        lien.href = "#";
        lien.className = "photo";
        lien.style.backgroundImage = "url('build/images/carrouselManuel/im"+i+".jpg')";
        lien.className += " couleur"+i;
        lien.appendChild(image);
        container.appendChild(lien);
    }
    automatique();
}
