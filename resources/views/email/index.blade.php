@component('mail::message')
    Добрый день, {{$user->name}}!
    Код для смены пароля - {{$code}}
@endcomponent
