@include('auth.default')
<style>
    #phone {
        padding-left: 40% !important;
    }

    #select2-country_selector-container {
        max-width: fit-content;
    }

    .select2-container--open .select2-dropdown {
        min-width: 227px;
    }
</style>

<div class="login-page vh-100">
    <div class="d-flex align-items-center justify-content-center vh-100">
        <div class="col-md-6">
            <div class="col-10 mx-auto card p-3">
                <h3 class="text-dark text-center my-0 mb-3">{{ trans('lang.login') }}</h3>
                {{-- <div class="error" id="error"></div> --}}

                {{-- display errors --}}
                <div id="errors">

                </div>

                <form class="form-horizontal form-material pt-4">
                    <div class="form-group " id="phone-box">
                        {{-- email input --}}
                        <label for="userEmail" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control"
                            placeholder="{{ trans('lang.user_email_help') }}" id="userEmail" required
                            aria-describedby="emailHelp">
                        <span id="emailHelp" class="form-text">We'll never share your email with anyone else.</span>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- password input --}}
                    <div class="form-group">
                        <label for="userPassword" class="form-label">Password</label>
                        <input type="password" name="password" placeholder="{{ trans('lang.user_password_help') }}"
                            class="form-control" required id="userPassword">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="error font-weight-bold text-center" id="password_required_new"></div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button type="button" onclick="signInUser()" id=""
                                class="btn btn-dark btn-lg btn-block text-uppercase waves-effect waves-light btn btn-primary remove_hover">
                                {{ trans('lang.sign_in') }}
                            </button>
                            {{--  --}}
                            <div class="or-line mb-3 mt-3">
                                <span>OR</span>
                            </div>
                            {{--  --}}
                            <a href="{{ route('register') }}"
                                class="btn btn-primary btn-lg btn-block remove_hover">{{ trans('lang.sign_up') }}
                            </a>
                            {{--  --}}
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>

<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-firestore.js"></script>

<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-storage.js"></script>

<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>

<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-database.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

<script src="{{ asset('js/crypto-js.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
<script src="{{ asset('js/jquery.validate.js') }}"></script>

