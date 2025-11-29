<x-mail::message>
# ✓ Tu Cita ha sido Confirmada

Estimado/a **{{ $appointment->patient_name }}**,

¡Excelentes noticias! Tu cita médica ha sido **confirmada** con los siguientes detalles:

**Médico:** {{ $appointment->doctor->name }}  
**Especialidad:** {{ $appointment->doctor->specialty }}  
**Fecha:** {{ $appointment->start->format('d/m/Y') }}  
**Hora:** {{ $appointment->start->format('H:i') }}  
**Duración:** {{ $appointment->end->diffInMinutes($appointment->start) }} minutos

Por favor, llega 10 minutos antes de tu cita. Si necesitas cancelar o reprogramar, contáctanos con al menos 24 horas de anticipación.

Esperamos verte pronto.

Saludos cordiales,<br>
{{ config('app.name') }}
</x-mail::message>
