<span style="display: none;">
    <button type="button" class="btn btn-primary" id="notification_accepted_order_by_restaurant_id" data-toggle="modal"
        data-target="#notification_accepted_order_by_restaurant">{{ trans('lang.large_modal') }}</button>
</span>
<div class="modal fade" id="notification_accepted_order_by_restaurant" tabindex="-1" role="dialog"
    aria-labelledby="notification_accepted_order_by_restaurant" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered notification-main" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title order_accepted_subject" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6><span id="restaurnat_name"></span></h6>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"><a href="{{ url('my_order') }}"
                        id="notification_accepted_order_by_restaurant_a">{{ trans('lang.go') }}</a>
                </button>
            </div>
        </div>
    </div>
</div>


<span style="display: none;">

    <button type="button" class="btn btn-primary" id="notification_rejected_order_by_restaurant_id" data-toggle="modal"
        data-target="#notification_rejected_order_by_restaurant">{{ trans('lang.large_modal') }}</button>

</span>

<div class="modal fade" id="notification_rejected_order_by_restaurant" tabindex="-1" role="dialog"
    aria-labelledby="notification_accepted_order_by_restaurant" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered notification-main" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title restaurant_rejected_order" id="exampleModalLongTitle"></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <h6><span id="restaurnat_name_1"></span></h6>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary"><a href="{{ url('my_order') }}"
                        id="notification_rejected_order_by_restaurant_a">{{ trans('lang.go') }}</a>
                </button>

            </div>

        </div>

    </div>

</div>


<span style="display: none;">

    <button type="button" class="btn btn-primary" id="notification_accepted_order_id" data-toggle="modal"
        data-target="#notification_accepted_order">{{ trans('lang.large_modal') }}</button>

</span>

<div class="modal fade" id="notification_accepted_order" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered notification-main" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title driver_accepted_subject ml-auto" id="exampleModalLongTitle"></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <h6><span id="np_accept_name"></span></h6>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary"><a href="{{ url('my_order') }}"
                        id="notification_accepted_a">{{ trans('lang.go') }}</a>
                </button>

            </div>

        </div>

    </div>

</div>

<span style="display: none;">

    <button type="button" class="btn btn-primary" id="notification_order_complete_id" data-toggle="modal"
        data-target="#notification_order_complete">{{ trans('lang.large_modal') }}</button>

</span>

<div class="modal fade" id="notification_order_complete" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered notification-main" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title order_completed_subject ml-auto" id="exampleModalLongTitle">
                    {{ trans('lang.order_completed') }}
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <h6 id="order_completed_msg"></h6>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-primary"><a
                        id="notification_oder_compeleted_a"href="{{ url('my_order') }}"
                        id="">{{ trans('lang.go') }}</a></button>

            </div>

        </div>

    </div>

</div>


<span style="display: none;">

    <button type="button" class="btn btn-primary" id="notification_accepted_dining_by_restaurant_id"
        data-toggle="modal"
        data-target="#notification_accepted_dining_by_restaurant">{{ trans('lang.large_modal') }}</button>

</span>


<span style="display: none;">

    <button type="button" class="btn btn-primary" id="notification_rejected_dining_by_restaurant_id"
        data-toggle="modal"
        data-target="#notification_rejected_dining_by_restaurant">{{ trans('lang.large_modal') }}</button>

</span>


<footer class="section-footer border-top bg-dark">
    <div class="footerTemplate"></div>
</footer>

<script type="text/javascript" src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/sidebar/hc-offcanvas-nav.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/slick/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/slick/slick-lightbox.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/siddhi.js') }}"></script>
<script src="{{ asset('js/jquery.resizeImg.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert2.js') }}"></script>

<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-firestore.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-storage.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.1/firebase-database.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

<script src="{{ asset('js/crypto-js.js') }}"></script>
<script src="{{ asset('js/jquery.cookie.js') }}"></script>
{{-- <script src="{{ asset('js/jquery.validate.js') }}"></script> --}}

