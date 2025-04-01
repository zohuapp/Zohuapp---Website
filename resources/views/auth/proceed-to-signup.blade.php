@include('auth.default')

<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Your email has been verified!') }}</div>

                <div class="card-body">
                    {{ __('Please be patient we are signing you into the App in a sec...') }}
                    {{-- {{ __('If you did not receive the email') }}, --}}
                    {{-- <form class="d-inline" method="POST" action="#">
                        @csrf
                        <button type="submit"
                            class="btn btn-info mt-2 align-baseline">{{ __('click here to request another') }}</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">

    // to sign the user in after they've verified their email
    $.ajax({
        url: "{{ route('proceed-to-verify-email') }}",
        method: 'POST',
        data: {
            uuid: "{{ $uuid }}",
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // handle the response if the login is successful
            // typically, you would redirect the user to the intended page
            console.log(response);
            window.location = "{{ route('home') }}";
        },
        error: function(xhr, status, error) {
            // handle the error if the login fails
            console.error(xhr.responseText);
        }
    });
</script>
