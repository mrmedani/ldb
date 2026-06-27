import './bootstrap';
import { createIcons, icons } from 'lucide';

function initIcons() {
    createIcons({ icons });
}

window.initIcons = initIcons;

document.addEventListener('livewire:navigated', initIcons);

document.addEventListener('livewire:initialized', () => {
    let morphTimer;
    const deferredInit = () => { clearTimeout(morphTimer); morphTimer = setTimeout(initIcons, 0); };
    Livewire.hook('morph.added', deferredInit);
    Livewire.hook('morph.updated', deferredInit);
});

initIcons();
