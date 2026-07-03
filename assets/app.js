import './styles.css';
import { startStimulusApp } from '@symfony/stimulus-bundle';
import ScrollReveal from 'scrollreveal';

startStimulusApp();

/*=============== LIGHT / DARK THEME ===============*/
const themeButton = document.getElementById('nav-theme');
const themeIcon = document.getElementById('theme-icon');
const storedTheme = localStorage.getItem('portfolio-theme');

const applyTheme = (theme) => {
    const isLight = theme === 'light';
    document.body.classList.toggle('light-theme', isLight);

    if (themeIcon) {
        themeIcon.classList.toggle('ri-sun-line', isLight);
        themeIcon.classList.toggle('ri-moon-line', !isLight);
    }

    if (themeButton) {
        themeButton.setAttribute('aria-label', isLight ? 'Activer le mode sombre' : 'Activer le mode clair');
    }
};

applyTheme(storedTheme === 'light' ? 'light' : 'dark');

/*=============== THEME TOGGLE ===============*/
if (themeButton) {
    themeButton.addEventListener('click', () => {
        const nextTheme = document.body.classList.contains('light-theme') ? 'dark' : 'light';
        applyTheme(nextTheme);
        localStorage.setItem('portfolio-theme', nextTheme);
    });
}

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

/*=============== INSTANT CONTACT HASH JUMP ===============*/
const jumpToContactInstantly = () => {
    if (window.location.hash !== '#contact') {
        return;
    }

    const contactSection = document.getElementById('contact');
    if (!contactSection) {
        return;
    }

    const root = document.documentElement;
    const previousBehavior = root.style.scrollBehavior;

    root.style.scrollBehavior = 'auto';
    contactSection.scrollIntoView({ behavior: 'auto', block: 'start' });

    requestAnimationFrame(() => {
        root.style.scrollBehavior = previousBehavior;
    });
};

window.addEventListener('load', jumpToContactInstantly);
window.addEventListener('hashchange', jumpToContactInstantly);

/*=============== SCROLL REVEAL ANIMATION ===============*/
const sr = ScrollReveal({ origin: 'top', distance: '60px', duration: 2000, reset: true });
sr.reveal('.home-data, .home-social, .contact-container, .footer-container');
sr.reveal('.home-image', { origin: 'bottom' });
sr.reveal('.about-data, .skills .section-title', { origin: 'left' });
sr.reveal('.about-image, .skills-groups', { origin: 'right' });
sr.reveal('.skills-cta', { origin: 'bottom' });
sr.reveal('.projects-card', { interval: 150 });
