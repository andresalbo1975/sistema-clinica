<template>
  <div>
    <Login v-if="!estaAutenticado" @loginExitoso="marcarComoAutenticado" />

    <div v-else>
      <nav class="bg-gray-800 p-4 text-white flex justify-between items-center shadow-md">
        <h1 class="text-xl font-bold">🏥 Clínica - Panel de Recepción</h1>
        <button @click="cerrarSesion" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm font-bold">
          Cerrar Sesión
        </button>
      </nav>

      <AgendarCita />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Login from './components/Login.vue';
import AgendarCita from './components/AgendarCita.vue';

// Variable reactiva que controla qué pantalla se ve
const estaAutenticado = ref(false);

// Al cargar la página, verificamos si ya existe el token en la memoria
onMounted(() => {
  const token = localStorage.getItem('token_clinica');
  if (token) {
    estaAutenticado.value = true;
  }
});

// Función que se dispara cuando el Login es exitoso
const marcarComoAutenticado = () => {
  estaAutenticado.value = true;
};

// Función para destruir el token y volver al Login
const cerrarSesion = () => {
  localStorage.removeItem('token_clinica');
  estaAutenticado.value = false;
};
</script>