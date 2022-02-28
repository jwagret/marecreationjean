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
function toggleMenu() {
    const navUl = document.querySelector('.linkNav');
    const sectUl = document.querySelector('.linkSection');
    const burger = document.querySelector('.burger');
    const btn = document.querySelector('.burger')
    burger.addEventListener('click', () => {
        navUl.classList.toggle('open-nav');
        sectUl.classList.toggle('open-nav');
        btn.classList.toggle('open');
    })
}

toggleMenu();
