<x-mail::message>
# Solicitud de Cita Recibida

Estimado/a **{{ $appointment->patient_name }}**,

Hemos recibido tu solicitud de cita médica con los siguientes detalles:

**Médico:** {{ $appointment->doctor->name }}  
**Fecha:** {{ $appointment->start->format('d/m/Y') }}  
**Hora:** {{ $appointment->start->format('H:i') }}  
**Duración:** {{ $appointment->end->diffInMinutes($appointment->start) }} minutos

Tu solicitud está siendo revisada y recibirás una notificación una vez que sea confirmada o rechazada.

Gracias por confiar en nuestros servicios.

Saludos cordiales,<br>
{{ config('app.name') }}
</x-mail::message>
