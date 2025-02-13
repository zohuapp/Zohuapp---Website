@include('layouts.app')

@include('layouts.header')


<div class="siddhi-profile">

    <div class="container position-relative">
        <div class="py-5 siddhi-profile row">
            <div class="col-md-4 mb-3">
                <div class="bg-white rounded shadow-sm sticky_sidebar overflow-hidden">
                    <a href="{!! url('profile') !!}" class="">
                        <div class="d-flex align-items-center p-3">
                            <div class="left mr-3 user_image">
                            </div>
                            <div class="right">
                                <h6 class="mb-1 font-weight-bold user_full_name"></h6>
                                <p class="text-muted m-0 small"><span class="user_email_show"></span></p>
                            </div>
                        </div>
                    </a>
                    <div class="siddhi-credits d-flex align-items-center p-3 bg-light">
                        <p class="m-0">{{trans('lang.wallet_amount')}}</p>
                        <h5 class="m-0 ml-auto text-primary user_wallet"></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-3">
                <div class="rounded shadow-sm p-4 bg-white">
                    <h5 class="mb-4">{{trans('lang.my_account')}}</h5>
                    <div id="edit_profile">
                        <div class="error_top"></div>
                        <div>
                            <div class="form-group">
                                <label>{{trans('lang.full_name')}}</label>
                                <input type="text" class="form-control user_name" value="">
                            </div>
                            <div class="form-group">
                                <label>{{trans('lang.email')}}</label>
                                <input type="text" class="form-control user_email">
                            </div>
                            <div class="form-group">
                                <label>{{trans('lang.user_phone')}}</label>
                                <input type="text" class="form-control user_phone" value="">
                            </div>
                            <div class="form-group">
                                <label>{{trans('lang.restaurant_image')}}</label>
                                <input type="file" onChange="handleFileSelect(event)">
                            </div>
                            <div class="form-group">
                                <div class="placeholder_img_thumb user_image"></div>
                                <div id="uploding_image"></div>
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                        class="btn btn-primary btn-block save_user_btn remove_hover">{{ trans('lang.save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('layouts.footer')

@include('layouts.nav')

<script src="{{ asset('js/crypto-js.js') }}"></script>


<script type="text/javascript">

    var id = user_uuid;
    var database = firebase.firestore();
    var ref = database.collection('users').where("id", "==", id);

    var currentCurrency = '';
    var currencyAtRight = false;
    var decimal = 0;

    var address_name = getCookie('address_name');
    var address_name1 = getCookie('address_name1');
    var address_name2 = getCookie('address_name2');
    var address_zip = getCookie('address_zip');
    var address_city = getCookie('address_city');
    var address_state = getCookie('address_state');
    var address_country = getCookie('address_country');

    var refCurrency = database.collection('currencies').where('isActive', '==', true);

    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal = currencyData.decimal_degits;
        }
    });


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

    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }


    var photo = "";

    $(document).ready(function () {

        ref.get().then(async function (snapshots) {

            var user = snapshots.docs[0].data();
            var wallet_amount_user = 0;

            $(".user_email_show").html(user.email);
            $(".user_full_name").text(user.name);

            if (user.hasOwnProperty('walletAmount') && user.walletAmount != '' && user.walletAmount!=null && user.walletAmount != '0' ) {
                wallet_amount_user = user.walletAmount;
            }

            wallet_amount_user = parseFloat(wallet_amount_user).toFixed(decimal);

            if (currencyAtRight) {
                wallet_amount_user = wallet_amount_user + " " + currentCurrency;
            } else {
                wallet_amount_user = currentCurrency + " " + wallet_amount_user;
            }


            $(".user_wallet").html(wallet_amount_user);

            $(".user_name").val(user.name);
            $(".user_email").val(user.email);
            $(".user_phone").val(user.phoneNumber);

            photo = user.image;
            if (photo != '') {
                if(user.image){
                    photo=user.image;
                }else{
                    photo=placeholderImage;
                }

                $(".user_image").append('<img class="rounded" style="width:50px" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image">');
            } else {

                $(".user_image").append('<img class="rounded" style="width:50px" src="' + placeholderImage + '" alt="image">');
            }

            jQuery("#overlay").hide();

        })

        $(".save_user_btn").click(function () {

            var businessAddress = getCookie('address_name');
            var lat = getCookie('address_lat');
            var lng = getCookie('address_lng');
            var location = {"latitude":parseFloat(lat),"longitude":parseFloat(lng)};

            var user_name = $(".user_name").val();
            var email = $(".user_email").val();
            var userPhone = $(".user_phone").val();
            if (user_name == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.user_firstname_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (email == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.user_email_error')}}</p>");
                window.scrollTo(0, 0);
            } else if (userPhone == '') {
                $(".error_top").show();
                $(".error_top").html("");
                $(".error_top").append("<p>{{trans('lang.user_phone_error')}}</p>");
                window.scrollTo(0, 0);
            }
            else {

                database.collection('users').doc(id).update({
                    'email': email,
                    'phoneNumber': userPhone,
                    'location': location,
                    'image': photo,
                    'role': 'customer',
                    'name': user_name,
                    'active': true
                }).then(function (result) {
                    window.location.href = '{{ url("/")}}';
                });
            }

        })


    })
    var storageRef = firebase.storage().ref('images');


    function handleFileSelect(evt) {
        var f = evt.target.files[0];
        var reader = new FileReader();

        reader.onload = (function (theFile) {
            return function (e) {

                var filePayload = e.target.result;
                var hash = CryptoJS.SHA256(Math.random() + CryptoJS.SHA256(filePayload));
                var val = f.name;
                var ext = val.split('.')[1];
                var docName = val.split('fakepath')[1];
                var filename = (f.name).replace(/C:\\fakepath\\/i, '')

                var timestamp = Number(new Date());
                var filename = filename.split('.')[0] + "_" + timestamp + '.' + ext;

                var uploadTask = storageRef.child(filename).put(theFile);

                uploadTask.on('state_changed', function (snapshot) {
                    var progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                    jQuery("#uploding_image").text("Image is uploading...");
                }, function (error) {
                }, function () {
                    uploadTask.snapshot.ref.getDownloadURL().then(function (downloadURL) {
                        jQuery("#uploding_image").text("Upload is completed");
                        photo = downloadURL;
                        $(".user_image").empty();
                        if(downloadURL){
                            photo=downloadURL;
                        }else{
                            photo=placeholderImage;
                        }
                        $(".user_image").append('<img class="rounded" style="width:50px" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" alt="image">');


                    });
                });

            };
        })(f);
        reader.readAsDataURL(f);
    }

</script>
