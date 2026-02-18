<template>
  <div class="max-w-5xl mx-auto mt-10 p-6">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6 mb-10">
      <h2 class="text-2xl font-bold mb-4 text-gray-800 text-center">Agendar Nueva Cita</h2>
      <form @submit.prevent="enviarCita" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Paciente</label>
          <select v-model="formulario.paciente_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-white p-2 border">
            <option value="" disabled>Seleccione un paciente...</option>
            <option v-for="p in pacientes" :key="p.id" :value="p.id">{{ p.nombre }}</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Médico</label>
          <select v-model="formulario.medico_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-white p-2 border">
            <option value="" disabled>Seleccione un médico...</option>
            <option v-for="m in medicos" :key="m.id" :value="m.id">{{ m.nombre }} - {{ m.especialidad }}</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Fecha y Hora</label>
          <input v-model="formulario.fecha_hora" type="datetime-local" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm p-2 border" />
        </div>

        <button type="submit" :disabled="enviando" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 disabled:opacity-50">
          {{ enviando ? 'Procesando...' : 'Confirmar Cita' }}
        </button>
      </form>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div class="bg-gray-50 px-6 py-4 border-b">
        <h3 class="text-lg font-bold text-gray-800">Citas Agendadas Recientemente</h3>
      </div>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Paciente</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Médico</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha y Hora</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="cita in citas" :key="cita.id" class="hover:bg-gray-50">
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ cita.paciente?.nombre }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              {{ cita.medico?.nombre }} <br>
              <span class="text-xs text-blue-500">{{ cita.medico?.especialidad }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatearFecha(cita.fecha_hora) }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">{{ cita.estado }}</span>
            </td>
          </tr>
          <tr v-if="citas.length === 0">
            <td colspan="4" class="px-6 py-10 text-center text-gray-400">No hay citas registradas aún.</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const pacientes = ref([]);
const medicos = ref([]);
const citas = ref([]);
const enviando = ref(false);

const formulario = ref({ paciente_id: '', medico_id: '', fecha_hora: '' });

// Cargar todos los datos al iniciar
const cargarDatosIniciales = async () => {
  const [resP, resM, resC] = await Promise.all([
    fetch('/api/pacientes'),
    fetch('/api/medicos'),
    fetch('/api/citas')
  ]);
  pacientes.value = await resP.json();
  medicos.value = await resM.json();
  citas.value = await resC.json();
};

onMounted(cargarDatosIniciales);

// Función para agendar
const enviarCita = async () => {
  enviando.value = true;
  try {
    const respuesta = await fetch('/api/citas/agendar', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(formulario.value)
    });

    if (respuesta.ok) {
      alert("¡Cita agendada!");
      formulario.value = { paciente_id: '', medico_id: '', fecha_hora: '' };
      // RECARGA LA TABLA SIN REFRESCAR LA PÁGINA
      const resC = await fetch('/api/citas');
      citas.value = await resC.json();
    }
  } catch (error) {
    console.error("Error:", error);
  } finally {
    enviando.value = false;
  }
};

// Formatear fecha para que se vea bonita
const formatearFecha = (string) => {
  const opciones = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
  return new Date(string).toLocaleDateString('es-ES', opciones);
};
</script>