@component('mail::message')
Click the following link to verify your email:
[Verify Email]({{ route('verification.verify', $token) }})
@endcomponent
