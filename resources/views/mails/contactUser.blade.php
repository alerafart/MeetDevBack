@component('mail::message')
# Toc toc, on a du courrier pour toi !

Bonjour <b>{{ $receiverName }}</b>,

{{$senderName}} t'a envoyé un message !<br>

@component('mail::panel')
## {{$messageTitle}}
{{$messageContent}}
@endcomponent

Tu peux lui répondre à l'adresse suivante: {{$senderMail}} .<br>

En te souhaitant une bonne journée, <br>
L'équipe meetdev
@endcomponent
