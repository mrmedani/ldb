import './bootstrap';
import { createIcons, icons } from 'lucide';

function initIcons() {
    createIcons({ icons });
}

document.addEventListener('livewire:navigated', initIcons);
document.addEventListener('livewire:updated', initIcons);

initIcons();
