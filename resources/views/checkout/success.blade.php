@include('layouts.app')


@include('layouts.header')

@php
$cityToCountry = file_get_contents(asset('tz-cities-to-countries.json'));
$cityToCountry = json_decode($cityToCountry, true);
$countriesJs = array();
foreach ($cityToCountry as $key => $value) {
    $countriesJs[$key] = $value;
}
@endphp
<div class="siddhi-checkout">


    <div class="container position-relative">

        <div class="py-5 row">

            <div class="col-md-12 mb-3">

                <div>


                    <div class="siddhi-cart-item mb-3 rounded shadow-sm bg-white overflow-hidden">

                        <div class="siddhi-cart-item-profile bg-white p-3">

                            <div class="card card-default">


                               <?php $authorName = @$cart['cart_order']['authorName']; ?>

                                @if($message = Session::get('success'))

                                                                <div class="py-5 linus-coming-soon d-flex justify-content-center align-items-center">

                                                                    <div class="col-md-6">

                                                                        <div class="text-center pb-3">

                                                                            <h1 class="font-weight-bold"><?php    if (@$authorName) {
        echo @$authorName . ",";
    } ?>{{trans('lang.your_order_has_been_successful')}}</h1>

                                                                            <p>Check your order status in <a href="{{route('my_order')}}"
                                                                                    class="font-weight-bold text-decoration-none text-primary">My
                                                                                    Orders</a> about next steps information.</p>

                                                                        </div>


                                                                        <div class="bg-white rounded text-center p-4 shadow-sm">

                                                                            <h1 class="display-1 mb-4">🎉</h1>

                                                                            <h6 class="font-weight-bold mb-2">{{trans('lang.preparing_your_order')}}
                                                                            </h6>

                                                                            <p class="small text-muted">
                                                                                {{trans('lang.your_order_will_be_prepared_and_will_come_soon')}}
                                                                            </p>

                                                                            <a href="{{route('my_order')}}"
                                                                                class="btn rounded btn-primary btn-lg btn-block">{{trans('lang.view_order')}}</a>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                @endif

                            </div>

                        </div>

                    </div>


                </div>

            </div>

        </div>


    </div>

</div>
<div id="data-table_processing_order" class="dataTables_processing panel panel-default" style="display: none;">{{trans('lang.Processing')}}</div>
@include('layouts.footer')


@include('layouts.nav')



