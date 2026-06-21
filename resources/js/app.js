import './bootstrap';
import { createIcons, icons } from 'lucide';

document.addEventListener('livewire:navigated', () => {
    createIcons({ icons });
});

createIcons({ icons });
