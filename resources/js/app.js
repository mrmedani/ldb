import './bootstrap';
import { createIcons, icons } from 'lucide';

function initIcons() {
    createIcons({ icons });
}

window.initIcons = initIcons;

document.addEventListener('livewire:navigated', initIcons);

document.addEventListener('livewire:initialized', () => {
    Livewire.hook('morph.added', initIcons);
    Livewire.hook('morph.updated', initIcons);
});

initIcons();
