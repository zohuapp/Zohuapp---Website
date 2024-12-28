@include('auth.default')

<?php
$countries = file_get_contents(asset('countriesdata.json'));
$countries = json_decode($countries);
$countries = (array) $countries;
$newcountries = array();
$newcountriesjs = array();
foreach ($countries as $keycountry => $valuecountry) {
    $newcountries[$valuecountry->phoneCode] = $valuecountry;
    $newcountriesjs[$valuecountry->phoneCode] = $valuecountry->code;
}
?>
<link href="{{ asset('vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ asset('/css/font-awesome.min.css')}}" rel="stylesheet">
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
                <h3 class="text-dark my-0 mb-3">{{trans('lang.login')}}</h3>
                <p class="text-50">{{trans('lang.sign_in_to_continue')}}</p>
                <div class="error" id="error"></div>

                <form class="form-horizontal form-material" name="loginwithphon" id="login-with-phone-box" action="#">
                    @csrf
                    <div class="box-title m-b-20">{{ __('Login') }}</div>
                    <div class="form-group " id="phone-box">
                        <div class="col-xs-12">

                            <select name="country" id="country_selector">
                                <?php foreach ($newcountries as $keycy => $valuecy) { ?>
                                    <?php    $selected = ""; ?>
                                    <option <?php    echo $selected; ?> code="<?php    echo $valuecy->code; ?>"
                                        value="<?php    echo $keycy; ?>">
                                        +<?php    echo $valuecy->phoneCode . "(" . $valuecy->countryName . ")"; ?></option>
                                <?php } ?>
                            </select>
                            <input class="form-control" placeholder="{{trans('lang.user_phone')}}" id="phone"
                                type="phone" class="form-control" name="phone" value="{{ old('phone') }}" required
                               onkeypress="return chkAlphabets2(event,'phone_number_err')" autocomplete="phone" autofocus>
                            <div id="phone_number_err"></div>
                        </div>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="error font-weight-bold text-center" id="password_required_new"></div>
                    <div class="form-group " id="otp-box" style="display:none;">
                        <input class="form-control" placeholder="{{trans('lang.otp')}}" id="verificationcode"
                            type="text" class="fo
                               rm-control" name="otp" value="{{ old('otp') }}" required autocomplete="otp" autofocus>
                    </div>
                    <div id="recaptcha-container" style="display:none;"></div>
                    <div class="error" id="password_required_new1"></div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button type="button" style="display:none;" onclick="applicationVerifier()" id="verify_btn"
                                class="btn btn-dark btn-lg btn-block text-uppercase waves-effect waves-light btn btn-primary remove_hover">{{trans('lang.otp_verify')}}</button>
                            <button type="button" onclick="sendOTP()" id="sendotp_btn"
                                class="btn btn-dark btn-lg btn-block text-uppercase waves-effect waves-light btn btn-primary remove_hover">{{trans('lang.otp_send')}}</button>
                            <div class="or-line mb-3 mt-3">
                                <span>OR</span>
                            </div>

                            <a href="{{route('signup')}}"
                                class="btn btn-primary btn-lg btn-block remove_hover">{{trans('lang.sign_up')}}</a>



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

    function loginWithPhoneClick() {
        jQuery("#login-box").hide();
        jQuery("#login-with-phone-box").show();
        jQuery("#phone-box").show();
        jQuery("#recaptcha-container").show();
        jQuery("#sendotp_btn").show();
    }

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
        'size': 'invisible',
        'callback': (response) => {
        }
    });

    const appVerifier = window.recaptchaVerifier;

    function sendOTP() {

        if (jQuery("#phone").val() && jQuery("#country_selector").val()) {
            var phoneNumber = '+' + jQuery("#country_selector").val() + '' + jQuery("#phone").val();
            var phone = jQuery("#phone").val();

            database.collection("users").where("phoneNumber", "==", phone).where("role", "==", 'customer').get().then(async function (snapshots) {
                if (snapshots.docs.length) {
                    var userData = snapshots.docs[0].data();

                    if (userData.active == true) {

                        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                            .then(function (confirmationResult) {
                                window.confirmationResult = confirmationResult;
                                if (confirmationResult.verificationId) {

                                    jQuery("#phone-box").hide();
                                    jQuery("#recaptcha-container").hide();
                                    jQuery("#otp-box").show();
                                    jQuery("#verify_btn").show();
                                }
                            });
                    }
                    else {
                        $("#password_required_new1").html("{{trans('lang.account_disable_contact_admin')}}");
                    }
                } else {
                    jQuery("#password_required_new").html("{{trans('lang.user_not_found')}}");
                }
            });
        } else {
            jQuery("#password_required_new").html("{{trans('lang.please_enter_phone_number')}}");

        }
    }

    function applicationVerifier() {
        window.confirmationResult.confirm(document.getElementById("verificationcode").value)
            .then(function (result) {

                database.collection("users").where('phoneNumber', '==', (result.user.phoneNumber).substring(3)).get().then(async function (snapshots_login) {
                    userData = snapshots_login.docs[0].data();
                    if (userData) {
                        if (userData.role == "customer") {
                            var uid = result.user.uid;
                            var user = result.user.uid;
                            var firstName = userData.firstName;

                            var lastName = userData.lastName;
                            var imageURL = userData.profilePictureURL;
                            if (userData.hasOwnProperty('shippingAddress')) {
                                userData.shippingAddress.forEach(element => {
                                    if (element.isDefault == true) {
                                        setCookie('address_lat', element.location.latitude, 365);
                                        setCookie('address_lng', element.location.longitude, 365);
                                    }
                                });
                            }


                            var url = "{{route('setToken')}}";
                            $.ajax({
                                type: 'POST',
                                url: url,
                                data: {
                                    id: uid,
                                    userId: user,
                                    email: userData.phoneNumber,
                                    password: '',
                                    firstName: firstName,
                                    lastName: lastName,
                                    profilePicture: imageURL
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function (data) {
                                    if (data.access) {
                                        window.location = "{{url('/')}}";
                                    }
                                }
                            });
                        } else {
                            jQuery("#password_required_new").html("{{trans('lang.user_not_found')}}");
                        }
                    }
                })
            }).catch(function (error) {
                jQuery("#password_required_new").html("{{trans('lang.invalid_otp')}}");
            });
    }


    var newcountriesjs = '<?php echo json_encode($newcountriesjs); ?>';
    var newcountriesjs = JSON.parse(newcountriesjs);

    function formatState(state) {

        if (!state.id) {
            return state.text;
        }
        var baseUrl = "<?php echo URL::to('/'); ?>/flags/120/";
        var $state = $(
            '<span><img src="' + baseUrl + '/' + newcountriesjs[state.element.value].toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    }

    function formatState2(state) {
        if (!state.id) {
            return state.text;
        }

        var baseUrl = "<?php echo URL::to('/'); ?>/flags/120/";
        var $state = $(
            '<span><img class="img-flag" /> <span></span></span>'
        );
        $state.find("span").text(state.text);
        $state.find("img").attr("src", baseUrl + "/" + newcountriesjs[state.element.value].toLowerCase() + ".png");

        return $state;
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
    function chkAlphabets2(event, msg) {
        if (!(event.which >= 48 && event.which <= 57)
        ) {
            document.getElementById(msg).innerHTML = "Accept only Number";
            return false;
        }
        else {
            document.getElementById(msg).innerHTML = "";
            return true;
        }
    }
    jQuery(document).ready(function () {

        jQuery("#country_selector").select2({
            templateResult: formatState,
            templateSelection: formatState2,
            placeholder: "Select Country",
            allowClear: true
        });

    });
</script>