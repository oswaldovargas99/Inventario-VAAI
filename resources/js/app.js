import './bootstrap';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

// Registrar plugin persist
Alpine.plugin(persist);

// Iniciar Alpine
window.Alpine = Alpine;
Alpine.start();

