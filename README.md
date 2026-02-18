# 🏥 Sistema de Gestión de Clínica

Este es un sistema web moderno para la gestión y agendamiento de citas médicas, construido con una arquitectura sólida y reactiva.

## 🛠️ Tecnologías Utilizadas
* **Backend:** Laravel (PHP)
* **Frontend:** Vue.js 3 + Vite
* **Diseño:** Tailwind CSS v4
* **Base de Datos:** PostgreSQL

## 🔄 Flujo de Trabajo (Arquitectura del Sistema)
El siguiente diagrama muestra cómo interactúan las diferentes capas de la aplicación al momento de agendar una cita:

```mermaid
sequenceDiagram
    actor Usuario
    participant Vue as Frontend (Vue.js)
    participant Laravel as Backend (API)
    participant DB as PostgreSQL

    Usuario->>Vue: Entra al sistema
    Vue->>Laravel: Pide Pacientes, Médicos y Citas
    Laravel->>DB: Consulta (SELECT)
    DB-->>Laravel: Datos
    Laravel-->>Vue: Envía JSON
    Vue-->>Usuario: Muestra Formulario y Tabla

    Usuario->>Vue: Llena formulario y da clic
    Vue->>Laravel: POST /api/citas/agendar

    alt Falla Validación de Fecha/Datos
        Laravel-->>Vue: Error 422
        Vue-->>Usuario: Muestra "Datos inválidos"
    else Pasa Validación
        Laravel->>DB: Verifica disponibilidad (SELECT)
        alt Médico Ocupado
            DB-->>Laravel: Cita encontrada
            Laravel-->>Vue: Error 409
            Vue-->>Usuario: Muestra "Horario Ocupado"
        else Médico Disponible
            Laravel->>DB: Guarda (INSERT)
            DB-->>Laravel: Confirmación
            Laravel-->>Vue: Éxito 201
            Vue->>Laravel: GET /api/citas (Pide tabla nueva)
            Laravel-->>Vue: JSON actualizado
            Vue-->>Usuario: Alerta "¡Cita agendada!" y actualiza tabla
        end
    end