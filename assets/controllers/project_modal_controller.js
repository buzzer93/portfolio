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
        this.descriptionTarget.innerHTML = this.resolveDescriptionHtml(data);
        const githubUrl = typeof data.githubUrl === 'string' ? data.githubUrl.trim() : '';
        if (githubUrl.length > 0) {
            this.githubLinkTarget.href = githubUrl;
            this.githubLinkTarget.hidden = false;
        } else {
            this.githubLinkTarget.hidden = true;
            this.githubLinkTarget.removeAttribute('href');
        }
        this.techTarget.innerHTML = this.renderTechGroups(data.tech);

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

    resolveDescriptionHtml(data) {
        const markdownHtml = typeof data.descriptionHtml === 'string' ? data.descriptionHtml.trim() : '';
        if (markdownHtml.length > 0) {
            return markdownHtml;
        }

        const plainDescription = typeof data.description === 'string' ? data.description.trim() : '';
        if (plainDescription.length > 0) {
            return this.escape(plainDescription).replace(/\r?\n/g, '<br>');
        }

        return '<p>Description indisponible.</p>';
    }

    renderTechGroups(tech) {
        const groups = this.normalizeTechGroups(tech);
        const labels = {
            frontend: 'Front-end',
            backend: 'Back-end',
            tools: 'Outils',
        };

        return Object.entries(groups)
            .filter(([, values]) => values.length > 0)
            .map(([category, values]) => {
                const tags = values
                    .map((value) => `<span class="modal-tech-tag">${this.escape(value)}</span>`)
                    .join('');

                return `
                    <div class="project-modal-tech-group">
                        <span class="project-modal-tech-title">${labels[category]}</span>
                        <div class="project-modal-tech-list">${tags}</div>
                    </div>
                `;
            })
            .join('');
    }

    normalizeTechGroups(tech) {
        const empty = { frontend: [], backend: [], tools: [] };

        if (Array.isArray(tech)) {
            return {
                frontend: [],
                backend: [],
                tools: tech.map((value) => String(value).trim()).filter((value) => value !== ''),
            };
        }

        if (!tech || typeof tech !== 'object') {
            return empty;
        }

        const sanitize = (values) => Array.isArray(values)
            ? values.map((value) => String(value).trim()).filter((value) => value !== '')
            : [];

        return {
            frontend: sanitize(tech.frontend),
            backend: sanitize(tech.backend),
            tools: sanitize(tech.tools),
        };
    }
}
