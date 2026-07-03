import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['menu'];

    toggle() {
        this.menuTarget.classList.toggle('show-menu');
    }

    close() {
        this.menuTarget.classList.remove('show-menu');
    }
}
