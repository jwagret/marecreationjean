//burger menu
const burger = document.querySelector('.burger');
const navbar = document.querySelector('.navbar');

let toggleMenu = () => {
    navbar.classList.toggle('open-nav');
    burger.classList.toggle('menu');
}

burger.addEventListener('click', toggleMenu);