<script type="text/javascript">
    var section_colorman = '<?php echo @$_COOKIE['section_color']; ?>';
    var application_name = '<?php echo @$_COOKIE['application_name']; ?>';
    var meta_title = '<?php echo @$_COOKIE['meta_title']; ?>';

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

    const app1 = firebase.initializeApp(firebaseConfig, 'myFirstApp');

    var database = app1.firestore();

    var globalSettingsRef = database.collection('settings').doc('globalSettings');
    globalSettingsRef.get().then(async function(globalSettingsSnapshots) {
        var globalSettingsData = globalSettingsSnapshots.data();
        var src_new = globalSettingsData.appLogo;
        if (src_new) {
            photo = src_new;

        } else {
            photo = placeholderImage;
        }
        $('#logo_web').html('<img alt="#" class="logo_web img-fluid" src="' + src_new +
            '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">');

        $('.location-group .locate-me').attr("onclick", "getCurrentLocation()");

        $("#logo_web").attr('src', globalSettingsData.appLogo);
        $('.hc-offcanvas-nav h2').html(globalSettingsData.applicationName);
        $("#footer_logo_web").attr('src', globalSettingsData.appLogo);
        setCookie('application_name', globalSettingsData.applicationName, 365);
        setCookie('section_color', globalSettingsData.color_website, 365);
        setCookie('meta_title', globalSettingsData.meta_title, 365);
        setCookie('favicon', globalSettingsData.favicon, 365);
        document.title = globalSettingsData.meta_title;
    });
</script>
<script type="text/javascript">
   <?php $id = null;
    if (Auth::user()) {
        $id = Auth::user()->getVendorId();
    } ?>

    var cuser_id = '<?php echo $id; ?>';

    var place = [];

    var database = app1.firestore();

    var googleMapKey = '';

    async function loadGoogleMapsScript() {

        await database.collection('settings').doc("googleMapKey").get().then(function(googleMapKeySnapshotsHeader) {

            var placeholderImageHeaderData = googleMapKeySnapshotsHeader.data();
            googleMapKey = placeholderImageHeaderData.key;

            const script = document.createElement('script');
            script.src = "https://maps.googleapis.com/maps/api/js?key=" + googleMapKey +
                "&loading=async&libraries=places";
            script.onload = function() {
                setTimeout(() => {
                    initialize();
                }, 2000);

            };
            document.head.appendChild(script);

        });

    }

    loadGoogleMapsScript();

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

    var footerRef = database.collection('settings').doc('footerTemplate');

    footerRef.get().then(async function(snapshots) {
        var footerData = snapshots.data();
        if (footerData != undefined) {
            if (footerData.footerTemplate && footerData.footerTemplate != "" && footerData.footerTemplate !=
                undefined) {
                $('.footerTemplate').html(footerData.footerTemplate);
            }
        }
    });

    database.collection('vendors').get().then(async function(snapshot) {
        if (snapshot.docs.length > 0) {
            storeOwnerData = snapshot.docs[0].data();
            var restaurant_latitude = storeOwnerData.latitude;
            var restaurant_longitude = storeOwnerData.longitude;
            setCookie('restaurant_latitude', restaurant_latitude, 365);
            setCookie('restaurant_longitude', restaurant_longitude, 365);
        }
    })

    function changeLanguage() {

        var langcount = 0;
        var languages_list_main = [];
        var languages_list = database.collection('languages').where('enable', '==', true);
        languages_list.get().then(async function(snapshotslang) {
            snapshotslang.forEach((doc) => {
                var data = doc.data();
                languages_list_main.push(data);
                langcount++;
                $('#language_dropdown').append($("<option></option>").attr("value", data.code).text(
                    data.name));
            });
            if (langcount > 1) {
                $("#language_dropdown_box").css('visibility', 'visible');
            }
           <?php if (session()->get('locale')) { ?>
            $("#language_dropdown").val("<?php echo session()->get('locale'); ?>");
           <?php } ?>
        });

        var url = "{{ route('changeLang') }}";

        $(".changeLang").change(function() {
            var code = $(this).val();
            languages_list_main.forEach((data) => {
                if (code == data.code) {
                    if (data.is_rtl == undefined) {
                        setCookie('is_rtl', 'false', 365);
                    } else {
                        setCookie('is_rtl', data.is_rtl.toString(), 365);
                    }
                    window.location.href = url + "?lang=" + code;
                }
            });
        });

    }

    var address_name = getCookie('address_name');

    async function initialize() {
        if (address_name != '') {

            document.getElementById('user_locationnew').value = address_name;
            document.getElementById('user_locationnew_mobile').value = address_name;
        }
        var input = document.getElementById('user_locationnew_mobile');
        var input2 = document.getElementById('user_locationnew');


        autocomplete2 = new google.maps.places.Autocomplete(input2);
        google.maps.event.addListener(autocomplete2, 'place_changed', function() {
            var place2 = autocomplete2.getPlace();

            address_name2 = place2.formatted_address;
            address_lat2 = place2.geometry.location.lat();
            address_lng2 = place2.geometry.location.lng();

           <?php if (@Route::current()->getName() != 'checkout') { ?>

            setCookie('address_name', address_name2, 365);

            setCookie('address_lat', address_lat2, 365);

            setCookie('address_lng', address_lng2, 365);

           <?php } ?>
            window.location.reload();

        });
        autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();

            address_name = place.formatted_address;
            address_lat = place.geometry.location.lat();
            address_lng = place.geometry.location.lng();

           <?php if (@Route::current()->getName() != 'checkout') { ?>

            setCookie('address_name', address_name, 365);

            setCookie('address_lat', address_lat, 365);

            setCookie('address_lng', address_lng, 365);

           <?php } ?>
            window.location.reload();

        });
    }

    async function getCurrentLocation(type = '') {

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

                                document.getElementById('user_locationnew').value = results[0]
                                    .formatted_address;

                                document.getElementById('user_locationnew_mobile').value =
                                    results[0].formatted_address;

                                address_name = results[0].formatted_address;

                                address_lat = results[0].geometry.location.lat();

                                address_lng = results[0].geometry.location.lng();

                                setCookie('address_name', address_name, 365);

                                setCookie('address_lat', address_lat, 365);

                                setCookie('address_lng', address_lng, 365);

                                if (type == 'reload') {

                                    window.location.reload(true);

                                }

                            }


                        }


                    });

                    try {

                        if (autocomplete) {

                            autocomplete.setBounds(circle.getBounds());

                        }

                    } catch (err) {


                    }


                },
                function() {


                });


        } else {

        }

    }
