@component('mail::message')
# Verification !

Your verification code is : {{Session::get('verification_code')}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
