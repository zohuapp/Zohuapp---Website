@include('auth.default')

@php
    $countries = file_get_contents(public_path('countriesdata.json'));
    $countries = json_decode($countries);
    $countries = (array) $countries;
    $newcountries = [];
    $newcountriesjs = [];
    foreach ($countries as $keycountry => $valuecountry) {
        $newcountries[$valuecountry->phoneCode] = $valuecountry;
        $newcountriesjs[$valuecountry->phoneCode] = $valuecountry->code;
    }
@endphp

<link href="{{ asset('vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet">
<style>
    #mobileNumber {
        padding-left: 52% !important;
    }

    #select2-country_selector-container {
        max-width: fit-content;
    }
</style>

<div class="siddhi-signup login-page vh-100">


    <div class="d-flex align-items-center justify-content-center py-3">
        <div id="overlay">
            <img src="{{ asset('img/spinner.gif') }}">
        </div>
        <div class="col-md-6">

            <div class="col-10 mx-auto card p-3">

                <h3 class="text-dark my-0 mb-3">{{ trans('lang.sign_up_with_us') }}</h3>

                <p class="text-50">{{ trans('lang.sign_up_to_continue') }}</p>

                <div class="error" id="field_error"></div>

                {{-- register form --}}
                <form class="mt-3 mb-4">
                    <div id="password_required_new"></div>
                    {{-- full name --}}
                    <div class="form-group" id="fullName_div">
                        <label for="firstName" class="text-dark">{{ trans('lang.full_name') }}</label>
                        <input type="text" name="fullName" placeholder="{{ trans('lang.full_name_help') }}"
                            class="form-control" id="userName" required>
                        <div id="error2" class="err"></div>
                    </div>

                    {{-- email --}}
                    <div class="form-group" id="email-box">
                        <label for="email" class="text-dark">{{ trans('lang.user_email') }}</label>
                        <div class="col-xs-12">
                            <input class="form-control" placeholder="{{ trans('lang.user_email_help') }}" id="userEmail"
                                type="phone" name="email" value="{{ old('email') }}" required autocomplete="email">
                        </div>
                    </div>

                    {{-- password --}}
                    <div class="form-group">
                        <label for="userPassword" class="form-label">Password</label>
                        <input type="password" name="password" placeholder="{{ trans('lang.user_password_help') }}"
                            class="form-control" required id="userPassword">
                    </div>

                    {{-- submit button --}}
                    <button type="button" onclick="signUpUser()"
                        class="btn btn-primary btn-lg btn-block send-code remove_hover">
                        {{ trans('lang.sign_up') }}
                    </button>
                </form>
            </div>

            <div class="new-acc d-flex align-items-center justify-content-center mt-4 mb-3">

                <a href="{{ url('login') }}">

                    <p class="text-center m-0"> {{ trans('lang.already_an_account') }} {{ trans('lang.sign_in') }}
                    </p>

                </a>

            </div>

        </div>

    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194"
    integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw=="
    data-cf-beacon='{"rayId":"6c83f3c58cbe41ab","version":"2021.12.0","r":1,"token":"dd471ab1978346bbb991feaa79e6ce5c","si":100}'
    crossorigin="anonymous"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.0/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.0/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.0/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.2.0/firebase-database.js"></script>
