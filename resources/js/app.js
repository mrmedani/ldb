import './bootstrap';
import { createIcons, icons } from 'lucide';

function initIcons() {
    createIcons({ icons });
}

document.addEventListener('livewire:navigated', initIcons);
window.addEventListener('livewire:updated', initIcons);

initIcons();
