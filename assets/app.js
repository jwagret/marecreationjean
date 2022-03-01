/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';


//burger menu
const burger = document.querySelector('.burger');
const navbar = document.querySelector('.navbar');

function toggleMenu() {
     navbar.classList.toggle('open-nav');
     burger.classList.toggle('menu');
}

burger.addEventListener('click', toggleMenu);