@if($message = Session::get('success'))

    <script src="https://unpkg.com/geofirestore/dist/geofirestore.js"></script>

    <script type="text/javascript">

        cityToCountry = '<?php    echo json_encode($countriesJs);?>';
        cityToCountry = JSON.parse(cityToCountry);
        var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        userCity = userTimeZone.split('/')[1];
        userCountry = cityToCountry[userCity];

        var driver = null;
        var driverFcmToken='';
        var fcmToken = '';

        var id_order = "<?php    echo uniqid();?>";

        var userId = "<?php    echo $id; ?>";

        var userDetailsRef = database.collection('users').where('id', "==", userId);

        var vendorDetailsRef = database.collection('vendors');
        var vendorDetails = '';
        vendorDetailsRef.get().then(async function (uservendorSnapshots) {
            if (uservendorSnapshots.docs.length) {
                vendorDetails = uservendorSnapshots.docs[0].data();

            }
        });
        var uservendorDetailsRef = database.collection('users');

        var AdminCommission = database.collection('settings').doc('AdminCommission');

        var razorpaySettings = database.collection('settings').doc('razorpaySettings');

        taxSetting = [];

        var reftaxSetting = database.collection('tax').where('country', '==', userCountry).where('enable', '==', true);
        reftaxSetting.get().then(async function (snapshots) {
            if (snapshots.docs.length > 0) {
                snapshots.docs.forEach((val) => {
                    val = val.data();
                    var obj = '';
                    obj = {
                        'country': val.country,
                        'enable': val.enable,
                        'id': val.id,
                        'tax': val.tax,
                        'title': val.title,
                        'type': val.type,
                    }
                    taxSetting.push(obj);

                })
            }
        });

       <?php    if (@$cart['payment_status'] == true && !empty(@$cart['cart_order']['order_json'])) { ?>

        $("#data-table_processing_order").show();

        var order_json = '<?php        echo json_encode($cart['cart_order']['order_json']); ?>';

        order_json = JSON.parse(order_json);

        finalCheckout();
        $("#data-table_processing_order").hide();
        async function getDriverInfo(pincode) {
            var driver = null;

            await database.collection('users').where('role', '==', 'driver').where('pinCode', '==', pincode).get().then(async function (snapshot) {
                if (snapshot.docs.length > 0) {
                    driver = snapshot.docs[0].data();
                    driverFcmToken=driver.fcmToken;
                }
            })

            return driver;
        }

        function finalCheckout() {
            $("#data-table_processing_order").show();

            userDetailsRef.get().then(async function (userSnapshots) {

                var userDetails = userSnapshots.docs[0].data();

                payment_method = '<?php        echo $payment_method; ?>';


                var vendorUser = await getVendorUser(vendorDetails.author);

                var createdAt = firebase.firestore.FieldValue.serverTimestamp();

                for (var n = 0; n < order_json.products.length; n++) {
                    if (order_json.products[n].photo == null) {
                        order_json.products[n].photo = "";
                    }
                    if (order_json.products[n].hsn_code == null) {
                        order_json.products[n].hsn_code = "";
                    }

                    order_json.products[n].quantity = parseInt(order_json.products[n].quantity);
                }
                var discount = 0;
                var couponCode = '';
                var description = null;
                var discountType = '';
                var couponId = '';
                var isEnabled = true;

                if (order_json.discount && order_json.discount != '' && order_json.discount != null && !isNaN(order_json.discount)) {
                    discount = order_json.discount;
                }
                if (order_json.couponCode) {
                    couponCode = order_json.couponCode;
                }
                if (order_json.discountType) {
                    discountType = order_json.discountType;
                }
                if (order_json.couponId) {
                    couponId = order_json.couponId;
                }
                var couponDetails = {
                    code: (couponCode=='') ? null : couponCode ,
                    description: description,
                    discount: (discount=='') ? null : discount.toString(),
                    discountType: (discountType=='') ? null : discountType,
                    id: (couponId=='') ? null :couponId,
                    isEnabled: (couponCode=='') ? null : isEnabled
                }
                var address = {
                    'address': null,
                    'addressAs': null,
                    'id': null,
                    'isDefault': null,
                    'landmark': null,
                    'locality': getCookie('address_name'),
                    'location': location
                };
                if (order_json.address) {
                    var location = {
                        'latitude': parseFloat(order_json.address.location.latitude),
                        'longitude': parseFloat(order_json.address.location.longitude)

                    };

                    address = {
                        'address': order_json.address.address,
                        'addressAs': order_json.address.addressAs,
                        'id': order_json.address.id,
                        'isDefault': (order_json.address.isDefault == "true" || order_json.address.isDefault == true) ? true : false,
                        'landmark': order_json.address.landmark,
                        'locality': order_json.address.locality,
                        'location': location,
                        'pinCode': order_json.address.pinCode
                    };
                    driver=await getDriverInfo(order_json.address.pinCode);
                }


                database.collection('orders').doc(id_order).set({
                    'coupon': couponDetails,
                    'createdAt': firebase.firestore.FieldValue.serverTimestamp(),
                    'deliveryCharge': order_json.deliveryCharge,
                    'driverID': (driver != null && driver != '') ? driver.id : null,
                    'estimatedTimeToPrepare': order_json.estimatedTimeToPrepare,
                    'id': id_order,
                    'otp': order_json.otp,
                    'paymentMethod': payment_method,
                    'products': order_json.products,
                    'status': order_json.status,
                    'tax': taxSetting,
                    'user': userDetails,
                    'userID': order_json.userID,
                    'vendor': vendorDetails,
                    'address': address,
                    'driver': driver

                }).then(async function (result) {
                    $.ajax({

                        type: 'POST',

                        url: "<?php        echo route('order-complete'); ?>",

                        data: {
                            _token: '<?php        echo csrf_token() ?>',
                            'fcm': driverFcmToken,
                            'authorName': userDetails.name,
                            'subject': '{{trans("lang.order_placed")}}',
                            'message': userDetails.name + ' {{trans("lang.has_placed_order")}}'
                        },

                        success: async function (data) {
                            if(driver!=null && driver!=''){
                                await addNotification(driver, id_order, userDetails.name);

                            }
                            if (userDetails.email != '' && userDetails.email != null) {
                                var emailUserData = await sendMailData(userDetails.email, userDetails.name, id_order, order_json.address, payment_method, order_json.products, order_json.couponCode, order_json.discountAmount, taxSetting, order_json.deliveryCharge);
                            }
                            if (vendorUser && vendorUser != undefined) {
                                var emailVendorData = await sendMailData(vendorUser.email, vendorUser.name, id_order, order_json.address, payment_method, order_json.products, order_json.couponCode, order_json.discountAmount, taxSetting, order_json.deliveryCharge);

                            }

                            $("#data-table_processing_order").hide();
                        }
                    });
                });

            });

        }

        async function getVendorUser(vendorUserId) {

            var vendorUSerData = '';

            await database.collection('users').where('id', "==", vendorUserId).get().then(async function (uservendorSnapshots) {
                if (uservendorSnapshots.docs.length) {
                    vendorUSerData = uservendorSnapshots.docs[0].data();

                }
            });

            return vendorUSerData;

        }
         async function addNotification(driver, orderId, authorName) {
                var notifyId = database.collection("tmp").doc().id;
                database.collection('notifications').doc(notifyId).set({
                    'body': authorName + ' has place order',
                    'createdAt': firebase.firestore.FieldValue.serverTimestamp(),
                    'id': notifyId,
                    'notificationType': 'order',
                    'orderId': orderId,
                    'role': 'driver',
                    'title': 'Order Placed',
                    'userId': driver.id,
                    'status':'InProcess'

                })
            }

       <?php    } ?>

    </script>

@endif
