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
<div class="siddhi-popular">


    <div class="container">

        <div class="transactions-banner p-4 rounded">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <h3 class="font-weight-bold h4 text-light" id="total_payment"></h3>
                </div>
                <div class="col-md-12">
                    <button class="btn btn-light">
                        <a data-toggle="modal" data-target="#add_wallet_money"
                            class="d-flex w-100 align-items-center border-bottom p-3">
                            <div class="left mr-3 text-green">
                                <h6 class="font-weight-bold mb-1 text-dark">{{trans('lang.add_wallet_money')}}</h6>
                            </div>
                            <div class="right ml-auto">
                                <h6 class="font-weight-bold m-0"><i class="feather-chevron-right"></i></h6>
                            </div>
                        </a>
                    </button>
                </div>

            </div>
        </div>

        <div class="text-center py-5 not_found_div" style="display:none"><img src="{{asset('img/no-result.png')}}">
        </div>


        <div id="append_list1" class="res-search-list"></div>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="container mt-4 mb-4 p-0">

                    <div class="data-table_paginate">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                <li class="page-item ">
                                    <a class="page-link" href="javascript:void(0);" id="users_table_previous_btn"
                                        onclick="prev()" data-dt-idx="0" tabindex="0">{{trans('lang.previous')}}</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);" id="users_table_next_btn"
                                        onclick="next()" data-dt-idx="2" tabindex="0">{{trans('lang.next')}}</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="add_wallet_money" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{trans('lang.add_wallet_money')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-12 error_top_pass"></div>
                    <div class="col-md-12 form-group">
                        <label class="form-label">{{trans('lang.amount')}}</label>
                        <div class="control-inner">
                            <div class="currentCurrency"></div>
                            <input type="number" class="form-control wallet_amount">
                        </div>
                    </div>
                    <div class="accordion col-md-12 mb-3 rounded shadow-sm bg-white border" id="accordionExample">

                        <div class="siddhi-card overflow-hidden checkout-payment-options">

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="razorpay_box">

                                <input type="radio" name="payment_method" id="razorpay" value="razorpay"
                                    class="custom-control-input" checked>

                                <label class="custom-control-label" for="razorpay">{{trans('lang.razorpay')}}</label>

                                <input type="hidden" id="isEnabled">

                                <input type="hidden" id="isSandboxEnabled">

                                <input type="hidden" id="razorpayKey">

                                <input type="hidden" id="razorpaySecret">

                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="stripe_box">

                                <input type="radio" name="payment_method" id="stripe" value="stripe"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="stripe">{{trans('lang.stripe')}}</label>


                                <input type="hidden" id="isStripeSandboxEnabled">

                                <input type="hidden" id="stripeKey">

                                <input type="hidden" id="stripeSecret">

                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="paypal_box">

                                <input type="radio" name="payment_method" id="paypal" value="paypal"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="paypal">{{trans('lang.pay_pal')}}</label>


                                <input type="hidden" id="ispaypalSandboxEnabled">

                                <input type="hidden" id="paypalKey">

                                <input type="hidden" id="paypalSecret">

                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="payfast_box">

                                <input type="radio" name="payment_method" id="payfast" value="payfast"
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

                                <input type="radio" name="payment_method" id="paystack" value="paystack"
                                    class="custom-control-input">

                                <label class="custom-control-label" for="paystack">{{trans('lang.pay_stack')}}</label>

                                <input type="hidden" id="paystack_isEnabled">

                                <input type="hidden" id="paystack_isSandbox">

                                <input type="hidden" id="paystack_public_key">

                                <input type="hidden" id="paystack_secret_key">

                            </div>

                            <div class="custom-control custom-radio border-bottom py-2" style="display:none;"
                                id="flutterWave_box">

                                <input type="radio" name="payment_method" id="flutterwave" value="flutterwave"
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

                                <input type="radio" name="payment_method" id="mercadopago" value="mercadopago"
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

                        </div>


                    </div>
                </div>
            </div>
            <div class="modal-footer p-0 border-0">
                <div class="col-6 m-0 p-0">
                    <button type="button" class="btn border-top btn-lg btn-block" data-dismiss="modal">{{
                        trans('lang.close')}}</button>
                </div>
                <div class="col-6 m-0 p-0">
                    <button type="button" onclick="finalCheckout()"
                        class="btn btn-primary btn-lg btn-block change_user_password remove_hover">{{
                        trans('lang.next')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')


@include('layouts.nav')


<script type="text/javascript">


    var ref = database.collection('wallet_transaction').where('userId', '==', user_uuid).orderBy('createdDate', 'desc');

    var cityToCountry = '<?php echo json_encode($countriesJs); ?>';
    var decimal_degits = 0;
    cityToCountry = JSON.parse(cityToCountry);
    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    userCity = userTimeZone.split('/')[1];
    userCountry = cityToCountry[userCity];

    var pagesize = 10;
    var offest = 1;
    var end = null;
    var endarray = [];
    var start = null;
    var append_list = '';
    var totalPayment = 0;
    var refMinDeposite = database.collection('settings').doc('globalSettings');
    var minimumAmountToDeposit = 0;

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

    var decimal_digits = 0;
    var currencyAtRight = false;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    var currencyData = "";
    refCurrency.get().then(async function (snapshots) {
        currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_digits) {
            decimal_digits = currencyData.decimal_digits;
        }
        $('.currentCurrency').html(currentCurrency);
    });

    $(document).ready(async function () {
        await refMinDeposite.get().then(async function (snapshot) {
            var data = snapshot.data();
            if (data.hasOwnProperty('minimumAmountToDeposit') && data.minimumAmountToDeposit != null && data.minimumAmountToDeposit != '') {
                minimumAmountToDeposit = data.minimumAmountToDeposit;
            }
        });
        $("#overlay").show();
        getPaymentGateways();
        var totalPayment = 0;

        await database.collection('users').where("id", "==", user_uuid).get().then(
            (amountsnapshot) => {
                var paymentDatas = amountsnapshot.docs[0].data();

                if (paymentDatas.hasOwnProperty('walletAmount') && paymentDatas.walletAmount != null && !isNaN(paymentDatas.walletAmount)) {

                    totalPayment = parseFloat(paymentDatas.walletAmount);

                }

                if (currencyAtRight) {
                    totalPayment = totalPayment.toFixed(decimal_digits) + '' + currentCurrency;
                } else {
                    totalPayment = currentCurrency + '' + totalPayment.toFixed(decimal_digits);
                }

            });
        jQuery("#total_payment").html('{{trans("lang.wallet_amount")}} : ' + totalPayment);


        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';

        ref.limit(pagesize).get().then(async function (snapshots) {
            if (snapshots != undefined) {
                var html = '';
                html = await buildHTML(snapshots);
                jQuery("#overlay").hide();

                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.push(snapshots.docs[0]);
                    $("#overlay").hide();
                }

                if (snapshots.docs.length == 0) {
                    jQuery("#users_table_previous_btn").hide();
                    jQuery("#users_table_next_btn").hide();
                    $(".not_found_div").show();
                }
            }

        });

    });

    function getPaymentGateways() {
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
    }

    async function buildHTML(snapshots) {
        var html = '';
        var alldata = [];
        var number = [];
        var vendorIDS = [];
        await Promise.all(snapshots.docs.map(async (listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        }));

        await Promise.all(alldata.map(async (value) => {

            var val = value;
            var date = val.createdDate.toDate().toDateString();
            var time = val.createdDate.toDate().toLocaleTimeString('en-US');
            var price_val = '';

            if (currencyAtRight) {
                price_val = parseFloat(val.amount).toFixed(decimal_digits) + '' + currentCurrency;
            } else {
                price_val = currentCurrency + '' + parseFloat(val.amount).toFixed(decimal_digits);
            }

            var order_id = '';
            if (val.hasOwnProperty('orderId')) {
                order_id = val.orderId;
                var orderStatus = await getOrderDetail(val.orderId);

                if (orderStatus == "InProcess") {
                    var view_details = "{{ route('pending_order', ':id')}}";
                    view_details = view_details.replace(':id', 'id=' + val.orderId)
                }
                else if (orderStatus == "InTransit") {
                    var view_details = "{{ route('intransit_order', ':id')}}";
                    view_details = view_details.replace(':id', 'id=' + val.orderId)
                }
                else if (orderStatus == "Delivered") {
                    var view_details = "{{ route('completed_order', ':id')}}";
                    view_details = view_details.replace(':id', 'id=' + val.orderId)
                } else {
                    view_details = 'javascript:void(0)';
                }

            } else {
                var view_details = 'javascript:void(0)';
            }


            html = html + '<div class="transactions-list-wrap mt-4"><a href="' + view_details + '"><div class="bg-white px-4 py-3 border rounded-lg mb-3 transactions-list-view shadow-sm"><div class="gold-members d-flex align-items-center transactions-list">';

            var desc = '';

            if ((val.hasOwnProperty('isCredit') && val.isCredit) || (val.payment_method == "Cancelled Order Payment")) {
                price_val = '<div class="float-right ml-auto"><span class="price font-weight-bold h4">+ ' + price_val + '</span>';
                desc = "Wallet Topup";
            } else if (val.hasOwnProperty('isCredit') && !val.isCredit) {

                price_val = '<div class="float-right ml-auto"><span class="font-weight-bold h4" style="color: red"> ' + price_val + '</span>';
                desc = "Order amount debit";
            } else {
                price_val = '<div class="float-right ml-auto"><span class="font-weight-bold h4">' + price_val + '</span>';

            }


            html = html + '<div class="media transactions-list-left"><div class="mr-3 font-weight-bold card-icon"><span><i class="fa fa-credit-card"></i></span></div><div class="media-body"><h6 class="date">' + desc + '</h6><h6>' + date + ' ' + time + '</h6><p class="text-muted mb-0">' + order_id + '</p><p class="text-muted mb-0">' + val.paymentType + '</p></div></div>';


            html = html + price_val;


            html = html + '<span class="go-arror text-dark btn-block text-right mt-2"><i class="fa fa-angle-right"></i></span>';


            html = html + '</div></div></div></a></div>';



        }));

        return html;

    }
    async function getOrderDetail(orderId) {
        var status = '';
        await database.collection('orders').where("id", "==", orderId).get().then(async function (snapshot) {
            if (snapshot.docs.length > 0) {

                var data = snapshot.docs[0].data();
                status = data.status;

            }
        });

        return status;

    }
    async function next() {
        if (start != undefined || start != null) {
            jQuery("#overlay").hide();

            listener = ref.startAfter(start).limit(pagesize).get();
            listener.then(async (snapshots) => {

                html = '';
                html = await buildHTML(snapshots);

                jQuery("#overlay").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];

                    if (endarray.indexOf(snapshots.docs[0]) != -1) {
                        endarray.splice(endarray.indexOf(snapshots.docs[0]), 1);
                    }
                    endarray.push(snapshots.docs[0]);
                }
            });
        }
    }

    async function prev() {
        if (endarray.length == 1) {
            return false;
        }
        end = endarray[endarray.length - 2];

        if (end != undefined || end != null) {
            jQuery("#overlay").show();
            listener = ref.startAt(end).limit(pagesize).get();

            listener.then(async (snapshots) => {
                html = '';
                html = await buildHTML(snapshots);
                jQuery("#overlay").hide();
                if (html != '') {
                    append_list.innerHTML = html;
                    start = snapshots.docs[snapshots.docs.length - 1];
                    endarray.splice(endarray.indexOf(endarray[endarray.length - 1]), 1);

                    if (snapshots.docs.length < pagesize) {

                        jQuery("#users_table_previous_btn").hide();
                    }

                }
            });
        }
    }

    async function finalCheckout() {
        var amount = $('.wallet_amount').val();
        if (amount < parseFloat(minimumAmountToDeposit)) {
            if (currencyAtRight) {
                minDepAmountHtml = parseFloat(minimumAmountToDeposit).toFixed(decimal_digits) + '' + currentCurrency;
            } else {
                minDepAmountHtml = currentCurrency + '' + parseFloat(minimumAmountToDeposit).toFixed(decimal_digits);
            }
            Swal.fire({ text: "{{trans('lang.min_deposite_amount_err')}} " + minDepAmountHtml, icon: "error" });
            return false;

        }
        let userDetails = {};
        const userSnapshots = await database.collection('users').where("id", "==", user_uuid).get();
        userDetails = userSnapshots.docs[0].data();
        const userDetailsJSON = JSON.stringify(userDetails);
        var payment_method = $('input[name="payment_method"]:checked').val();

        if (payment_method == "razorpay") {

            var razorpayKey = $("#razorpayKey").val();
            var razorpaySecret = $("#razorpaySecret").val();
            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    amount: amount,
                    razorpaySecret: razorpaySecret,
                    razorpayKey: razorpayKey,
                    payment_method: payment_method,
                    author: userDetailsJSON
                },
                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });


        } else if (payment_method == "mercadopago") {

            var mercadopago_public_key = $("#mercadopago_public_key").val();
            var mercadopago_access_token = $("#mercadopago_access_token").val();
            var mercadopago_isSandbox = $("#mercadopago_isSandbox").val();
            var mercadopago_isEnabled = $("#mercadopago_isEnabled").val();

            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    amount: amount,
                    mercadopago_public_key: mercadopago_public_key,
                    mercadopago_access_token: mercadopago_access_token,
                    payment_method: payment_method,
                    mercadopago_isSandbox: mercadopago_isSandbox,
                    mercadopago_isEnabled: mercadopago_isEnabled,
                    author: userDetailsJSON
                },

                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });
        } else if (payment_method == "stripe") {


            var stripeKey = $("#stripeKey").val();
            var stripeSecret = $("#stripeSecret").val();
            var isStripeSandboxEnabled = $("#isStripeSandboxEnabled").val();

            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    amount: amount,
                    stripeKey: stripeKey,
                    stripeSecret: stripeSecret,
                    payment_method: payment_method,
                    isStripeSandboxEnabled: isStripeSandboxEnabled,
                    author: userDetailsJSON
                },

                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });


        } else if (payment_method == "paypal") {


            var paypalKey = $("#paypalKey").val();

            var paypalSecret = $("#paypalSecret").val();

            var ispaypalSandboxEnabled = $("#ispaypalSandboxEnabled").val();

            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    paypalKey: paypalKey,
                    paypalSecret: paypalSecret,
                    payment_method: payment_method,
                    author: userDetailsJSON,
                    amount: amount,
                    ispaypalSandboxEnabled: ispaypalSandboxEnabled,
                },

                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });


        } else if (payment_method == "payfast") {

            var payfast_merchant_key = $("#payfast_merchant_key").val();
            var payfast_merchant_id = $("#payfast_merchant_id").val();
            var payfast_return_url = $("#payfast_return_url").val();
            var payfast_notify_url = $("#payfast_notify_url").val();
            var payfast_cancel_url = $("#payfast_cancel_url").val();
            var payfast_isSandbox = $("#payfast_isSandbox").val();

            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    author: userDetailsJSON,
                    amount: amount,
                    payfast_merchant_key: payfast_merchant_key,
                    payfast_merchant_id: payfast_merchant_id,
                    payment_method: payment_method,
                    payfast_isSandbox: payfast_isSandbox,
                    payfast_return_url: payfast_return_url,
                    payfast_notify_url: payfast_notify_url,
                    payfast_cancel_url: payfast_cancel_url,
                },

                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });

        } else if (payment_method == "paystack") {

            var paystack_public_key = $("#paystack_public_key").val();
            var paystack_secret_key = $("#paystack_secret_key").val();
            var paystack_isSandbox = $("#paystack_isSandbox").val();

            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    author: userDetailsJSON,
                    amount: amount,
                    payment_method: payment_method,
                    paystack_isSandbox: paystack_isSandbox,
                    paystack_public_key: paystack_public_key,
                    paystack_secret_key: paystack_secret_key,
                    email: userDetails.email
                },
                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });


        } else if (payment_method == "flutterwave") {

            var flutterwave_isenabled = $("#flutterWave_isEnabled").val();
            var flutterWave_encryption_key = $("#flutterWave_encryption_key").val();
            var flutterWave_public_key = $("#flutterWave_public_key").val();
            var flutterWave_secret_key = $("#flutterWave_secret_key").val();
            var flutterWave_isSandbox = $("#flutterWave_isSandbox").val();

            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    author: userDetailsJSON,
                    amount: amount,
                    payment_method: payment_method,
                    flutterWave_isSandbox: flutterWave_isSandbox,
                    flutterWave_public_key: flutterWave_public_key,
                    flutterWave_secret_key: flutterWave_secret_key,
                    flutterwave_isenabled: flutterwave_isenabled,
                    flutterWave_encryption_key: flutterWave_encryption_key,
                    currencyData: currencyData,
                    email: userDetails.email
                },
                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
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

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    amount: amount,
                    payment_method: payment_method,
                    xendit_enable: xendit_enable,
                    xendit_apiKey: xendit_apiKey,
                    xendit_image: xendit_image,
                    xendit_isSandbox: xendit_isSandbox,
                    author: userDetailsJSON
                },

                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });

        } else if (payment_method == "midtrans") {

            var midtrans_enable = $("#midtrans_enable").val();
            var midtrans_serverKey = $("#midtrans_serverKey").val();
            var midtrans_image = $("#midtrans_image").val();
            var midtrans_isSandbox = $("#midtrans_isSandbox").val();

            $.ajax({

                type: 'POST',

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    amount: amount,
                    payment_method: payment_method,
                    author: userDetailsJSON,
                    midtrans_enable: midtrans_enable,
                    midtrans_serverKey: midtrans_serverKey,
                    midtrans_image: midtrans_image,
                    midtrans_isSandbox: midtrans_isSandbox,
                },

                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
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

                url: "<?php echo route('wallet-proccessing'); ?>",

                data: {
                    _token: '<?php echo csrf_token() ?>',
                    amount: amount,
                    payment_method: payment_method,
                    author: userDetailsJSON,
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
                },

                success: function (data) {
                    window.location.href = "<?php echo route('pay-wallet'); ?>";
                }

            });

        } else {
        }

    }
</script>