</script>


<script type="text/javascript">
   <?php
    use App\Models\user;
    use App\Models\VendorUsers;

    $user_email = '';
    $user_uuid = '';
    $auth_id = Auth::id();
    if ($auth_id) {
        $user = user::select('email')->where('id', $auth_id)->first();
        $user_email = $user->email;
        $user_uuid = VendorUsers::select('uuid')->where('email', $user_email)->orderby('id', 'DESC')->first();
        $user_uuid = $user_uuid->uuid;
    }
    ?>
    var database = app1.firestore();

    var googleMapKey = '';
    var googleMapKeySettingHeader = database.collection('settings').doc("googleMapKey");
    googleMapKeySettingHeader.get().then(async function(googleMapKeySnapshotsHeader) {
        var placeholderImageHeaderData = googleMapKeySnapshotsHeader.data();
        placeholderImageHeader = placeholderImageHeaderData.placeHolderImage;
        googleMapKey = placeholderImageHeaderData.key;

    });


    var placeholderImage = '';
    var placeholder = database.collection('settings').doc('placeHolderImage');
    placeholder.get().then(async function(snapshotsimage) {
        var placeholderImageData = snapshotsimage.data();
        placeholderImage = placeholderImageData.image;
    });

    var user_email = "<?php echo $user_email; ?>";
    var user_ref = '';
    if (user_email != '') {
        var user_uuid = "<?php echo $user_uuid; ?>";
        user_ref = database.collection('users').where("id", "==", user_uuid);
    }
    database.collection('settings').doc("notification_setting").get().then(async function(snapshots) {
        var data = snapshots.data();
        if (data != undefined) {
            serviceJson = data.serviceJson;
            if (serviceJson != '' && serviceJson != null) {
                $.ajax({
                    type: 'POST',
                    data: {
                        serviceJson: btoa(serviceJson),
                    },
                    url: "{{ route('store-firebase-service') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {}
                });
            }
        }
    });

    function buildNotificationHtml() {


        var notifications_list = database.collection('notifications').where('userId', '==', user_uuid).orderBy(
            'createdAt', 'desc');
        notifications_list.get().then(async function(snapshots) {
            var html = '';
            if (snapshots.docs.length) {

                var data = [];

                snapshots.docs.forEach(async (listval) => {
                    var listval = listval.data();


                    if (listval.readByUser == undefined) {
                        data.push(listval);
                    }
                });

                if (data.length > 0) {

                    $('.notification_count').html(data.length).removeClass('d-none');
                } else {
                    $('.notification_count').html('').addClass('d-none');
                    html +=
                        '<div class="view-all-button text-center">{{ trans('lang.no_new_notification') }}</div>';
                }

                if (data.length > 0) {


                    html += ' <div class="dropdown-header">\n' +
                        '                        <h6 class="mb-0 fs-12 font-weight-bold"><span id="total-notifications">' +
                        data.length +
                        '</span> <span class="text-primary">{{ trans('lang.new') }}</span> {{ trans('lang.notifications') }}</h6>\n' +
                        '                        <a href="Javascript:void(0)" onclick = "notificationMarkRead()" class="mb-1 badge badge-primary ml-auto pl-3 pr-3 mark-read" id="mark-all">{{ trans('lang.mark_all_read') }}</a>\n' +
                        '                    </div>';
                }
                html += '<ul class="dropdown-user">';
                $.each(data, async function(key, value) {

                    getDriverProfile(value.orderId, value.id);

                    var userStatus = value.title;
                    var defaultImg = "{{ asset('img/notification_user.png') }}";



                    html += '<li>\n' +
                        '                            <div class="dw-user-box">\n' +
                        '                                <div class="u-img"><img class="image_' +
                        value.orderId +
                        '" src="{{ asset('img/notification_user.png') }}" onerror="this.onerror=null;this.src=\'' +
                        defaultImg + '\'" alt="user"\n' +
                        '                                                        style="max-width: 45px;"></div>\n' +
                        '                                <div class="u-text">\n' +
                        '                                    <h4><a class="notification_view_route notification_' +
                        value.id + '" >' + userStatus + '</a></h4>\n';

                    var date = value.createdAt.toDate().toDateString();
                    var time = value.createdAt.toDate().toLocaleTimeString('en-US');

                    if (value.orderId) {
                        html += '<p class="text-muted">{{ trans('lang.order_id') }} : ' + value
                            .orderId + '</p>';

                    }

                    if (data.length > 0) {
                        html += '<p class="text-muted">' + date + "" + time + '</p></div>\n' +
                            '<a href="Javascript:void(0)" onclick = "notificationMarkRead(`' +
                            value.id +
                            '`)" class="mb-1 badge badge-primary ml-auto pl-3 pr-3 mark-read " id="mark-all">{{ trans('lang.mark_as_read') }}</a>' +
                            '                            </div>\n' +
                            ' </li>\n';
                    }



                });
                html += '</ul>';
                if (data.length > 0) {
                    html += '<div class="view-all-button text-center">\n' +
                        '                        <a href="{{ route('notification') }}"\n' +
                        '                           class="fs-12 font-weight-bold">{{ trans('lang.view_all_notifications') }}</a>\n' +
                        '                    </div>';
                }

            } else {

                $('.notification_count').html('').addClass('d-none');
                html +=
                    '<div class="view-all-button text-center">{{ trans('lang.no_new_notification') }}</div>';
            }
            $('.notification_data').html(html);

        });


    }

    function getDriverProfile(orderId, notificationId) {

        database.collection('orders').where('id', '==', orderId).get().then(async function(snapshot) {
            var driverProfile = '';
            if (snapshot.docs.length > 0) {
                var data = snapshot.docs[0].data();
                if (data.hasOwnProperty('driver') && data.driver != null && data.driver != '') {
                    driverProfile = data.driver.profilePictureURL;

                }
                if (data.status == 'InProcess') {
                    var notification_view = "{{ route('pending_order', ':id') }}";
                } else if (data.status === 'InTransit') {
                    var notification_view = "{{ route('intransit_order', ':id') }}";
                } else if (data.status == 'Delivered') {
                    var notification_view = "{{ route('completed_order', ':id') }}";
                }
                notification_view = notification_view.replace(':id', 'id=' + data.id);
                $('.notification_' + notificationId).attr('href', notification_view);
            } else {
                var notification_view = '{{ route('notification') }}';
                $('.notification_' + notificationId).attr('href', notification_view);
            }

            if (driverProfile == '') {
                $('.image_' + orderId).attr('src', "{{ asset('img/notification_user.png') }}")

            } else {
                $('.image_' + orderId).attr('src', driverProfile)

            }
        })

    }

    function notificationMarkRead(notificationId = '') {

        if (notificationId) {


            database.collection('notifications').doc(notificationId).update({
                'readByUser': true,
                'readByUserDate': new Date()
            }).then(function() {
                buildNotificationHtml();
            });

        } else {
            database.collection('notifications').where('userId', '==', user_uuid).get().then(function(querySnapshot) {
                querySnapshot.forEach(function(doc) {
                    doc.ref.update({
                        'readByUser': true,
                        'readByUserDate': new Date()
                    });
                });
                buildNotificationHtml();
            });
        }

    }
   <?php if (Auth::check()) { ?>
    setInterval(buildNotificationHtml, 60000);
   <?php } ?>
    $(document).ready(function() {
       <?php if (Auth::check()) { ?>
        buildNotificationHtml();
       <?php } ?>
        jQuery("#overlay").show();
        changeLanguage();
        if (user_ref != '') {
            user_ref.get().then(async function(profileSnapshots) {
                var profile_user = profileSnapshots.docs[0].data();
                var profile_name = profile_user.name === undefined ? 'Champ' : profile_user.name
                    .split(' ')[0];

                if (profile_user.image != '') {
                    if (profile_user.image) {
                        photo = profile_user.image;
                    } else {
                        photo = placeholderImage;
                    }
                    $("#dropdownMenuButton").append('<img alt="#" src="' + photo +
                        '" onerror="this.onerror=null;this.src=\'' + placeholderImage +
                        '\'" class="img-fluid rounded-circle header-user mr-2 header-user">Hi ' +
                        profile_name);
                } else {
                    $("#dropdownMenuButton").append('<img alt="#" src="' + placeholderImage +
                        '" class="img-fluid rounded-circle header-user mr-2 header-user">Hi ' +
                        profile_name);
                }
                if (profile_user.hasOwnProperty('shippingAddress')) {
                    profile_user.shippingAddress.forEach(element => {

                        if (element.isDefault == true) {
                            $("#user_location").html(element.locality);
                        }
                    });

                }
            })
        }
        jQuery("#overlay").hide();

    });


    $(".user-logout-btn").click(async function() {


        firebase.auth().signOut().then(function() {


            var logoutURL = "{{ route('logout') }}";


            $.ajax({


                type: 'POST',


                url: logoutURL,


                data: {},


                headers: {


                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')


                },


                success: function(data1) {


                    if (data1.logoutuser) {


                        window.location = "{{ route('login') }}";


                    }


                }


            })


        });


    });


   <?php if (@$_GET['update_location'] == 1) { ?>



    var vendorsRef = database.collection('vendors');


    vendorsRef.get().then(async function(vendorsSnapshots) {


        vendorsSnapshots.forEach((doc) => {


            vendorRate = doc.data();


            if (vendorRate.g != undefined) {


                if (vendorRate.g.geopoint._longitude && vendorRate.g.geopoint._latitude) {


                    coordinates = new firebase.firestore.GeoPoint(vendorRate.g.geopoint._latitude,
                        vendorRate.g.geopoint._longitude);


                    try {

                        geoFirestore.collection('vendors').doc(vendorRate.id).update({
                            'coordinates': coordinates
                        }).then(() => {


                            console.log('Provided document has been updated in Firestore');


                        }, (error) => {


                            console.log('Error: ' + error);


                        });

                    } catch (err) {


                    }


                }


            }


        });


    });



   <?php } ?>