<script src="https://unpkg.com/geofirestore/dist/geofirestore.js"></script>
<script src="https://cdn.firebase.com/libs/geofire/5.0.1/geofire.min.js"></script>
<script src="{{ asset('js/crypto-js.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
{{-- <script src="{{ asset('js/jquery.validate.js') }}"></script> --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script type="text/javascript">
    var firebaseConfig = {
        apiKey: "{{ config('firebase.apiKey') }}",
        authDomain: "{{ config('firebase.authDomain') }}",
        databaseURL: "{{ config('firebase.databaseURL') }}",
        projectId: "{{ config('firebase.projectId') }}",
        storageBucket: "{{ config('firebase.storageBucket') }}",
        messagingSenderId: "{{ config('firebase.messagingSenderId') }}",
        appId: "{{ config('firebase.appId') }}",
        measurementId: "{{ config('firebase.measurementId') }}"
    }

    firebase.initializeApp(firebaseConfig);

    var googleMapKey = '';
    var database = firebase.firestore();
    var createdAtman = firebase.firestore.Timestamp.fromDate(new Date());
    var googleMapKeySettingHeader = database.collection('settings').doc("googleMapKey");
    var address_name = getCookie('address_name');
    var address_name1 = getCookie('address_name1');
    var address_name2 = getCookie('address_name2');
    var address_zip = getCookie('address_zip');
    var newcountriesjs = '<?php echo json_encode($newcountriesjs); ?>';
    var newcountriesjs = JSON.parse(newcountriesjs);
    var shippingAdrs = [];
    var pincode = '';

    function initialize() {
        if (address_name != '') {
            document.getElementById('business_address').value = address_name;
        }
        var input = document.getElementById('business_address');
        autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {

            var place = autocomplete.getPlace();

            address_name = place.formatted_address;

            address_lat = place.geometry.location.lat();

            address_lng = place.geometry.location.lng();


            $.each(place.address_components, function(i, address_component) {


                address_name1 = '';
                address_name2 = '';

                if (address_component.types[0] == "premise") {
                    if (address_name1 == '') {
                        address_name1 = address_component.long_name;
                    } else {
                        address_name2 = address_component.long_name;
                    }
                } else if (address_component.types[0] == "postal_code") {

                    var address_zip = address_component.long_name;
                    pincode = address_zip;

                } else if (address_component.types[0] == "locality") {

                    var address_city = address_component.long_name;

                } else if (address_component.types[0] == "administrative_area_level_1") {

                    var address_state = address_component.long_name;

                } else if (address_component.types[0] == "country") {

                    var address_country = address_component.long_name;

                }

            });


            setCookie('address_name1', address_name1, 365);

            setCookie('address_name2', address_name2, 365);

            setCookie('address_name', address_name, 365);

            setCookie('address_lat', address_lat, 365);

            setCookie('address_lng', address_lng, 365);

            setCookie('address_zip', address_zip, 365);

        });
    }
    googleMapKeySettingHeader.get().then(async function(googleMapKeySnapshotsHeader) {
        var placeholderImageHeaderData = googleMapKeySnapshotsHeader.data();
        placeholderImageHeader = placeholderImageHeaderData.placeHolderImage;
        googleMapKey = placeholderImageHeaderData.key;
    });
    async function loadGoogleMapsScript() {
        await database.collection('settings').doc("googleMapKey").get().then(function(googleMapKeySnapshotsHeader) {
            var placeholderImageHeaderData = googleMapKeySnapshotsHeader.data();
            googleMapKey = placeholderImageHeaderData.key;
            const script = document.createElement('script');
            script.src = "https://maps.googleapis.com/maps/api/js?key=" + googleMapKey +
                "&libraries=places";
            script.onload = function() {
                initialize();
            };
            document.head.appendChild(script);
        });
    }

    async function getCurrentLocation() {
        var geocoder = new google.maps.Geocoder();
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords
                        .longitude);
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    var location = new google.maps.LatLng(pos['lat'], pos[
                        'lng']); // turn coordinates into an object
                    geocoder.geocode({
                        'latLng': location
                    }, async function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results.length > 0) {
                                document.getElementById('business_address').value = results[0]
                                    .formatted_address;
                                address_name1 = '';
                                $.each(results[0].address_components, async function(i,
                                    address_component) {
                                    address_name1 = '';

                                    if (address_component.types[0] == "premise") {
                                        if (address_name1 == '') {
                                            address_name1 = address_component
                                                .long_name;
                                        }
                                    }
                                });
                                address_name = results[0].formatted_address;
                                address_lat = results[0].geometry.location.lat();
                                address_lng = results[0].geometry.location.lng();
                                setCookie('address_name1', address_name1, 365);
                                setCookie('address_name', address_name, 365);
                                setCookie('address_lat', address_lat, 365);
                                setCookie('address_lng', address_lng, 365);
                            }
                        }
                    });
                    try {
                        if (autocomplete) {
                            autocomplete.setBounds(circle.getBounds());
                        }
                    } catch (err) {}
                },
                function() {});
        }
    }

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    function getCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    function checkcharecter(event, msg) {
        if (!(event.which > 64 && event.which < 91 || event.which > 96 && event.which < 123 || event.which == 32)) {
            document.getElementById(msg).innerHTML = "Accept only letters";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }

    function chkAlphabets2(event, msg) {
        if (!(event.which >= 48 && event.which <= 57)) {
            document.getElementById(msg).innerHTML = "Accept only Number";
            return false;
        } else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }

    function formatState(state) {

        if (!state.id) {
            return state.text;
        }
        var baseUrl = "<?php echo URL::to('/'); ?>/flags/120/";
        var $state = $(
            '<span><img src="' + baseUrl + '/' + newcountriesjs[state.element.value].toLowerCase() +
            '.png" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    }

    function formatState2(state) {
        if (!state.id) {
            return state.text;
        }

        var baseUrl = "<?php echo URL::to('/'); ?>/flags/120/"
        var $state = $(
            '<span><img class="img-flag" /> <span></span></span>'
        );
        $state.find("span").text(state.text);
        $state.find("img").attr("src", baseUrl + "/" + newcountriesjs[state.element.value].toLowerCase() + ".png");

        return $state;
    }

    jQuery(document).ready(function() {
        loadGoogleMapsScript();

        $('.location-group .locate-me').attr("onclick", "getCurrentLocation()");
        jQuery("#country_selector").select2({
            templateResult: formatState,
            templateSelection: formatState2,
            placeholder: "Select Country",
            allowClear: true
        });


    });

    async function signUpUser() {

        const name = $("#userName").val();
        const email = $("#userEmail").val();
        const password = $("#userPassword").val();

        // alert(name);

        // If user doesn't exist in Firestore or is not active, create the user in Firebase Auth:
        try {
            const checkUser = await firebase.firestore().collection('users') // Use firebase.firestore()
                .where("email", "==", email)
                .where("role", "==", "customer")
                .get();

            if (checkUser.docs.length <= 0) {
                const userCredential = await firebase.auth().createUserWithEmailAndPassword(email, password);
                const user = userCredential.user;

                // Store additional user data in Firestore (including the password if absolutely necessary – but consider not storing it due to security risks):
                await firebase.firestore().collection('users').doc(user.uid).set({ // Use user.uid for doc ID
                    email: email,
                    role: "customer",
                    'id': user.uid,
                    active: true, // or whatever default value you want
                });

                console.log("User signed up and data stored:", user);
                alert("User signed up");

                const uuid = user.uid;
                const url = "{{ route('setToken') }}";

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        userId: uuid,
                        id: uuid,
                        email: email,
                        password: password,
                        name: name,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(data) {
                        if (data.access) {
                            window.location = "{{ url('/') }}";
                        }
                    }
                })
            } else {
                alert("Account already exists with the required credentials. Please sign In.");
                return;
            }
            // return;

        } catch (signUpError) {
            // console.error("Sign-up error:", signUpError);
            // Handle sign-up errors (e.g., weak password, email already in use):
            if (signUpError.code === 'auth/weak-password') {
                alert(signUpError.message);
            } else if (signUpError.code === 'auth/email-already-in-use') {
                alert(signUpError.message);
            } else {
                alert("An error occurred during sign up. Please try again.");
            }
        }
    }

    // Start of sign-up form and send otp method
    // window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
    //     'size': 'normal',
    //     'callback': (response) => {
    //         console.log(response);
    //     }
    // });

    // sendOTP method will be triggerd on sign-up form submission
    // function sendOTP() {

    //     // $('#overlay').show();
    //     // check if recaptcha is not verified so verify it again
    //     if (!window.recaptchaVerifier) {
    //         jQuery("#recaptcha-container").show();

    //         window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
    //             'size': 'normal',
    //             'callback': (response) => {

    //             }
    //         });
    //     }
    //     if (jQuery("#mobileNumber").val() && jQuery("#country_selector").val()) {
    //         var fullPhoneNumber = '+' + jQuery("#country_selector").val() + jQuery("#mobileNumber").val();
    //         var phoneNumber = jQuery("#mobileNumber").val();

    //         database.collection("users").where('phoneNumber', '==', phoneNumber).get().then(async function(snapshots) {

    //             if (snapshots.docs.length > 0) {
    //                 $('#overlay').hide();
    //                 alert('{{ trans('lang.phone_number_already_exist') }}');
    //                 return false;
    //             } else {
    //                 firebase.auth().signInWithPhoneNumber(fullPhoneNumber, window.recaptchaVerifier)
    //                     .then(function(confirmationResult) {
    //                         window.confirmationResult = confirmationResult;
    //                         if (confirmationResult.verificationId) {
    //                             $('#fullName_div').hide();
    //                             $('#user_image_div').hide();
    //                             $('#phone-box').hide();
    //                             $('#email-box').hide();
    //                             $('.businessDetail_div').hide();
    //                             $('#send-code').hide();
    //                             $('#resend-code').show();
    //                             jQuery("#recaptcha-container").hide();
    //                             jQuery("#otp-box").show();
    //                             $('#verificationcode').attr('required', 'true');
    //                             jQuery("#verify_btn").show();
    //                             $('#overlay').hide();
    //                         }
    //                     }).catch(function(error) {
    //                         console.error("Error during signInWithPhoneNumber:", error);
    //                         // throw new Error("Error during signInWithPhoneNumber:", error);

    //                         $('#overlay').hide();
    //                         alert("Failed to send OTP. Please try again.");
    //                     });
    //             }
    //         })


    //     }

    // }

    // function applicationVerifier() {
    //     var code = $('#verificationcode').val();

    //     if (code == "") {
    //         $('.otp_error').html('{{ trans('lang.please_enter_otp') }}');
    //     } else {
    //         window.confirmationResult.confirm(document.getElementById("verificationcode").value)
    //             .then(async function(result) {

    //                 var address_lat = getCookie('address_lat');
    //                 var address_lng = getCookie('address_lng');
    //                 var businessAddress = getCookie('address_name');
    //                 var location = {
    //                     latitude: parseFloat(address_lat),
    //                     longitude: parseFloat(address_lng)
    //                 }
    //                 var adrsId = database.collection('tmp').doc().id;
    //                 address = {
    //                     'address': null,
    //                     'addressAs': null,
    //                     'isDefault': true,
    //                     'landmark': null,
    //                     'locality': businessAddress,
    //                     'location': location,
    //                     'id': adrsId,
    //                     'pinCode': pincode
    //                 }

    //                 shippingAdrs.push(address);

    //                 var countryCode = '+' + jQuery("#country_selector").val();
    //                 var email = $('#email').val();
    //                 var image = " ";
    //                 var location = {
    //                     "latitude": parseFloat(address_lat),
    //                     "longitude": parseFloat(address_lng)
    //                 };
    //                 var name = $("#fullName").val();
    //                 var phoneNumber = jQuery("#mobileNumber").val();
    //                 var uuid = result.user.uid;

    //                 database.collection("users").doc(uuid).set({
    //                     'active': true,
    //                     'id': uuid,
    //                     'shippingAddress': shippingAdrs,
    //                     'countryCode': countryCode,
    //                     'createdAt': createdAtman,
    //                     'email': email,
    //                     'fcmToken': "",
    //                     'image': image,
    //                     'name': name,
    //                     'phoneNumber': phoneNumber,
    //                     'role': "customer",
    //                     'walletAmount': "0"
    //                 }).then(() => {
    //                     var url = "{{ route('setToken') }}";

    //                     $.ajax({
    //                         type: 'POST',
    //                         url: url,
    //                         data: {
    //                             userId: uuid,
    //                             id: uuid,
    //                             email: phoneNumber,
    //                             password: "",
    //                             name: name,
    //                         },
    //                         headers: {
    //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                         },

    //                         success: function(data) {
    //                             if (data.access) {
    //                                 window.location = "{{ url('/') }}";
    //                             }
    //                         }
    //                     })
    //                 }).catch((error) => {
    //                     $("#field_error").html(error);
    //                 });
    //             }).catch((error) => {
    //                 $(".otp_error").html("{{ trans('lang.invalid_otp') }}");

    //             });
    //     }

    // }
</script>
