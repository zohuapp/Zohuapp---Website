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

            <div class="col-md-8 mb-3 checkout-left">

                <div class="checkout-left-inner">
                    <div class="siddhi-cart-item mb-4 rounded shadow-sm bg-white checkout-left-box border">

                        <div class="siddhi-cart-item-profile p-3">

                            <div class="d-flex flex-column">

                                <div class="chec-out-header d-flex mb-3">
                                    <div class="chec-out-title">
                                        <h6 class="mb-0 font-weight-bold pb-1">{{trans('lang.delivery_address')}}</h6>
                                        <span>{{trans(('lang.save_address_location'))}}</span>
                                    </div>
                                    <a href="{{route('delivery-address.index')}}"
                                        class="ml-auto font-weight-bold">{{trans('lang.change')}}</a>
                                </div>
                                <div class="row">

                                    <div class="custom-control col-lg-12 mb-3 position-relative" id="address_box">

                                        <div class="addres-innerbox">

                                            <div class="p-3 w-100">

                                                <div class="d-flex align-items-center mb-2">

                                                    <h6 class="mb-0 pb-1">{{trans('lang.address')}}</h6>

                                                </div>

                                                <p class="text-dark m-0" id="line_1"></p>
                                                <p class="text-dark m-0" id="line_2"></p>
                                                <input type="text" id="addressId" hidden>
                                            </div>


                                        </div>


                                    </div>

                                </div>

                                <a id="add_address" class="btn btn-primary" href="#" data-toggle="modal"
                                    data-target="#locationModalAddress" style="display: none;">
                                    {{trans('lang.add_new_address')}} </a>

                            </div>

                        </div>

                    </div>

                    <div class="accordion mb-3 rounded shadow-sm bg-white checkout-left-box border"
                        id="accordionExample">

                        <div class="siddhi-card border-bottom overflow-hidden">

                            <div class="siddhi-card-header" id="headingTwo">

                                <h2 class="mb-0">

                                    <button class="d-flex p-3 align-items-center btn btn-link w-100" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">

                                        <i class="feather-globe mr-3"></i>{{trans('lang.net_banking')}}

                                        <i class="feather-chevron-down ml-auto d-none"></i>

                                    </button>

                                </h2>

                            </div>

                        </div>


                        <div class="siddhi-card overflow-hidden checkout-payment-options">

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="razorpay_box">

                                <input type="radio" name="payment_method" id="razorpay" value="RazorPay"
                                    class="custom-control-input" checked>

                                <label class="custom-control-label" for="razorpay">{{trans('lang.razorpay')}}</label>

                                <input type="hidden" id="isEnabled">

                                <input type="hidden" id="isSandboxEnabled">

                                <input type="hidden" id="razorpayKey">

                                <input type="hidden" id="razorpaySecret">

                            </div>


                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="stripe_box">

                                <input type="radio" name="payment_method" id="stripe" value="Stripe"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="stripe">{{trans('lang.stripe')}}</label>


                                <input type="hidden" id="isStripeSandboxEnabled">

                                <input type="hidden" id="stripeKey">

                                <input type="hidden" id="stripeSecret">

                            </div>


                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="paypal_box">

                                <input type="radio" name="payment_method" id="paypal" value="PayPal"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="paypal">{{trans('lang.pay_pal')}}</label>


                                <input type="hidden" id="ispaypalSandboxEnabled">

                                <input type="hidden" id="paypalKey">

                                <input type="hidden" id="paypalSecret">

                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="payfast_box">

                                <input type="radio" name="payment_method" id="payfast" value="PayFast"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="payfast">{{trans('lang.pay_fast')}}</label>

                                <input type="hidden" id="payfast_isEnabled">

                                <input type="hidden" id="payfast_isSandbox">

                                <input type="hidden" id="payfast_merchant_key">

                                <input type="hidden" id="payfast_merchant_id">

                                <input type="hidden" id="payfast_notify_url">

                                <input type="hidden" id="payfast_return_url">

                                <input type="hidden" id="payfast_cancel_url">


                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="paystack_box">

                                <input type="radio" name="payment_method" id="paystack" value="PayStack"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="paystack">{{trans('lang.pay_stack')}}</label>

                                <input type="hidden" id="paystack_isEnabled">

                                <input type="hidden" id="paystack_isSandbox">

                                <input type="hidden" id="paystack_public_key">

                                <input type="hidden" id="paystack_secret_key">

                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="flutterWave_box">

                                <input type="radio" name="payment_method" id="flutterwave" value="FlutterWave"
                                    class="custom-control-input">

                                <label class="custom-control-label"
                                    for="flutterwave">{{trans('lang.flutter_wave')}}</label>

                                <input type="hidden" id="flutterWave_isEnabled">

                                <input type="hidden" id="flutterWave_isSandbox">

                                <input type="hidden" id="flutterWave_encryption_key">

                                <input type="hidden" id="flutterWave_public_key">

                                <input type="hidden" id="flutterWave_secret_key">

                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="mercadopago_box">

                                <input type="radio" name="payment_method" id="mercadopago" value="MercadoPago"
                                    class="custom-control-input">

                                <label class="custom-control-label"
                                    for="mercadopago">{{trans('lang.mercadopago')}}</label>

                                <input type="hidden" id="mercadopago_isEnabled">

                                <input type="hidden" id="mercadopago_isSandbox">

                                <input type="hidden" id="mercadopago_public_key">

                                <input type="hidden" id="mercadopago_access_token">

                                <input type="hidden" id="title">

                                <input type="hidden" id="quantity">

                                <input type="hidden" id="unit_price">
                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;" id="xendit_box">

                                <input type="radio" name="payment_method" id="xendit" value="xendit"
                                    class="custom-control-input">

                                <label class="custom-control-label"
                                    for="xendit">{{trans('lang.xendit')}}</label>

                                <input type="hidden" id="xendit_enable">
                                <input type="hidden" id="xendit_apiKey">
                                <input type="hidden" id="xendit_image">
                                <input type="hidden" id="xendit_isSandbox">
                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;" id="midtrans_box">

                                <input type="radio" name="payment_method" id="midtrans" value="midtrans"
                                    class="custom-control-input">

                                <label class="custom-control-label"
                                    for="midtrans">{{trans('lang.midtrans')}}</label>

                                <input type="hidden" id="midtrans_enable">
                                <input type="hidden" id="midtrans_serverKey">
                                <input type="hidden" id="midtrans_image">
                                <input type="hidden" id="midtrans_isSandbox">
                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;" id="orangepay_box">

                                <input type="radio" name="payment_method" id="orangepay" value="orangepay"
                                    class="custom-control-input">

                                <label class="custom-control-label"
                                    for="orangepay">{{trans('lang.orangepay')}}</label>

                                <input type="hidden" id="orangepay_auth">
                                <input type="hidden" id="orangepay_clientId">
                                <input type="hidden" id="orangepay_clientSecret">
                                <input type="hidden" id="orangepay_image">
                                <input type="hidden" id="orangepay_isSandbox">
                                <input type="hidden" id="orangepay_merchantKey">
                                <input type="hidden" id="orangepay_cancelUrl">
                                <input type="hidden" id="orangepay_notifyUrl">
                                <input type="hidden" id="orangepay_returnUrl">
                                <input type="hidden" id="orangepay_enable">
                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="cod_box">

                                <input type="radio" name="payment_method" id="cod" value="Cash On Delivery"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="cod">{{trans('lang.cash_on_delivery')}}</label>

                            </div>
                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="wallet_box">

                                <input type="radio" name="payment_method" id="wallet" value="Wallet"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="wallet">Wallet ( You have <span
                                        id="wallet_amount"></span> )</label>

                                <input type="hidden" id="user_wallet_amount">

                            </div>



                        </div>


                    </div>
                    <div class="add-note" id="coupon-div">
                        <h3>{{trans('lang.available_coupon')}}</h3>
                        <div class="foodies-detail-coupon">
                            <div id="coupon_list"></div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="siddhi-cart-item rounded rounded shadow-sm overflow-hidden bg-white sticky_sidebar"
                    id="cart_list">

                    @include('store.cart_item')


                </div>

            </div>

        </div>

    </div>