</script>


<script type="text/javascript">
    var database = app1.firestore();
    var currentCurrency = "";
    var currencyAtRight = false;
    var decimal_degits = 0;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);

    refCurrency.get().then(async function(snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }
    });
</script>

<?php if (Auth::user()) { ?>

<script type="text/javascript">
    var database = app1.firestore();


    var route1 = '<?php echo route('my_order'); ?>';

    var pageloadded = 0;

    database.collection('orders').where('user.id', "==", cuser_id).onSnapshot(function(doc) {

        if (pageloadded) {

            doc.docChanges().forEach(function(change) {

                var val = change.doc.data();

                if (change.type == "modified") {

                    if (val.status == "Delivered") {
                        $('.order_completed_subject').text('{{ trans('lang.order_delivered') }}');
                        $('#order_completed_msg').text(
                            '{{ trans('lang.order_delivered_successfully') }}');
                        var deliveredRoute = "{{ route('completed_order', ':id') }}";
                        deliveredRoute = deliveredRoute.replace(':id', 'id=' + val.id);
                        $('#notification_oder_compeleted_a').attr('href', deliveredRoute);
                        $("#notification_order_complete_id").trigger("click");
                    } else if (val.status == "InTransit") {
                        var driverName = '';
                        if (val.driver && val.driver.name) {
                            driverName = val.driver.name;
                        }
                        $("#np_accept_name").text('{{ trans('lang.order_pickedup_successfully') }}');
                        $('.driver_accepted_subject').text('{{ trans('lang.order_pickedup') }}');
                        var intransitRoute = "{{ route('intransit_order', ':id') }}";
                        intransitRoute = intransitRoute.replace(':id', 'id=' + val.id);


                        $("#notification_accepted_a").attr("href", intransitRoute);



                        $("#notification_accepted_order").modal('show');

                        $("#notification_accepted_order_id").trigger("click");

                    }

                }


            });

        } else {

            pageloadded = 1;

        }

    });

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



    var email_templates = database.collection('email_templates').where('type', '==', 'new_order_placed');

    var emailTemplatesData = null;

    async function sendMailData(userEmail, userName, orderId, address, paymentMethod, products, couponCode, discount,
        taxSetting, deliveryCharge) {

        await email_templates.get().then(async function(snapshots) {
            emailTemplatesData = snapshots.docs[0].data();

        });

        var formattedDate = new Date();
        var month = formattedDate.getMonth() + 1;
        var day = formattedDate.getDate();
        var year = formattedDate.getFullYear();

        month = month < 10 ? '0' + month : month;
        day = day < 10 ? '0' + day : day;

        formattedDate = day + '-' + month + '-' + year;

        var productDetailsHtml = '';
        var subTotal = 0;

        products.forEach((product) => {


            productDetailsHtml += '<tr>';

            var extra_html = '';
            var price_item = parseFloat(product.price).toFixed(decimal_degits);
            var totalProductPrice = parseFloat(price_item) * parseInt(product.quantity);

            totalProductPrice = parseFloat(totalProductPrice).toFixed(decimal_degits);

            productDetailsHtml += '<td style="width: 20%; border-top: 1px solid rgb(0, 0, 0);">';

            productDetailsHtml += product.name;

            subTotal += parseFloat(totalProductPrice);

            if (currencyAtRight) {
                price_item = parseFloat(price_item).toFixed(decimal_degits) + "" + currentCurrency;
                totalProductPrice = parseFloat(totalProductPrice).toFixed(decimal_degits) + "" +
                    currentCurrency;
            } else {
                price_item = currentCurrency + "" + parseFloat(price_item).toFixed(decimal_degits);
                totalProductPrice = currentCurrency + "" + parseFloat(totalProductPrice).toFixed(
                    decimal_degits);
            }


            productDetailsHtml += '</td>';
            productDetailsHtml += '<td style="width: 20%; border: 1px solid rgb(0, 0, 0);">' + product
                .quantity + '</td><td style="width: 20%; border: 1px solid rgb(0, 0, 0);">' + price_item +
                '</td><td style="width: 20%; border: 1px solid rgb(0, 0, 0);">  ' + totalProductPrice +
                '</td>';

            productDetailsHtml += '</tr>';

        });

        if (discount != '' && discount != null) {
            subTotal = subTotal - parseFloat(discount);
        } else {
            discount = 0;
        }

        var afterDiscountTotal = subTotal;
        var taxDetailsHtml = '';
        var total_tax_amount = 0;
        if (taxSetting.length > 0) {

            for (var i = 0; i < taxSetting.length; i++) {
                var data = taxSetting[i];

                var tax = 0;
                var taxvalue = 0;
                var taxlabel = "";
                var taxlabeltype = "";

                if (data.type && data.tax) {

                    tax = parseFloat(data.tax);
                    taxvalue = data.tax;
                    if (data.type == "percentage") {
                        tax = (parseFloat(data.tax) * afterDiscountTotal) / 100;
                        taxlabeltype = "%";
                    }
                    taxlabel = data.title;
                }
                if (!isNaN(tax) && tax != 0) {
                    total_tax_amount += parseFloat(tax);

                    if (currencyAtRight) {
                        tax = parseFloat(tax).toFixed(decimal_degits) + '' + currentCurrency;
                        if (data.type == "fix") {

                            taxvalue = parseFloat(taxvalue).toFixed(decimal_degits) + '' + currentCurrency;

                        }
                    } else {
                        tax = currentCurrency + parseFloat(tax).toFixed(decimal_degits);
                        if (data.type == "fix") {
                            taxvalue = currentCurrency + parseFloat(taxvalue).toFixed(decimal_degits);

                        }
                    }
                    var html = '';

                    if (taxDetailsHtml != '') {
                        html = '<br>';
                    }

                    taxDetailsHtml += html + '<span style="font-size: 1rem;">' + taxlabel + " (" + taxvalue +
                        taxlabeltype + '):' + tax + '</span>';
                }
            }
        }

        totalAmount = afterDiscountTotal + parseFloat(total_tax_amount);
        if (deliveryCharge != '' && deliveryCharge != null) {
            totalAmount += parseFloat(deliveryCharge);
        } else {
            deliveryCharge = 0;
        }

        var specialdiscountamount = 0;
        var tipAmount = 0;
        if (currencyAtRight) {
            subTotal = parseFloat(subTotal).toFixed(decimal_degits) + "" + currentCurrency;
            discount = parseFloat(discount).toFixed(decimal_degits) + "" + currentCurrency;
            deliveryCharge = parseFloat(deliveryCharge).toFixed(decimal_degits) + "" + currentCurrency;
            totalAmount = parseFloat(totalAmount).toFixed(decimal_degits) + "" + currentCurrency;
            specialdiscountamount = parseFloat(specialdiscountamount).toFixed(decimal_degits) + "" +
                currentCurrency;
            tipAmount = parseFloat(tipAmount).toFixed(decimal_degits) + "" + currentCurrency;

        } else {
            subTotal = currentCurrency + "" + parseFloat(subTotal).toFixed(decimal_degits);
            discount = currentCurrency + "" + parseFloat(discount).toFixed(decimal_degits);
            deliveryCharge = currentCurrency + "" + parseFloat(deliveryCharge).toFixed(decimal_degits);
            totalAmount = currentCurrency + "" + parseFloat(totalAmount).toFixed(decimal_degits);
            specialdiscountamount = currentCurrency + "" + parseFloat(specialdiscountamount).toFixed(
                decimal_degits);
            tipAmount = currentCurrency + "" + parseFloat(tipAmount).toFixed(decimal_degits);

        }

        var productHtml =
            '<table style="width: 100%; border-collapse: collapse; border: 1px solid rgb(0, 0, 0);">\n' +
            '    <thead>\n' +
            '        <tr>\n' +
            '            <th style="text-align: left; border: 1px solid rgb(0, 0, 0);">{{ trans('lang.product_name') }}<br></th>\n' +
            '            <th style="text-align: left; border: 1px solid rgb(0, 0, 0);">{{ trans('lang.quantity_plural') }}<br></th>\n' +
            '            <th style="text-align: left; border: 1px solid rgb(0, 0, 0);">{{ trans('lang.price') }}<br></th>\n' +
            '            <th style="text-align: left; border: 1px solid rgb(0, 0, 0);">{{ trans('lang.total') }}<br></th>\n' +
            '        </tr>\n' +
            '    </thead>\n' +
            '    <tbody id="productDetails">' + productDetailsHtml + '</tbody>\n' +
            '</table>';


        var subject = emailTemplatesData.subject;

        subject = subject.replace(/{orderid}/g, orderId);
        emailTemplatesData.subject = subject;

        var message = emailTemplatesData.message;
        message = message.replace(/{username}/g, userName);
        message = message.replace(/{date}/g, formattedDate);
        message = message.replace(/{orderid}/g, orderId);
        message = message.replace(/{address}/g, address.locality);
        message = message.replace(/{paymentmethod}/g, paymentMethod);
        message = message.replace(/{productdetails}/g, productHtml);
        if (couponCode) {
            message = message.replace(/{coupon}/g, '(' + couponCode + ')');
        } else {
            message = message.replace(/{coupon}/g, "");
        }


        message = message.replace(/{discount}/g, discount);
        message = message.replace(/{specialdiscountamount}/g, specialdiscountamount);
        message = message.replace(/{specialcoupon}/g, "N/A");
        message = message.replace(/{tipamount}/g, tipAmount);
        message = message.replace(/{deliverycharge}/g, deliveryCharge);

        if (taxDetailsHtml != '') {
            message = message.replace(/{taxdetails}/g, taxDetailsHtml);

        } else {
            message = message.replace(/{taxdetails}/g, "");

        }
        message = message.replace(/{shippingcharge}/g, deliveryCharge);
        message = message.replace(/{subtotal}/g, subTotal);
        message = message.replace(/{totalAmount}/g, totalAmount);

        emailTemplatesData.message = message;

        var url = "{{ url('send-email') }}";

        return await sendEmail(url, emailTemplatesData.subject, emailTemplatesData.message, [userEmail]);
    }

    async function sendEmail(url, subject, message, recipients) {
        var checkFlag = false;

        //var encodedText = unescape(encodeURIComponent(message));


        await $.ajax({

            type: 'POST',
            data: {
                subject: subject,
                message: btoa(encodeURIComponent(message)),
                recipients: recipients
            },
            url: url,
            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                checkFlag = true;
            },
            error: function(xhr, status, error) {
                checkFlag = true;
            }
        });

        return checkFlag;

    }