<script type="text/javascript">
    var database = firebase.firestore();

    // function loginWithPhoneClick() {
    //     jQuery("#login-box").hide();
    //     jQuery("#login-with-phone-box").show();
    //     jQuery("#phone-box").show();
    //     jQuery("#recaptcha-container").show();
    //     jQuery("#sendotp_btn").show();
    // }

    // window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
    //     'size': 'invisible',
    //     'callback': (response) => {}
    // });

    // const appVerifier = window.recaptchaVerifier;

    // associative array that contains error messages
    const errorMessages = {
        'password': "An account already exists with the provided email. Please sign in.",
        'inactive': "Your account is not active. Please contact support.",
        'unexpected': "An error occurred during sign in. Please try again.",
        'invalid': "Your credentials does not match our records.",
        'emptyFields': "One or more fields are empty",
        'invalidEmail': "Email address is invalid",
    };

    async function signInUser() {

        // const form = event.target; // Get the form element from the event object
        // const formData = new FormData(form);

        const email = $("#userEmail").val();
        const password = $("#userPassword").val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        console.log("email (direct access):", email);
        console.log("Password (direct access):", password);

        if (email == '' || password == '') {
            $("#errors").html(
                `<p class="error" id="field_error" style="background-color: rgba(179, 24, 24, 0.625);color:white;">${errorMessages.emptyFields}</p>`
            );
            $("#field_error").addClass('p-2');
            return;
        } else if (!emailRegex.test(email)) {
            $("#errors").html(
                `<p class="error" id="email_error" style="background-color: rgba(179, 24, 24, 0.625);color:white;">${errorMessages.invalidEmail}</p>`
            );
            $("#email_error").addClass('p-2');
            return;
        }

        try {
            const checkUser = await firebase.firestore().collection('users')
                .where("email", "==", email)
                .where("role", "==", "customer")
                .get();

            if (checkUser.docs.length > 0) {
                const userData = checkUser.docs[0].data();

                if (userData.active === true) {
                    try {
                        const signIn = await firebase.auth().signInWithEmailAndPassword(email, password);
                        console.log("User signed in:", signIn.user);
                        // alert("User signed in");

                        const uid = signIn.user.uid;
                        const url = "{{ route('setToken') }}";

                        $.ajax({
                            type: 'POST',
                            url: url,
                            data: {
                                id: uid,
                                userId: uid,
                                email: userData.email,
                                password: password,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                                if (data.access) {
                                    window.location = "{{ route('home') }}";
                                }
                            }
                        });
                        // return; // Stop further execution
                    } catch (signInError) {
                        console.error("Sign-in error:", signInError);
                        // Handle sign-in errors (e.g., wrong password):
                        if (signInError.code === 'auth/wrong-password') {
                            $("#errors").html(
                                `<p class="error" id="field_error" style="background-color: rgba(179, 24, 24, 0.625);color:white;">${signInError.message}</p>`
                            );
                            $("#field_error").addClass('p-2');
                        } else if (signInError.code === 'auth/internal-error') {
                            $("#errors").html(
                                `<p class="error" id="field_error" style="background-color: rgba(179, 24, 24, 0.625);color:white;">${errorMessages.invalid}</p>`
                            );
                            $("#field_error").addClass('p-2');
                        } else {
                            $("#errors").html(
                                `<p class="error" id="field_error" style="background-color: rgba(179, 24, 24, 0.625);color:white;">${errorMessages.unexpected}</p>`
                            );
                            $("#field_error").addClass('p-2');
                        }
                        return; // Stop further execution
                    }
                } else {
                    $("#errors").html(
                        `<p class="error" id="field_error" style="background-color: rgba(179, 24, 24, 0.625);color:white;">${errorMessages.inactive}</p>`
                    );
                    $("#field_error").addClass('p-2');
                    // alert("Your account is not active. Please contact support.");
                    return;
                }
            }

        } catch (error) {
            console.error("Overall error:", error);
        }
    }

    // function sendOTP() {

    //     if (jQuery("#phone").val() && jQuery("#country_selector").val()) {
    //         var phoneNumber = '+' + jQuery("#country_selector").val() + '' + jQuery("#phone").val();
    //         var phone = jQuery("#phone").val();

    //         database.collection("users").where("phoneNumber", "==", phone).where("role", "==", 'customer').get().then(
    //             async function(snapshots) {
    //                 if (snapshots.docs.length) {
    //                     var userData = snapshots.docs[0].data();

    //                     if (userData.active == true) {

    //                         firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
    //                             .then(function(confirmationResult) {
    //                                 window.confirmationResult = confirmationResult;
    //                                 if (confirmationResult.verificationId) {

    //                                     jQuery("#phone-box").hide();
    //                                     jQuery("#recaptcha-container").hide();
    //                                     jQuery("#otp-box").show();
    //                                     jQuery("#verify_btn").show();
    //                                 }
    //                             });
    //                     } else {
    //                         $("#password_required_new1").html(
    //                             "{{ trans('lang.account_disable_contact_admin') }}");
    //                     }
    //                 } else {
    //                     jQuery("#password_required_new").html("{{ trans('lang.user_not_found') }}");
    //                 }
    //             });
    //     } else {
    //         jQuery("#password_required_new").html("{{ trans('lang.please_enter_phone_number') }}");

    //     }
    // }

    // function applicationVerifier() {
    //     window.confirmationResult.confirm(document.getElementById("verificationcode").value)
    //         .then(function(result) {

    //             database.collection("users").where('phoneNumber', '==', (result.user.phoneNumber).substring(3))
    //                 .get().then(async function(snapshots_login) {
    //                     userData = snapshots_login.docs[0].data();
    //                     if (userData) {
    //                         if (userData.role == "customer") {
    //                             var uid = result.user.uid;
    //                             var user = result.user.uid;
    //                             var firstName = userData.firstName;

    //                             var lastName = userData.lastName;
    //                             var imageURL = userData.profilePictureURL;
    //                             if (userData.hasOwnProperty('shippingAddress')) {
    //                                 userData.shippingAddress.forEach(element => {
    //                                     if (element.isDefault == true) {
    //                                         setCookie('address_lat', element.location.latitude,
    //                                             365);
    //                                         setCookie('address_lng', element.location.longitude,
    //                                             365);
    //                                     }
    //                                 });
    //                             }


    //                             var url = "{{ route('setToken') }}";
    //                             $.ajax({
    //                                 type: 'POST',
    //                                 url: url,
    //                                 data: {
    //                                     id: uid,
    //                                     userId: user,
    //                                     email: userData.phoneNumber,
    //                                     password: '',
    //                                     firstName: firstName,
    //                                     lastName: lastName,
    //                                     profilePicture: imageURL
    //                                 },
    //                                 headers: {
    //                                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                                 },
    //                                 success: function(data) {
    //                                     if (data.access) {
    //                                         window.location = "{{ url('/') }}";
    //                                     }
    //                                 }
    //                             });
    //                         } else {
    //                             jQuery("#password_required_new").html(
    //                                 "{{ trans('lang.user_not_found') }}");
    //                         }
    //                     }
    //                 })
    //         }).catch(function(error) {
    //             jQuery("#password_required_new").html("{{ trans('lang.invalid_otp') }}");
    //         });
    // }


    // var newcountriesjs = JSON.parse(newcountriesjs);

    // function formatState(state) {

    //     if (!state.id) {
    //         return state.text;
    //     }
    //     var baseUrl = "<?php echo URL::to('/'); ?>/flags/120/";
    //     var $state = $(
    //         '<span><img src="' + baseUrl + '/' + newcountriesjs[state.element.value].toLowerCase() +
    //         '.png" class="img-flag" /> ' + state.text + '</span>'
    //     );
    //     return $state;
    // }

    // function formatState2(state) {
    //     if (!state.id) {
    //         return state.text;
    //     }

    //     var baseUrl = "<?php echo URL::to('/'); ?>/flags/120/";
    //     var $state = $(
    //         '<span><img class="img-flag" /> <span></span></span>'
    //     );
    //     $state.find("span").text(state.text);
    //     $state.find("img").attr("src", baseUrl + "/" + newcountriesjs[state.element.value].toLowerCase() + ".png");

    //     return $state;
    // }

    // function setCookie(name, value, days) {
    //     var expires = "";
    //     if (days) {
    //         var date = new Date();
    //         date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    //         expires = "; expires=" + date.toUTCString();
    //     }
    //     document.cookie = name + "=" + (value || "") + expires + "; path=/";
    // }

    // function chkAlphabets2(event, msg) {
    //     if (!(event.which >= 48 && event.which <= 57)) {
    //         document.getElementById(msg).innerHTML = "Accept only Number";
    //         return false;
    //     } else {
    //         document.getElementById(msg).innerHTML = "";
    //         return true;
    //     }
    // }
    // jQuery(document).ready(function() {

    //     jQuery("#country_selector").select2({
    //         templateResult: formatState,
    //         templateSelection: formatState2,
    //         placeholder: "Select Country",
    //         allowClear: true
    //     });

    // });
</script>
