import './bootstrap';
import { createApp } from 'vue';
import AgendarCita from './components/AgendarCita.vue';

// 1. Creamos la aplicación de Vue usando nuestro formulario
const app = createApp(AgendarCita);

// 2. Le decimos que dibuje el formulario dentro del <div id="app">
app.mount('#app');