</div>

</div>

@include('layouts.footer')

@include('layouts.nav')

<script src="https://unpkg.com/geofirestore/dist/geofirestore.js"></script>

<script type="text/javascript">


    var cityToCountry = '<?php echo json_encode($countriesJs);?>';
    var decimal_degits = 0;
    cityToCountry = JSON.parse(cityToCountry);
    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    userCity = userTimeZone.split('/')[1];
    userCountry = cityToCountry[userCity];
    var minimumOrderValue = 0;
    var wallet_amount = 0;
    var driverFcmToken = '';
    var id_order = "<?php echo uniqid();?>";

    var userId = "<?php echo $id; ?>";
    database.collection('settings').doc('globalSettings').get().then(async function (snapshots) {
        var data = snapshots.data();
        minimumOrderValue = parseFloat(data.min_order_amount);
    })
    var userDetailsRef = database.collection('users').where('id', "==", userId);

    var vendorDetailsRef = database.collection('vendors');
    var vendorDetails = '';
    vendorDetailsRef.get().then(async function (uservendorSnapshots) {
        if (uservendorSnapshots.docs.length) {
            vendorDetails = uservendorSnapshots.docs[0].data();

        }
    });

    var PaymentSettings = database.collection('settings').doc('payment');;

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

    var currentCurrency = '';
    var currencyAtRight = false;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    var currencyData = '';
    refCurrency.get().then(async function (snapshots) {
        currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        decimal_digit = currencyData.decimal_degits;
        currencyAtRight = currencyData.symbolAtRight;
        loadcurrencynew();
    });

    function loadcurrencynew() {
        if (currencyAtRight) {
            jQuery('.currency-symbol-left').hide();
            jQuery('.currency-symbol-right').show();
            jQuery('.currency-symbol-right').text(currentCurrency);
        } else {
            jQuery('.currency-symbol-left').show();
            jQuery('.currency-symbol-right').hide();
            jQuery('.currency-symbol-left').text(currentCurrency);
        }
    }

    var orderPlacedSubject = '';
    var orderPlacedMsg = '';

    database.collection('dynamic_notification').get().then(async function (snapshot) {
        if (snapshot.docs.length > 0) {
            snapshot.docs.map(async (listval) => {
                val = listval.data();
                if (val.type == "order_placed") {
                    orderPlacedSubject = val.subject;
                    orderPlacedMsg = val.message;

                }
            })
        }
    })

    var newdate = new Date();
    var refCoupons = database.collection('coupons').where('isEnabled', '==', true).where("expiresAt", ">", newdate).orderBy("expiresAt").startAt(new Date());

    refCoupons.get().then(async function (snapshot) {
        var couponHtml = '';
        couponHtml += '<div class="copupon-list">';
        couponHtml += '<ul>';
        snapshot.docs.forEach((listval) => {
            var date = '';
            var time = '';

            var coupon = listval.data();
            if (coupon.expiresAt) {
                var date1 = coupon.expiresAt.toDate().toDateString();
                var date = new Date(date1);
                var dd = String(date.getDate()).padStart(2, '0');
                var mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = date.getFullYear();
                var expiresDate = yyyy + '-' + mm + '-' + dd;
            }
            if (coupon.discountType == 'Percentage') {
                var discount = coupon.discount + '%'
            } else {
                coupon.discount = parseFloat(coupon.discount);
                if (currencyAtRight) {
                    var discount = coupon.discount.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    var discount = currentCurrency + "" + coupon.discount.toFixed(decimal_degits);
                }
            }
            if (coupon.isEnabled == true) {
                couponHtml += '<li class="coupon_code_list" data-code="' + coupon.code + '" value="' + coupon.code + '"><span class="per-off">' + discount + ' OFF </span><span>' + coupon.code + ' | Valid till ' + expiresDate + '</span></li>';
            }
        })
        couponHtml += '</ul></div>';

        if (snapshot.docs.length > 0) {
            $('#coupon_list').html(couponHtml);
        } else {
            $('#coupon-div').remove();
        }

    })
    var vendorRadius = '';
    var vendorRadiusRef = database.collection('settings').doc("globalSettings");

    $(document).ready(async function () {
        await vendorRadiusRef.get().then(async function (snapshot) {
            var data = snapshot.data();
            if (data.hasOwnProperty('vendorRadius') && data.vendorRadius != null && data.vendorRadius != '') {
                vendorRadius = data.vendorRadius;
            }
        });
        getUserDetails();


        $(document).on("click", '.coupon_code_list', function (event) {
            var code = $(this).attr('data-code');
            $("#coupon_code").val(code);
        });
        $(document).on("click", '.remove_item', function (event) {

            var id = $(this).attr('data-id');
            $.ajax({

                type: 'POST',

                url: "<?php echo route('remove-from-cart'); ?>",

                data: { _token: '<?php echo csrf_token() ?>', id: id, is_checkout: 1 },

                success: function (data) {

                    data = JSON.parse(data);

                    $('#cart_list').html(data.html);
                    loadcurrencynew();

                }

            });
        });


        $(document).on("click", '.count-number-input-cart', function (event) {
            var id = $(this).attr('data-id');

            var quantity = $('.count_number_' + id).val();
            var stock_quantity = $(this).attr('data-vqty');

            if (stock_quantity != undefined && stock_quantity != -1) {

                if (parseInt(quantity) > parseInt(stock_quantity)) {

                    $('.count_number_' + id).val(quantity - 1);
                    Swal.fire({ text: "{{trans('lang.invalid_stock_qty')}}", icon: "error" });
                    return false;

                }
            }

            $.ajax({

                type: 'POST',

                url: "<?php echo route('change-quantity-cart'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    id: id,
                    quantity: quantity,
                    is_checkout: 1
                },

                success: function (data) {

                    data = JSON.parse(data);
                    $('#cart_list').html(data.html);
                    loadcurrencynew();

                }

            });

        });


        $(document).on("click", '#apply-coupon-code', function (event) {

            var coupon_code = $("#coupon_code").val();
            if (coupon_code != '') {
                var couponCodeRef = database.collection('coupons').where('code', "==", coupon_code).where('isEnabled', '==', true).where('expiresAt', '>=', new Date());

                couponCodeRef.get().then(async function (couponSnapshots) {


                    if (couponSnapshots.docs.length) {

                        var coupondata = couponSnapshots.docs[0].data();

                        discount = coupondata.discount;

                        discountType = coupondata.discountType;

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('apply-coupon'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                coupon_code: coupon_code,
                                discount: discount,
                                discountType: discountType,
                                is_checkout: 1,
                                coupon_id: coupondata.id
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                            }

                        });

                    } else {
                        Swal.fire({ text: "{{trans('lang.invalid_coupon_code')}}", icon: "error" });
                        $("#coupon_code").val('');
                    }
                });
            } else {
                $.ajax({

                    type: 'POST',

                    url: "<?php echo route('apply-coupon'); ?>",

                    data: {
                        _token: '<?php echo csrf_token() ?>',
                        coupon_code: '',
                        discount: '',
                        discountType: '',
                        is_checkout: 1,
                        coupon_id: ''
                    },

                    success: function (data) {

                        data = JSON.parse(data);

                        $('#cart_list').html(data.html);
                        loadcurrencynew();

                    }

                });

            }

        });


    });


    async function getUserDetails() {
        PaymentSettings.get().then(async function (paySettingsSnapshots) {

            codSetting = paySettingsSnapshots.data().cash;
            if (codSetting.enable) {
                $("#cod_box").show();
            } else {
                $("#cod_box").remove();
            }
        });
        PaymentSettings.get().then(async function (razorpaySettingsSnapshots) {

            razorpaySetting = razorpaySettingsSnapshots.data().razorpay;

            if (razorpaySetting.enable) {

                var isEnabled = razorpaySetting.enable;

                $("#isEnabled").val(isEnabled);

                var isSandboxEnabled = razorpaySetting.isSandbox;

                $("#isSandboxEnabled").val(isSandboxEnabled);

                var razorpayKey = razorpaySetting.razorpayKey;

                $("#razorpayKey").val(razorpayKey);

                var razorpaySecret = razorpaySetting.razorpaySecret;

                $("#razorpaySecret").val(razorpaySecret);

                $("#razorpay_box").show();


            }

        });


        PaymentSettings.get().then(async function (stripeSettingsSnapshots) {

            stripeSetting = stripeSettingsSnapshots.data().strip;

            if (stripeSetting.enable) {

                var isEnabled = stripeSetting.enable;

                var isSandboxEnabled = stripeSetting.isSandbox;

                $("#isStripeSandboxEnabled").val(isSandboxEnabled);

                var stripeKey = stripeSetting.clientpublishableKey;

                $("#stripeKey").val(stripeKey);

                var stripeSecret = stripeSetting.stripeSecret;

                $("#stripeSecret").val(stripeSecret);

                $("#stripe_box").show();


            }

        });


        PaymentSettings.get().then(async function (paypalSettingsSnapshots) {

            paypalSetting = paypalSettingsSnapshots.data().paypal;
            if (paypalSetting.enable) {

                var isEnabled = paypalSetting.enable;

                var isSandboxEnabled = paypalSetting.isSandbox;

                $("#ispaypalSandboxEnabled").val(isSandboxEnabled);

                var paypalAppId = paypalSetting.paypalClient;

                $("#paypalKey").val(paypalAppId);

                var paypalSecret = paypalSetting.paypalSecret;

                $("#paypalSecret").val(paypalSecret);

                $("#paypal_box").show();


            }

        });


        PaymentSettings.get().then(async function (walletSettingsSnapshots) {

            walletSetting = walletSettingsSnapshots.data().wallet;

            if (walletSetting.enable) {

                var isEnabled = walletSetting.enable;

                if (isEnabled) {
                    $("#walletenabled").val(true);
                } else {
                    $("#walletenabled").val(false);
                }
                $("#wallet_box").show();

            }

        });


        PaymentSettings.get().then(async function (payfastSettingsSnapshots) {

            payFastSetting = payfastSettingsSnapshots.data().payfast;

            if (payFastSetting.enable) {

                var isEnable = payFastSetting.enable;

                $("#payfast_isEnabled").val(isEnable);

                var isSandboxEnabled = payFastSetting.isSandbox;

                $("#payfast_isSandbox").val(isSandboxEnabled);

                var merchant_id = payFastSetting.merchantId;

                $("#payfast_merchant_id").val(merchant_id);

                var merchant_key = payFastSetting.merchantKey;

                $("#payfast_merchant_key").val(merchant_key);

                var return_url = payFastSetting.return_url;

                $("#payfast_return_url").val(return_url);

                var cancel_url = payFastSetting.cancel_url;

                $("#payfast_cancel_url").val(cancel_url);

                var notify_url = payFastSetting.notify_url;

                $("#payfast_notify_url").val(notify_url);

                $("#payfast_box").show();

            }

        });

        PaymentSettings.get().then(async function (payStackSettingsSnapshots) {

            payStackSetting = payStackSettingsSnapshots.data().payStack;

            if (payStackSetting.enable) {

                var isEnable = payStackSetting.enable;

                $("#paystack_isEnabled").val(isEnable);

                var isSandboxEnabled = payStackSetting.isSandbox;

                $("#paystack_isSandbox").val(isSandboxEnabled);

                var publicKey = payStackSetting.publicKey;

                $("#paystack_public_key").val(publicKey);

                var secretKey = payStackSetting.secretKey;

                $("#paystack_secret_key").val(secretKey);

                $("#paystack_box").show();

            }

        });

        PaymentSettings.get().then(async function (flutterWaveSettingsSnapshots) {

            flutterWaveSetting = flutterWaveSettingsSnapshots.data().flutterWave;

            if (flutterWaveSetting.enable) {

                var isEnable = flutterWaveSetting.enable;

                $("#flutterWave_isEnabled").val(isEnable);

                var isSandboxEnabled = flutterWaveSetting.isSandbox;

                $("#flutterWave_isSandbox").val(isSandboxEnabled);

                var encryptionKey = flutterWaveSetting.encryptionKey;

                $("#flutterWave_encryption_key").val(encryptionKey);

                var secretKey = flutterWaveSetting.secretKey;

                $("#flutterWave_secret_key").val(secretKey);

                var publicKey = flutterWaveSetting.publicKey;

                $("#flutterWave_public_key").val(publicKey);

                $("#flutterWave_box").show();

            }

        });

        PaymentSettings.get().then(async function (XenditSettingsSnapshots) {
            XenditSetting = XenditSettingsSnapshots.data().xendit;
            if (XenditSetting.enable) {

                var enable = XenditSetting.enable;

                $("#xendit_enable").val(enable);

                var apiKey = XenditSetting.apiKey;

                $("#xendit_apiKey").val(apiKey);

                var image = XenditSetting.image;

                $("#xendit_image").val(image);

                var isSandbox = XenditSetting.isSandbox;

                $("#xendit_isSandbox").val(isSandbox);

                $("#xendit_box").show();

            }
        });

        PaymentSettings.get().then(async function (Midtrans_settingsSnapshots) {
            Midtrans_setting = Midtrans_settingsSnapshots.data().midtrans;
            if (Midtrans_setting.enable) {

                var enable = Midtrans_setting.enable;

                $("#midtrans_enable").val(enable);

                var serverKey = Midtrans_setting.serverKey;

                $("#midtrans_serverKey").val(serverKey);

                var image = Midtrans_setting.image;

                $("#midtrans_image").val(image);

                var isSandbox = Midtrans_setting.isSandbox;

                $("#midtrans_isSandbox").val(isSandbox);

                $("#midtrans_box").show();

            }
        });

        PaymentSettings.get().then(async function (OrangePaySettingsSnapshots) {
            OrangePaySetting = OrangePaySettingsSnapshots.data().orangePay;
            if (OrangePaySetting.enable) {
                $("#orangepay_enable").val(OrangePaySetting.enable);
                $("#orangepay_auth").val(OrangePaySetting.auth);
                $("#orangepay_image").val(OrangePaySetting.image);
                $("#orangepay_isSandbox").val(OrangePaySetting.isSandbox);
                $("#orangepay_clientId").val(OrangePaySetting.clientId);
                $("#orangepay_clientSecret").val(OrangePaySetting.clientSecret);
                $("#orangepay_merchantKey").val(OrangePaySetting.merchantKey);
                $("#orangepay_notifyUrl").val(OrangePaySetting.notifyUrl);
                $("#orangepay_returnUrl").val(OrangePaySetting.returnUrl);
                $("#orangepay_cancelUrl").val(OrangePaySetting.cancelUrl);
                $("#orangepay_box").show();
            }
        });

        PaymentSettings.get().then(async function (MercadoPagoSettingsSnapshots) {

            MercadoPagoSetting = MercadoPagoSettingsSnapshots.data().mercadoPago;

            if (MercadoPagoSetting.enable) {

                var isEnable = MercadoPagoSetting.enable;

                $("#mercadopago_isEnabled").val(isEnable);

                var isSandboxEnabled = MercadoPagoSetting.isSandbox;

                $("#mercadopago_isSandbox").val(isSandboxEnabled);

                var PublicKey = MercadoPagoSetting.publicKey;

                $("#mercadopago_public_key").val(PublicKey);

                var AccessToken = MercadoPagoSetting.accessToken;

                $("#mercadopago_access_token").val(AccessToken);

                $("#mercadopago_box").show();

            }

        });

        userDetailsRef.get().then(async function (userSnapshots) {
            var userDetails = userSnapshots.docs[0].data();
            var sessionAdrsId = sessionStorage.getItem('addressId');
            var full_address = '';
            if (userDetails.hasOwnProperty('shippingAddress') && Array.isArray(userDetails.shippingAddress)) {
                shippingAddress = userDetails.shippingAddress;
                var isShipping = false;

                shippingAddress.forEach((listval) => {
                    if (sessionAdrsId != '' && sessionAdrsId != null) {

                        if (listval.id == sessionAdrsId) {

                            $("#line_1").html(listval.address);
                            $('#line_2').html(listval.locality);
                            $('#addressId').val(listval.id);
                            $("#address_box").show();
                            isShipping = true;
                        }
                    } else {
                        if (listval.isDefault == true) {

                            $("#line_1").html(listval.address);

                            $('#line_2').html(listval.locality);
                            $('#addressId').val(listval.id);
                            $("#address_box").show();
                            isShipping = true;
                        }
                    }
                });

                if (isShipping == false) {
                    shippingAddress.forEach((listval) => {
                        if (listval.isDefault == true) {

                            $("#line_1").html(listval.address);

                            $('#line_2').html(listval.locality);
                            $('#addressId').val(listval.id);
                            $("#address_box").show();
                            isShipping = true;
                        }
                    });
                    if (isShipping == false) {
                        window.location.href = "{{route('delivery-address.index')}}";
                    }
                }
            } else {

                window.location.href = "{{route('delivery-address.index')}}";
            }
            if (userDetails.walletAmount != undefined && userDetails.walletAmount != '' && userDetails.walletAmount != null && !isNaN(userDetails.walletAmount)) {
                wallet_amount = userDetails.walletAmount;
            }

            if (currencyAtRight) {
                wallet_balance = parseFloat(wallet_amount).toFixed(decimal_degits) + "" + currentCurrency;
            } else {
                wallet_balance = currentCurrency + "" + parseFloat(wallet_amount).toFixed(decimal_degits);
            }


            $("#wallet_amount").html(wallet_balance);
        });
    }

    async function manageInventory(products) {

        for (let i = 0; i < products.length; i++) {

            var item = products[i];

            var product_id = item.id;
            var quantity = item.quantity;
            var variant_info = item.variant_info;

            var productDoc = await database.collection('vendor_products').doc(product_id).get();
            var productInfo = productDoc.data();

            if (variant_info) {

                var new_varients = [];
                $.each(productInfo.item_attribute.variants, function (key, value) {
                    if (value.variant_sku == variant_info.variant_sku && value.variant_quantity != undefined && value.variant_quantity != '-1') {
                        value.variant_quantity = value.variant_quantity - quantity;
                        value.variant_quantity = (value.variant_quantity <= 0) ? 0 : value.variant_quantity;
                        value.variant_quantity = value.variant_quantity.toString();
                        new_varients.push(value);
                    } else {
                        new_varients.push(value);
                    }
                });

                database.collection('vendor_products').doc(product_id).update({ 'item_attribute.variants': new_varients });
            } else {
                if (productInfo.quantity != undefined && productInfo.quantity != '-1') {
                    var new_quantity = productInfo.quantity - quantity;
                    new_quantity = (new_quantity <= 0) ? 0 : new_quantity;
                    database.collection('vendor_products').doc(product_id).update({ 'quantity': new_quantity });
                }
            }
        }
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

    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        var R = 6371; // Radius of the earth in km
        var dLat = deg2rad(lat2 - lat1);
        var dLon = deg2rad(lon2 - lon1);
        var a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        var distance = R * c;
        return distance;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
    async function getDriverInfo(pincode) {
        var driver=null;

        await database.collection('users').where('role', '==', 'driver').where('pinCode', '==', pincode).get().then(async function (snapshot) {
            if(snapshot.docs.length>0){
                driver= snapshot.docs[0].data();
                driverFcmToken=driver.fcmToken;
            }
        })

        return driver;
    }
    async function finalCheckout() {
        payableAmount = $('#total_pay').val();
        var total_pay = 0;
        if (payableAmount == 0 || payableAmount == '' || payableAmount == "0") {
            return false;
        }
        if (currencyAtRight) {
            minimumOrderValueTxt = parseFloat(minimumOrderValue).toFixed(decimal_degits) + "" + currentCurrency;
        } else {
            minimumOrderValueTxt = currentCurrency + "" + parseFloat(minimumOrderValue).toFixed(decimal_degits);
        }
        if (payableAmount < minimumOrderValue) {
            Swal.fire({ text: "{{trans('lang.order_value_grater_than')}} " + minimumOrderValueTxt, icon: "error" });
            return false;

        }
        var otp = Math.floor(100000 + Math.random() * 900000);
        var id = $('.count-number-input-cart').attr('data-id');
        var quantity = $('.count_number_' + id).val();
        var stock_quantity = $('.count-number-input-cart').attr('data-vqty');
        var authorName = '';

        userDetailsRef.get().then(async function (userSnapshots) {

            var vendorID = vendorDetails.id;
            var userDetails = userSnapshots.docs[0].data();
            vendorDetailsRef.where('id', "==", vendorID).get().then(async function (vendorSnapshots) {
                var vendorDetails = vendorSnapshots.docs[0].data();
                if (vendorDetails) {
                    var vendorUser = await getVendorUser(vendorDetails.author);

                    var products = [];

                    $(".product-item").each(function (index) {

                        product_id = $(this).attr("data-id");
                        price = $("#price_" + product_id).val();
                        item_price = $("#item_price_" + product_id).val();
                        productDiscount = $("#product_discount_" + product_id).val();
                        photo = $("#photo_" + product_id).val();
                        total_pay = $("#total_pay").val();
                        name = $("#name_" + product_id).val();
                        quantity = $("#quantity_" + product_id).val();
                        var category_id = $("#category_id_" + product_id).val();
                        var description = $("#description_" + product_id).val();
                        var hsn_code = $("#hsn_code_" + product_id).val();
                        var unit = $("#unit_" + product_id).val();
                        var dis_price = $("#dis_price_" + product_id).val();
                        var variant_info = $("#variant_info_" + product_id).val();

                        if (variant_info) {
                            variant_info = $.parseJSON(atob(variant_info));
                            product_id = product_id.split("PV")[0];
                        } else {
                            var variant_info = null;
                        }


                        products.push({
                            'category_id': category_id,
                            'description': description,
                            'discount': productDiscount,
                            'discountPrice': dis_price,
                            'hsn_code': hsn_code,
                            'id': product_id,
                            'name': name,
                            'photo': photo,
                            'price': item_price,
                            'quantity': parseInt(quantity),
                            'unit': unit,
                            'variant_info': variant_info
                        })

                    });

                    manageInventory(products);

                    var author = userDetails;

                    var authorID = userId;

                    authorName = userDetails.name;
                    var authorEmail = userDetails.email;

                    var couponCode = $("#coupon_code_main").val();

                    var discountType = $("#discountType").val();

                    var couponId = $("#coupon_id").val();

                    var discount = $("#discount").val();
                    var discountAmount = $('#discount_amount').val();
                    var address = '';

                    shippingAdrs = userDetails.shippingAddress;
                    addressId = $('#addressId').val();

                    var addressFound = false;
                    var driver=null;
                    for (var i = 0; i < shippingAdrs.length; i++) {
                        var listval = shippingAdrs[i];
                        if (listval.id == addressId) {
                            if (listval.hasOwnProperty('pinCode') && listval.pinCode != null && listval.pinCode != '') {
                                address = listval;
                                var userLat = parseFloat(address.location.latitude);
                                var userLng = parseFloat(address.location.longitude);
                                var vendor_lat = getCookie('restaurant_latitude');
                                var vendor_long = getCookie('restaurant_longitude');
                                if (userLat != null && userLat != '' && userLat != NaN && userLng != null && userLng != '' && userLng != NaN) {

                                    var distance = await getDistanceFromLatLonInKm(vendor_lat, vendor_long, userLat, userLng);

                                    if (distance <= vendorRadius) {
                                        addressFound = true;
                                        driver = await getDriverInfo(listval.pinCode);
                                        break;
                                    } else {
                                        Swal.fire({ text: "{{trans('lang.service_not_available_in_current_address')}}", icon: "error" });
                                        return false;
                                    }
                                } else {
                                    Swal.fire({ text: "{{trans('lang.service_not_available_in_current_address')}}", icon: "error" });
                                    return false;
                                }

                            } else {
                                Swal.fire({ text: "{{trans('lang.adress_without_pincode_error')}}", icon: "error" });
                                return false;
                            }
                        }
                    }

                    if (!addressFound) {
                        return false;
                    }
                    var createdAt = firebase.firestore.FieldValue.serverTimestamp();



                    var vendor = vendorDetails;
                    var deliveryCharge = $("#deliveryCharge").val();
                    var tax_label = $("#tax_label").val();
                    var tax = $("#tax").val();
                    var payment_method = $('input[name="payment_method"]:checked').val();
                    var delivery_option = $('input[name="delivery_option"]').val();
                    var estimatedTimeToPrepare = $('#estimatedTime').val();
                    var order_json = {

                        couponCode: couponCode,
                        discount: parseFloat(discount),
                        discountType: discountType,
                        discountAmount: discountAmount,
                        couponId: couponId,
                        deliveryCharge: deliveryCharge,
                        id: id_order,
                        otp: otp.toString(),
                        paymentMethod: payment_method,
                        products: products,
                        status: "InProcess",
                        tax: taxSetting,
                        userID: userId,
                        subject: orderPlacedSubject,
                        message: orderPlacedMsg,
                        estimatedTimeToPrepare: estimatedTimeToPrepare,
                        address: address,

                    }

                    if (payment_method == "RazorPay") {

                        var razorpayKey = $("#razorpayKey").val();

                        var razorpaySecret = $("#razorpaySecret").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                razorpaySecret: razorpaySecret,
                                razorpayKey: razorpayKey,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";

                            }

                        });


                    }
                    else if (payment_method == "MercadoPago") {

                        var mercadopago_public_key = $("#mercadopago_public_key").val();
                        var mercadopago_access_token = $("#mercadopago_access_token").val();
                        var mercadopago_isSandbox = $("#mercadopago_isSandbox").val();
                        var mercadopago_isEnabled = $("#mercadopago_isEnabled").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                mercadopago_public_key: mercadopago_public_key,
                                mercadopago_access_token: mercadopago_access_token,
                                payment_method: payment_method,
                                authorName: authorName,
                                id: id_order,
                                quantity: quantity,
                                total_pay: total_pay,
                                mercadopago_isSandbox: mercadopago_isSandbox,
                                mercadopago_isEnabled: mercadopago_isEnabled,
                                address_line1: '',
                                address_line2: '',
                                address_zipcode: '',
                                address_city: '',
                                address_country: ''
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });
                    }
                    else if (payment_method == "Stripe") {



                        var stripeKey = $("#stripeKey").val();

                        var stripeSecret = $("#stripeSecret").val();

                        var isStripeSandboxEnabled = $("#isStripeSandboxEnabled").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                stripeKey: stripeKey,
                                stripeSecret: stripeSecret,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay,
                                isStripeSandboxEnabled: isStripeSandboxEnabled,
                                address_line1: '',
                                address_line2: '',
                                address_zipcode: '',
                                address_city: '',
                                address_country: ''
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });


                    }
                    else if (payment_method == "PayPal") {


                        var paypalKey = $("#paypalKey").val();

                        var paypalSecret = $("#paypalSecret").val();

                        var ispaypalSandboxEnabled = $("#ispaypalSandboxEnabled").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                paypalKey: paypalKey,
                                paypalSecret: paypalSecret,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay,
                                ispaypalSandboxEnabled: ispaypalSandboxEnabled,
                                address_line1: '',
                                address_line2: '',
                                address_zipcode: '',
                                address_city: '',
                                address_country: ''
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });


                    }
                    else if (payment_method == "PayFast") {

                        var payfast_merchant_key = $("#payfast_merchant_key").val();
                        var payfast_merchant_id = $("#payfast_merchant_id").val();
                        var payfast_return_url = $("#payfast_return_url").val();
                        var payfast_notify_url = $("#payfast_notify_url").val();
                        var payfast_cancel_url = $("#payfast_cancel_url").val();
                        var payfast_isSandbox = $("#payfast_isSandbox").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                payfast_merchant_key: payfast_merchant_key,
                                payfast_merchant_id: payfast_merchant_id,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay,
                                payfast_isSandbox: payfast_isSandbox,
                                payfast_return_url: payfast_return_url,
                                payfast_notify_url: payfast_notify_url,
                                payfast_cancel_url: payfast_cancel_url,
                                address_line1: '',
                                address_line2: '',
                                address_zipcode: '',
                                address_city: '',
                                address_country: ''
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });

                    }
                    else if (payment_method == "PayStack") {

                        var paystack_public_key = $("#paystack_public_key").val();
                        var paystack_secret_key = $("#paystack_secret_key").val();
                        var paystack_isSandbox = $("#paystack_isSandbox").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay,
                                paystack_isSandbox: paystack_isSandbox,
                                paystack_public_key: paystack_public_key,
                                paystack_secret_key: paystack_secret_key,
                                address_line1: '',
                                address_line2: '',
                                address_zipcode: '',
                                address_city: '',
                                address_country: '',
                                email: userDetails.email
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();
                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });


                    }
                    else if (payment_method == "FlutterWave") {

                        var flutterwave_isenabled = $("#flutterWave_isEnabled").val();
                        var flutterWave_encryption_key = $("#flutterWave_encryption_key").val();
                        var flutterWave_public_key = $("#flutterWave_public_key").val();
                        var flutterWave_secret_key = $("#flutterWave_secret_key").val();
                        var flutterWave_isSandbox = $("#flutterWave_isSandbox").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                payment_method: payment_method,
                                total_pay: total_pay,
                                flutterWave_isSandbox: flutterWave_isSandbox,
                                flutterWave_public_key: flutterWave_public_key,
                                flutterWave_secret_key: flutterWave_secret_key,
                                flutterwave_isenabled: flutterwave_isenabled,
                                flutterWave_encryption_key: flutterWave_encryption_key,
                                currencyData: currencyData,
                                authorName: authorName,
                                email: userDetails.email
                            },

                            success: function (data) {


                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });

                    } else if (payment_method == "xendit") {

                        if (!['IDR', 'PHP', 'USD', 'VND', 'THB', 'MYR', 'SGD'].includes(currencyData.code)){
                            alert("Currency restriction");
                            return false;
                        }
                        var xendit_enable = $("#xendit_enable").val();
                        var xendit_apiKey = $("#xendit_apiKey").val();
                        var xendit_image = $("#xendit_image").val();
                        var xendit_isSandbox = $("#xendit_isSandbox").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay,
                                xendit_enable: xendit_enable,
                                xendit_apiKey: xendit_apiKey,
                                xendit_image: xendit_image,
                                xendit_isSandbox: xendit_isSandbox,
                                email: userDetails.email,
                                currencyData: currencyData
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });

                    } else if (payment_method == "midtrans") {

                        var midtrans_enable = $("#midtrans_enable").val();
                        var midtrans_serverKey = $("#midtrans_serverKey").val();
                        var midtrans_image = $("#midtrans_image").val();
                        var midtrans_isSandbox = $("#midtrans_isSandbox").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay,
                                midtrans_enable: midtrans_enable,
                                midtrans_serverKey: midtrans_serverKey,
                                midtrans_image: midtrans_image,
                                midtrans_isSandbox: midtrans_isSandbox,
                                email: userDetails.email,
                                currencyData: currencyData
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });

                    } else if (payment_method == "orangepay") {

                        var orangepay_enable = $("#orangepay_enable").val();
                        var orangepay_auth = $("#orangepay_auth").val();
                        var orangepay_image = $("#orangepay_image").val();
                        var orangepay_isSandbox = $("#orangepay_isSandbox").val();
                        var orangepay_clientId = $("#orangepay_clientId").val();
                        var orangepay_clientSecret = $("#orangepay_clientSecret").val();
                        var orangepay_merchantKey = $("#orangepay_merchantKey").val();
                        var orangepay_notifyUrl = $("#orangepay_notifyUrl").val();
                        var orangepay_returnUrl = $("#orangepay_returnUrl").val();
                        var orangepay_cancelUrl = $("#orangepay_cancelUrl").val();

                        $.ajax({

                            type: 'POST',

                            url: "<?php echo route('order-proccessing'); ?>",

                            data: {
                                _token: '<?php echo csrf_token() ?>',
                                order_json: order_json,
                                payment_method: payment_method,
                                authorName: authorName,
                                total_pay: total_pay,
                                orangepay_enable: orangepay_enable,
                                orangepay_auth: orangepay_auth,
                                orangepay_image: orangepay_image,
                                orangepay_isSandbox: orangepay_isSandbox,
                                orangepay_clientId: orangepay_clientId,
                                orangepay_clientSecret: orangepay_clientSecret,
                                orangepay_merchantKey: orangepay_merchantKey,
                                orangepay_notifyUrl: orangepay_notifyUrl,
                                orangepay_returnUrl: orangepay_returnUrl,
                                orangepay_cancelUrl: orangepay_cancelUrl,
                                email: userDetails.email,
                                currencyData: currencyData
                            },

                            success: function (data) {

                                data = JSON.parse(data);

                                $('#cart_list').html(data.html);
                                loadcurrencynew();

                                window.location.href = "<?php echo route('pay'); ?>";


                            }

                        });

                    } else {

                        couponCode= (couponCode=='') ? null :couponCode;
                        discount= (discount=='') ? null : discount.toString();
                        discountType = (discountType == '') ? null : discountType;
                        couponId = (couponId == '') ? null : couponId;
                        var isEnabled = (couponCode == null) ? null : true;

                        var coupon_details = { 'code': couponCode, 'description': null, 'discount': discount, 'discountType': discountType, 'id': couponId, 'isEnabled': isEnabled }
                        if (payment_method == "Wallet") {
                            payment_method = "Wallet";

                            if (parseFloat(wallet_amount) < parseFloat(total_pay)) {
                                Swal.fire({ text: "{{trans('lang.dont_have_sufficient_balance_to_place_order')}}", icon: "error" });
                                return false;

                            }
                        } else {
                            payment_method = "Cash On Delivery";
                        }

                        for (var n = 0; n < products.length; n++) {
                            if (products[n].photo == null) {
                                products[n].photo = "";
                            }
                            if (products[n].hsn_code == null) {
                                products[n].hsn_code = "";
                            }
                            products[n].quantity = parseInt(products[n].quantity);
                        }
                        if (address == "") {

                            var location = {
                                'latitude': parseFloat(getCookie('address_lat')),
                                'longitude': parseFloat(getCookie('address_lng'))

                            };

                            var address = {
                                'address': null,
                                'addressAs': null,
                                'id': null,
                                'isDefault': null,
                                'landmark': null,
                                'locality': getCookie('address_name'),
                                'location': location,
                                'pinCode': null
                            };
                        }

                        database.collection('orders').doc(id_order).set({
                            'coupon': coupon_details,
                            "createdAt": createdAt,
                            'deliveryCharge': deliveryCharge,
                            'driverID': (driver!=null && driver!='') ? driver.id : null,
                            'driver':driver,
                            'estimatedTimeToPrepare': estimatedTimeToPrepare,
                            'id': id_order,
                            'otp': otp.toString(),
                            'paymentMethod': payment_method,
                            'products': products,
                            'status': "InProcess",
                            "tax": taxSetting,
                            "user": userDetails,
                            "userID": userId,
                            'vendor': vendorDetails,
                            'address': address,


                        }).then(function (result) {

                            var sendnotification = "<?php echo url('/');?>";
                            $.ajax({

                                type: 'POST',

                                url: "<?php echo route('order-complete'); ?>",

                                data: {
                                    _token: '<?php echo csrf_token() ?>',
                                    'fcm': driverFcmToken,
                                    'authorName': authorName,
                                    'subject': '{{trans("lang.order_placed")}}',
                                    'message': authorName+' {{trans("lang.has_placed_order")}}'
                                },

                                success: async function (data) {



                                    if (payment_method == "Wallet") {
                                        wallet_amount = wallet_amount - total_pay;
                                        database.collection('users').doc(userId).update({ 'walletAmount': wallet_amount.toString() }).then(async function (result) {
                                            walletId = database.collection("tmp").doc().id;
                                            database.collection('wallet_transaction').doc(walletId).set({
                                                'amount': "-" + parseFloat(total_pay),
                                                'createdDate': createdAt,
                                                'id': walletId,
                                                'isCredit': false,
                                                'note': 'Order amount debit',
                                                'transactionId': '',
                                                'paymentType': "Wallet",
                                                'userId': userId,
                                                'orderId': id_order
                                            }).then(async function (result) {
                                                 if (driver != null && driver != '') {
                                                    await addNotification(driver, id_order, authorName);
                                                }
                                                $('#cart_list').html(data.html);
                                                loadcurrencynew();

                                                if (authorEmail != '' && authorEmail != null) {
                                                    var emailUserData = await sendMailData(authorEmail, authorName, id_order, address, payment_method, products, couponCode, discountAmount, taxSetting, deliveryCharge);
                                                }
                                                if (vendorUser && vendorUser != undefined) {

                                                    var emailVendorData = await sendMailData(vendorUser.email, vendorUser.name, id_order, address, payment_method, products, couponCode, discountAmount, taxSetting, deliveryCharge);

                                                }

                                                window.location.href = "<?php echo url('success'); ?>";
                                            });
                                        });
                                    } else {
                                        $('#cart_list').html(data.html);
                                        if(driver!=null && driver!=''){
                                            await addNotification(driver, id_order, authorName);
                                        }

                                        if (authorEmail != '' && authorEmail != null) {
                                            var emailUserData = await sendMailData(authorEmail, authorName, id_order, address, payment_method, products, couponCode, discountAmount, taxSetting, deliveryCharge);
                                        }
                                        if (vendorUser && vendorUser != undefined) {

                                            var emailVendorData = await sendMailData(vendorUser.email, vendorUser.name, id_order, address, payment_method, products, couponCode, discountAmount, taxSetting, deliveryCharge);

                                        }
                                        window.location.href = "<?php echo url('success'); ?>";

                                    }


                                }

                            });

                        });
                    }
                }
            });

        });
    }
    async function addNotification(driver,orderId,authorName){
        var notifyId = database.collection("tmp").doc().id;
        database.collection('notifications').doc(notifyId).set({
            'body':authorName+' has place order',
            'createdAt': firebase.firestore.FieldValue.serverTimestamp(),
            'id':notifyId,
            'notificationType':'order',
            'orderId': orderId,
            'role':'driver',
            'title':'Order Placed',
            'userId': driver.id,
            'status': 'InProcess'

        })
    }
</script>
