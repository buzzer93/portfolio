import './styles.css';
import ScrollReveal from 'scrollreveal';

/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById('nav-menu');
const navToggle = document.getElementById('nav-toggle');
const navClose = document.getElementById('nav-close');

if (navToggle) {
    navToggle.addEventListener('click', () => navMenu.classList.add('show-menu'));
}
if (navClose) {
    navClose.addEventListener('click', () => navMenu.classList.remove('show-menu'));
}

/*=============== REMOVE MENU MOBILE ===============*/
document.querySelectorAll('.nav-link').forEach(n =>
    n.addEventListener('click', () => document.getElementById('nav-menu').classList.remove('show-menu'))
);

/*=============== BLUR HEADER ON SCROLL ===============*/
window.addEventListener('scroll', () => {
    const header = document.getElementById('header');
    header.classList.toggle('blur-header', window.scrollY >= 50);
});

/*=============== SHOW SCROLL UP ===============*/
window.addEventListener('scroll', () => {
    document.getElementById('scroll-up').classList.toggle('show-scroll', window.scrollY >= 350);
});

/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll('section[id]');
window.addEventListener('scroll', () => {
    const scrollDown = window.scrollY;
    sections.forEach(current => {
        const sectionTop = current.offsetTop - 58;
        const sectionId = current.getAttribute('id');
        const link = document.querySelector(`.nav-menu a[href*=${sectionId}]`);
        if (!link) return;
        link.classList.toggle('active-link', scrollDown > sectionTop && scrollDown <= sectionTop + current.offsetHeight);
    });
});

/*=============== SCROLL REVEAL ANIMATION ===============*/
const sr = ScrollReveal({ origin: 'top', distance: '60px', duration: 2000, reset: true });
sr.reveal('.home-data, .home-social, .contact-container, .footer-container');
sr.reveal('.home-image', { origin: 'bottom' });
sr.reveal('.about-data, .skills-data', { origin: 'left' });
sr.reveal('.about-image, .skills-content', { origin: 'right' });
sr.reveal('.projects-card', { interval: 150 });
