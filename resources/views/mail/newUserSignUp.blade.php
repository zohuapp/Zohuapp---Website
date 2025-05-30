
<x-mail::message>
# Welcome to {{ config('app.name') }}!

Dear {{ $username }},

Thank you for registering with {{ config('app.name') }}.<br> To complete your registration and access all features, please confirm
your email address by clicking the button below

<x-mail::button :url="$route">
    Proceed to Sign Up
</x-mail::button>

The {{ config('app.name') }} Team,
</x-mail::message>