</script>


<?php } ?>

<?php if (isset($_COOKIE['section_color'])) {
    ?>
<style type="text/css">
    a,
    .list-card a:hover,
    a:hover {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .hc-offcanvas-nav h2,
    .hc-offcanvas-nav:not(.touch-device) li:not(.custom-content) a:hover,
    .cat-item a.cat-link:hover {
        background-color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .homebanner-content .ban-btn a,
    .open-ticket-btn a,
    .select-sec-btn a {
        background-color:
           <?php echo $_COOKIE['section_color']; ?>;
        border-color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .homebanner-content .ban-btn a:hover,
    .open-ticket-btn a:hover,
    .select-sec-btn a:hover {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .header-main .takeaway-div input[type="checkbox"]::before {
        background-color:
           <?php echo $_COOKIE['section_color']; ?>;
        opacity: 0.6;
    }

    .header-main .takeaway-div input[type="checkbox"]:checked::before {
        opacity: 1;
    }

    .list-card .member-plan .badge.open,
    .rest-basic-detail .feather_icon .fu-status a.rest-right-btn>span.open,
    .header-main .takeaway-div input[type="checkbox"]:checked::before {
        background-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .offer_coupon_code .offer_code p.badge,
    .offer_coupon_code .offer_price {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .cat-item a.cat-link:hover i.fa {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .rest-basic-detail .feather_icon a.rest-right-btn,
    .rest-basic-detail .feather_icon a.btn {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .rest-basic-detail .feather_icon a.rest-right-btn .feather-star,
    .rest-basic-detail .feather_icon a.btn,
    .rest-basic-detail .feather_icon a.rest-right-btn:hover,
    ul.rating {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .vendor-detail-left h4.h6::after,
    .sidebar-header h3.h6::after {
        background-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .gold-members .add-btn .menu-itembtn a.btn {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .btn-primary,
    .transactions-list .media-body .app-off-btn a {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .btn-primary:hover,
    .btn-primary:not(:disabled):not(.disabled).active,
    .btn-primary:not(:disabled):not(.disabled):active,
    .show>.btn-primary.dropdown-toggle,
    .btn-primary.focus,
    .btn-primary:focus,
    .custom-control-input:checked~.custom-control-label::before,
    .row.fu-loadmore-btn .page-link {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .count-number-box .count-number .count-number-input,
    .count-number .count-number-input,
    .count-number-box .count-number button.count-number-input-cart:hover,
    .count-number button.btn-sm.btn:hover,
    .btn-link {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .transactions-banner {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .transactions-list .media-body .app-off-btn a:hover,
    .rating-stars .feather-star.star_active,
    .rating-stars .feather-star.text-warning {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .search .nav-tabs .nav-item.show .nav-link,
    .search .nav-tabs .nav-link.active {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>!important;
        background-color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .text-primary,
    .card-icon>span {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .checkout-left-box.siddhi-cart-item::after,
    .checkout-left-box.accordion::after,
    .dropdown-item.active,
    .dropdown-item:active,
    .restaurant-detail-left h4.h6::after,
    .sidebar-header h3.h6::after {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .page-link,
    .rest-basic-detail .feather_icon a.rest-right-btn {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .page-link:hover {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .btn-outline-primary {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .btn-outline-primary:hover {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .gendetail-row h3 {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .dyn-menulist button.view_all_menu_btn {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .daytab-cousines ul li>span {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .daytab-cousines ul li>span:hover {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .feather-star.text-warning,
    .list-card .offer_coupon_code .star .badge .feather-star.star_active,
    .list-card-body .offer-btm .star .badge .feather-star.star_active {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    a.restaurant_direction img {
        filter: grayscale(100%);
        -webkit-filter: grayscale(100%);
    }

    .modal-body .recepie-body .custom-control .custom-control-label>span.text-muted {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .payment-table tr th {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .slick-dots li.slick-active button::before {
        color:
           <?php echo $_COOKIE['section_color']; ?>!important;
        background:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .footer-top .title::after,
    .product-list .list-card .list-card-image .discount-price {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .ft-contact-box .ft-icon {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .head-search .dropdown {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .list-card .list-card-body .offer-code a {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .vandor-sidebar .vandorcat-list li a:hover,
    .vandor-sidebar .vandorcat-list li.active a {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .list-card .list-card-body p.text-gray span.fa.fa-map-marker,
    .car-det-head .car-det-price span.price {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .product-detail-page .addons-option .custom-control .custom-control-label.active::before {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .product-detail-page .addtocart .add-to-cart.btn.btn-primary.booknow {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .product-detail-page .addtocart .add-to-cart.btn.btn-primary {
        border: 1px solid<?php echo $_COOKIE['section_color']; ?>;
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .btn-primary,
    .ecommerce-content .title .see-all a,
    .see-all a {
        background:
           <?php echo $_COOKIE['section_color']; ?>!important;
    }

    .vandor-sidebar .vandorcat-list li a:hover,
    .vandor-sidebar .vandorcat-list li.active a {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .swal2-actions .swal2-confirm.swal2-styled {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .popular-section .nav-pills .nav-link:hover,
    .popular-section .nav-pills .nav-link.active {
        border-color:
           <?php echo $_COOKIE['section_color']; ?>;
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .list-card .car-det-price h6 {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .header-right ul.dropdown-user li .dw-user-box a.mark-read,
    .header-right .notification_data .dropdown-header a.mark-read {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
        border: 1px solid<?php echo $_COOKIE['section_color']; ?>;
    }

    .header-right .notification_data .dropdown-header h6 span.text-primary {
        color:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    .header-right #dropdownNotificationMenuButton .notification_count {
        background:
           <?php echo $_COOKIE['section_color']; ?>;
    }

    @media (max-width: 991px) {

        .bg-primary {
            background:
               <?php echo $_COOKIE['section_color']; ?>!important;
        }

    }
</style>
<?php } ?>
