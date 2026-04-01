import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['menu', 'overlay'];

    open() {
        this.menuTarget.classList.remove('-translate-x-full');
        this.overlayTarget.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    close() {
        this.menuTarget.classList.add('-translate-x-full');
        this.overlayTarget.classList.add('hidden');
        document.body.style.overflow = '';
    }
}
