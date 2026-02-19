<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
      <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-gray-800">Sistema Clínica</h2>
        <p class="text-gray-500 mt-2">Acceso exclusivo para Recepción</p>
      </div>

      <form @submit.prevent="iniciarSesion" class="space-y-5">
        <div>
          <label class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
          <input 
            v-model="formulario.email" 
            type="email" 
            required 
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" 
            placeholder="recepcion@clinica.com"
          />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Contraseña</label>
          <input 
            v-model="formulario.password" 
            type="password" 
            required 
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border focus:ring-blue-500 focus:border-blue-500" 
            placeholder="••••••••"
          />
        </div>

        <div v-if="mensajeError" class="p-3 bg-red-100 text-red-700 rounded-md text-sm text-center">
          {{ mensajeError }}
        </div>

        <button 
          type="submit" 
          :disabled="cargando" 
          class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 disabled:opacity-50"
        >
          {{ cargando ? 'Verificando...' : 'Iniciar Sesión' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Esto nos permite enviarle un aviso al componente principal cuando el login sea exitoso
const emit = defineEmits(['loginExitoso']); 

const formulario = ref({ email: '', password: '' });
const mensajeError = ref('');
const cargando = ref(false);

const iniciarSesion = async () => {
  cargando.value = true;
  mensajeError.value = ''; // Limpiamos errores previos

  try {
    const respuesta = await fetch('/api/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formulario.value)
    });

    const data = await respuesta.json();

    if (respuesta.ok) {
      // ¡Éxito! Guardamos la "pulsera VIP" en la memoria del navegador
      localStorage.setItem('token_clinica', data.token);
      
      // Le avisamos a la aplicación que ya puede mostrar el sistema
      emit('loginExitoso'); 
    } else {
      // Si Laravel nos dice que la contraseña está mal (Error 401)
      mensajeError.value = data.error || 'Credenciales incorrectas.';
    }
  } catch (error) {
    mensajeError.value = 'Error al conectar con el servidor.';
  } finally {
    cargando.value = false;
  }
};
</script>