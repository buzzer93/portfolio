import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['overlay', 'title', 'description', 'tech', 'githubLink', 'slides', 'dots', 'prevBtn', 'nextBtn'];

    connect() {
        this.images = [];
        this.currentIndex = 0;
        this.boundKeydown = (e) => this.onKeydown(e);
        document.addEventListener('keydown', this.boundKeydown);
    }

    disconnect() {
        document.removeEventListener('keydown', this.boundKeydown);
    }

    open(event) {
        const data = JSON.parse(event.currentTarget.dataset.projectInfo);
        this.images = data.images ?? [];
        this.currentIndex = 0;

        this.titleTarget.textContent = data.title;
        this.descriptionTarget.textContent = data.description;
        const githubUrl = typeof data.githubUrl === 'string' ? data.githubUrl.trim() : '';
        if (githubUrl.length > 0) {
            this.githubLinkTarget.href = githubUrl;
            this.githubLinkTarget.hidden = false;
        } else {
            this.githubLinkTarget.hidden = true;
            this.githubLinkTarget.removeAttribute('href');
        }
        this.techTarget.innerHTML = data.tech
            .map(t => `<span class="modal-tech-tag">${this.escape(t)}</span>`)
            .join('');

        this.slidesTarget.innerHTML = this.images
            .map(img => `<div class="modal-slide"><img src="/images/${this.escape(img)}" alt="${this.escape(data.title)}"></div>`)
            .join('');

        this.dotsTarget.innerHTML = this.images
            .map((_, i) => `<button class="modal-dot" data-index="${i}" data-action="click->project-modal#goTo"></button>`)
            .join('');

        this.updateCarousel();
        this.overlayTarget.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }

    close() {
        this.overlayTarget.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    next() {
        if (this.images.length <= 1) return;
        this.currentIndex = (this.currentIndex + 1) % this.images.length;
        this.updateCarousel();
    }

    prev() {
        if (this.images.length <= 1) return;
        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
        this.updateCarousel();
    }

    goTo(event) {
        this.currentIndex = parseInt(event.currentTarget.dataset.index, 10);
        this.updateCarousel();
    }

    closeOnOverlay(event) {
        if (event.target === this.overlayTarget) {
            this.close();
        }
    }

    updateCarousel() {
        this.slidesTarget.style.transform = `translateX(-${this.currentIndex * 100}%)`;
        this.dotsTarget.querySelectorAll('.modal-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === this.currentIndex);
        });
        const hasMultiple = this.images.length > 1;
        this.prevBtnTarget.hidden = !hasMultiple;
        this.nextBtnTarget.hidden = !hasMultiple;
        this.dotsTarget.hidden = !hasMultiple;
    }

    onKeydown(event) {
        if (!this.overlayTarget.classList.contains('is-open')) return;
        if (event.key === 'Escape') this.close();
        if (event.key === 'ArrowRight') this.next();
        if (event.key === 'ArrowLeft') this.prev();
    }

    escape(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
}
