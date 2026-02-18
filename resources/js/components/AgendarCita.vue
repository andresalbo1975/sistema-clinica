<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Agendar Nueva Cita</h2>

    <form @submit.prevent="enviarCita" class="space-y-4">
      
      <div>
        <label class="block text-sm font-medium text-gray-700">Paciente</label>
        <select v-model="formulario.paciente_id" required 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-white p-2 border">
          <option value="" disabled>Seleccione un paciente...</option>
          <option v-for="paciente in pacientes" :key="paciente.id" :value="paciente.id">
            {{ paciente.nombre }} (RUT/DNI: {{ paciente.rut_dni }})
          </option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Médico Especialista</label>
        <select v-model="formulario.medico_id" required 
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-white p-2 border">
          <option value="" disabled>Seleccione un médico...</option>
          <option v-for="medico in medicos" :key="medico.id" :value="medico.id">
            {{ medico.nombre }} - {{ medico.especialidad }}
          </option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Fecha y Hora</label>
        <input v-model="formulario.fecha_hora" type="datetime-local" required 
               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" />
      </div>

      <button type="submit" :disabled="cargando"
              class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 disabled:opacity-50 mt-4">
        {{ cargando ? 'Agendando...' : 'Confirmar Cita' }}
      </button>

      <p v-if="mensajeExito" class="text-green-600 mt-2 font-semibold">{{ mensajeExito }}</p>
      <p v-if="mensajeError" class="text-red-600 mt-2 font-semibold">{{ mensajeError }}</p>

    </form>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const pacientes = ref([]);
const medicos = ref([]);

const formulario = ref({
  paciente_id: '',
  medico_id: '',
  fecha_hora: ''
});

const cargando = ref(false);
const mensajeExito = ref('');
const mensajeError = ref('');

const cargarDatos = async () => {
  try {
    const resPacientes = await fetch('http://localhost:8000/api/pacientes');
    pacientes.value = await resPacientes.json();

    const resMedicos = await fetch('http://localhost:8000/api/medicos');
    medicos.value = await resMedicos.json();
  } catch (error) {
    console.error("Error al cargar los datos de la API", error);
  }
};

onMounted(() => {
  cargarDatos();
});

const enviarCita = async () => {
  cargando.value = true;
  mensajeExito.value = '';
  mensajeError.value = '';

  try {
    const respuesta = await fetch('http://localhost:8000/api/citas/agendar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(formulario.value)
    });

    const datos = await respuesta.json();

    if (respuesta.ok) {
      mensajeExito.value = datos.mensaje || 'Cita agendada exitosamente.';
      formulario.value = { paciente_id: '', medico_id: '', fecha_hora: '' };
    } else {
      mensajeError.value = datos.error || 'Ocurrió un error al agendar.';
    }

  } catch (error) {
    mensajeError.value = 'Error de conexión con el servidor.';
  } finally {
    cargando.value = false;
  }
};
</script>