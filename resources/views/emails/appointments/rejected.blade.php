<x-mail::message>
# Solicitud de Cita No Aprobada

Estimado/a **{{ $appointment->patient_name }}**,

Lamentamos informarte que tu solicitud de cita médica para el **{{ $appointment->start->format('d/m/Y') }}** a las **{{ $appointment->start->format('H:i') }}** con **{{ $appointment->doctor->name }}** no pudo ser aprobada.

Esto puede deberse a que el horario ya no está disponible o a otros factores de agenda.

Te invitamos a solicitar una nueva cita seleccionando otro horario disponible en nuestra plataforma.

<x-mail::button :url="config('app.url')">
Ver Horarios Disponibles
</x-mail::button>

Si tienes alguna pregunta, no dudes en contactarnos.

Saludos cordiales,<br>
{{ config('app.name') }}
</x-mail::message>
