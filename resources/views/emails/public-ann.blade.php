@component('mail::message')
    Hi {{ $name }}

    {!! $body !!}

    @component('mail::button', ['url' => 'https://lms.com'])
        lms
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
