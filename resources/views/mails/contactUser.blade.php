@component('mail::message')
# Introduction

Hello <b>{{ $email }}</b>,

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
meetDev
@endcomponent

