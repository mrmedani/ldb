import './bootstrap';
import { createIcons, icons } from 'lucide';

function initIcons() {
    createIcons({ icons });
}

document.addEventListener('livewire:navigated', initIcons);

const iconObserver = new MutationObserver(() => {
    if (document.querySelector('[data-lucide]:not(.lucide)')) {
        initIcons();
    }
});
iconObserver.observe(document.body, { childList: true, subtree: true });

initIcons();
