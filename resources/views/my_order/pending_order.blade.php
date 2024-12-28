@include('layouts.app')

@include('layouts.header')

<div class="d-none">

    <div class="bg-primary p-3 d-flex align-items-center">

        <a class="toggle togglew toggle-2" href="#"><span></span></a>

        <h4 class="font-weight-bold m-0 text-white">{{trans('lang.my_orders')}}</h4>

    </div>

</div>

<section class="py-4 siddhi-main-body">

    <div class="container">

        <div class="row">

            <div class="col-md-12 top-nav mb-3">

                <ul class="nav nav-tabsa custom-tabsa border-0 bg-white rounded overflow-hidden shadow-sm p-2 c-t-order"
                    id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link border-0 text-dark py-3" href="{{url('my_order')}}"> <i
                                class="feather-list mr-2 text-success mb-0"></i>
                            {{trans('lang.all')}}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link border-0 text-dark py-3 active" href="{{url('my_order')}}"> <i
                                class="feather-clock mr-2 text-warning mb-0"></i>
                            {{trans('lang.on_progress')}}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link border-0 text-dark py-3" href="{{url('my_order')}}">
                            <i class="feather-clock mr-2 text-success mb-0"></i> {{trans('lang.intransit')}}</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link border-0 text-dark py-3" href="{{url('my_order')}}"> <i
                                class="feather-check mr-2 text-success mb-0"></i>
                            {{trans('lang.delivered')}}</a>
                    </li>
                </ul>
            </div>

            <div class="col-md-12">


                <section class="bg-white siddhi-main-body rounded shadow-sm overflow-hidden">

                    <div class="container p-0">
                        <div class="p-3 border-bottom gendetail-row">
                            <div class="row">

                                <div class="col-lg-6">
                                    <div class="card p-3">
                                        <h3>{{trans('lang.general_details')}}</h3>
                                        <div class="form-group widt-100 gendetail-col">
                                            <label class="control-label"><strong>{{trans('lang.date_created')}}
                                                    : </strong><span id="order-date"></span></label>
                                        </div>

                                        <div class="form-group widt-100 gendetail-col">
                                            <label class="control-label"><strong>{{trans('lang.order_number')}}
                                                    : </strong><span id="order-number"></span></label>
                                        </div>

                                        <div class="form-group widt-100 gendetail-col">
                                            <label class="control-label"><strong>{{trans('lang.status')}}
                                                    : </strong><span id="order-status" class=""></span></label>
                                        </div>
                                        <div class="form-group widt-100 gendetail-col">
                                            <label class="control-label"><strong>{{trans('lang.time')}}
                                                    : </strong><span id="order_time"></span></label>

                                        </div>

                                        <div class="form-group widt-100 gendetail-col">
                                            <label class="control-label"><strong>{{trans('lang.payment_method')}}
                                                    : </strong><span id="payment_method"></span></label>
                                        </div>

                                    </div>

                                </div>

                                <div class="col-lg-6">
                                    <div class="card p-3">
                                        <h3>{{trans('lang.billing_details')}}</h3>
                                        <div class="form-group widt-100 gendetail-col">
                                            <div class="bill-address">
                                                <p><strong>{{trans('lang.name')}} : </strong><span
                                                        id="billing_name"></span></p>
                                                <p id="billing_adrs"><strong>{{trans('lang.address')}} : </strong><span
                                                        id="billing_line1"></span><br>
                                                    <span id="billing_line2"></span><br>
                                                    <span id="billing_country"></span>
                                                </p>
                                                <p id="shipping_adrs"><strong>{{trans('lang.shipping_address')}} :
                                                    </strong><span id="shipping_line1"></span><br>
                                                    <span id="shipping_line2"></span><br>
                                                    <span id="shipping_country"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row" style="margin-top: 15px;">
                                <div class="col-lg-6">
                                    <div class="card p-3">
                                        <h3>{{trans('lang.vendor_details')}}</h3>
                                        <div class="form-group widt-100">
                                            <div class="vendor-address">
                                                <p><strong>{{trans('lang.address')}} : </strong><span
                                                        id="vendor_address"></span></p>
                                                <p id="vendor_adrs"><strong>{{trans('lang.phone_no')}} : </strong><span
                                                        id="phone_no"></span><br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6 driver_details" style="display:none;">
                                    <div class="card p-3">
                                        <h3>{{trans('lang.driver_details')}}</h3>
                                        <div class="form-group widt-100">
                                            <div class="driver-address">
                                                <p><strong>{{trans('lang.name')}} : </strong><span
                                                        id="driver_name"></span>
                                                <p><strong>{{trans('lang.email')}} : </strong><span
                                                        id="driver_email"></span></p>
                                                <p id="driver_adrs"><strong>{{trans('lang.phone_no')}} : </strong><span
                                                        id="driver_phoneno"></span><br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" id="order-note-box" style="display: none;">
                            <div class="col-lg-12">

                                <div class="p-3 border-bottom">

                                    <h6 class="font-weight-bold">{{trans('lang.order_notes')}}</h6>

                                    <div id="order-note" class="order-note"></div>

                                </div>

                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-12">

                                <div class="p-3 border-bottom">

                                    <h6 class="font-weight-bold">{{trans('lang.order_items')}}</h6>

                                    <div id="order-items"></div>

                                </div>


                                <div class="p-3 border-bottom">

                                    <div class="d-flex align-items-center mb-2">

                                        <h6 class="font-weight-bold mb-1">{{trans('lang.order_subtotal')}}</h6>

                                        <h6 class="font-weight-bold ml-auto mb-1" id="order-subtotal"></h6>

                                    </div>

                                </div>

                                <div class="p-3 border-bottom">

                                    <div class="d-flex align-items-center mb-2">

                                        <h6 class="font-weight-bold mb-1">{{trans('lang.order_discount')}}</h6>

                                        <h6 class="font-weight-bold ml-auto mb-1" id="order-discount" style="color:red">
                                        </h6>

                                    </div>

                                </div>


                                <div class="p-3 border-bottom order_tax_div d-none">
                                    <div class="d-flex align-items-center mb-2">
                                        <h6 class="font-weight-bold mb-1">{{trans('lang.order_tax')}}</h6>
                                    </div>
                                    <hr>
                                    <div id="order-tax"></div>

                                </div>

                                <div class="p-3 border-bottom order_shopping_div">

                                    <div class="d-flex align-items-center mb-2">

                                        <h6 class="font-weight-bold mb-1">{{trans('lang.order_shipping')}}</h6>

                                        <h6 class="font-weight-bold ml-auto mb-1" id="order-shipping"></h6>

                                    </div>

                                </div>


                                <div class="p-3 border-bottom used_coupon_code_div" style="display:none">

                                    <div class="d-flex align-items-center mb-2">

                                        <h6 class="font-weight-bold mb-1">{{trans('lang.used_coupon')}}</h6>

                                        <h6 class="font-weight-bold ml-auto mb-1" id="used_coupon_code"></h6>

                                    </div>

                                </div>

                                <div class="p-3 bg-white">

                                    <div class="d-flex align-items-center mb-2">

                                        <h6 class="font-weight-bold mb-1">{{trans('lang.order_total')}}</h6>

                                        <h6 class="font-weight-bold ml-auto mb-1" id="order-total"></h6>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </div>

</section>


@include('layouts.footer')


@include('layouts.nav')


<script type="text/javascript">


    var orderId = "<?php echo $_GET['id']; ?>";
    var append_categories = '';
    var penndingorsersref = database.collection('orders').where('id', "==", orderId);

    var place_image = '';
    var ref_place = database.collection('settings').doc("placeHolderImage");
    ref_place.get().then(async function (snapshots) {
        var placeHolderImage = snapshots.data();
        place_image = placeHolderImage.image;

    });

    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    refCurrency.get().then(async function (snapshots) {
        var currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        currencyAtRight = currencyData.symbolAtRight;

        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }
    });


    $(document).ready(function () {
        getOrderDetails();
    });

    async function getOrderDetails() {

        database.collection('vendors').get().then(async function (snapshot) {
            if (snapshot.docs.length > 0) {
                storeOwnerData = snapshot.docs[0].data();
                if (storeOwnerData.hasOwnProperty('location')) {
                    $("#vendor_address").text(storeOwnerData.location);
                }
                if (storeOwnerData.hasOwnProperty('phonenumber')) {
                    $("#phone_no").text(storeOwnerData.phonenumber);
                }
            }
        })


        penndingorsersref.get().then(async function (pendingorderSnapshots) {


            var orderDetails = pendingorderSnapshots.docs[0].data();

            var prepare_time = orderDetails.estimatedTimeToPrepare;
            var order_status, image, payment_method;

            if (orderDetails.status == "InProcess") {
                order_status = '<span class="badge badge-info py-2 px-3">' + orderDetails.status + '</span>';
            }
            else if (orderDetails.status == "InTransit") {
                order_status = '<span class="badge badge-primary py-2 px-3">' + orderDetails.status + '</span>';

            }
            else {
                order_status = '<span class="badge badge-success py-2 px-3">' + orderDetails.status + '</span>';

            }


            if (orderDetails.paymentMethod.toLowerCase() == "razorpay") {
                image = '{{asset("img/razorepay.png")}}';
                payment_method = '<img alt="image" width="100px" src="' + image + '" >';

            }
            else if (orderDetails.paymentMethod.toLowerCase() == "stripe") {
                image = '{{asset("img/stripe.png")}}';
                payment_method = '<img alt="image" width="100px" src="' + image + '" >';
            }
            else if (orderDetails.paymentMethod.toLowerCase() == "payfast") {
                image = '{{asset("img/payfast.png")}}';
                payment_method = '<img alt="image"  width="100px" src="' + image + '" >';
            }
            else if (orderDetails.paymentMethod.toLowerCase() == "paystack") {
                image = '{{asset("img/paystack.png")}}';
                payment_method = '<img alt="image" width="100px" src="' + image + '" >';
            }
            else if (orderDetails.paymentMethod.toLowerCase() == "cash on delivery") {
                image = '{{asset("img/cashondelivery.png")}}';
                payment_method = '<img alt="image" width="100px" src="' + image + '" >';
            }
            else if (orderDetails.paymentMethod.toLowerCase() == "wallet") {
                image = '{{asset("img/wallet.png")}}';
                payment_method = '<img alt="image" width="100px" src="' + image + '" >';

            }
            else {
                payment_method = orderDetails.paymentMethod;
            }


            $("#payment_method").html(payment_method);
            $("#order-status").html(order_status);
            $("#order_time").html(prepare_time);

            var orderDate = orderDetails.createdAt.toDate().toDateString();

            var time = orderDetails.createdAt.toDate().toLocaleTimeString('en-US');

            $("#order-date").html(orderDate + ' ' + time);
            $("#order_date").html(orderDate + ' ' + time);

            var billingAddressstring = '';
            var billingName = '';

            if (orderDetails.user.hasOwnProperty('name')) {
                billingName = orderDetails.user.name;
            }

            $("#billing_name").text(billingName);

            if (orderDetails.hasOwnProperty('address')) {
                $("#billing_line1").text(orderDetails.address.locality);
                $("#shipping_line1").text(orderDetails.address.locality);
            }

            var order_items = order_status = '';

            var order_subtotal = order_shipping = order_total = 0;


            order_items += '<tr>';

            order_items += '<th></th>';

            order_items += '<th class="prod-name">Item Name</th>';

            order_items += '<th class="qunt">Quantity</th>';

            order_items += '<th class="price">Price</th>';

            order_items += '<th class="price text-right">Total</th>';

            order_items += '</tr>';


            for (let i = 0; i < orderDetails.products.length; i++) {

                var extra_html = '';
                if(orderDetails.products[i]['discountPrice']!='0' && parseFloat(orderDetails.products[i]['discountPrice'])!=0 &&  parseFloat(orderDetails.products[i]['discountPrice']) != null &&  parseFloat(orderDetails.products[i]['discountPrice'])!='' ){
                   order_subtotal = order_subtotal + parseFloat(orderDetails.products[i]['discountPrice']) * parseFloat(orderDetails.products[i]['quantity']);
                    var products_price = parseFloat(orderDetails.products[i]['discountPrice']);
                }else{
                    order_subtotal = order_subtotal + parseFloat(orderDetails.products[i]['price']) * parseFloat(orderDetails.products[i]['quantity']);
                    var products_price = parseFloat(orderDetails.products[i]['price']);

                }

                var productPriceTotal = order_subtotal;
                
                
                productPriceTotal_val = "";

                if (currencyAtRight) {
                    products_price = parseFloat(products_price).toFixed(decimal_degits) + "" + currentCurrency;
                    productPriceTotal_val = parseFloat(productPriceTotal).toFixed(decimal_degits) + "" + currentCurrency;

                } else {
                    products_price = currentCurrency + "" + parseFloat(products_price).toFixed(decimal_degits);
                    productPriceTotal_val = currentCurrency + "" + parseFloat(productPriceTotal).toFixed(decimal_degits);

                }
                order_items += '<tr>';
                if (orderDetails.products[i]['photo'] != '') {
                    if (orderDetails.products[i]['photo']) {
                        photo = orderDetails.products[i]['photo'];
                    } else {
                        photo = place_image;
                    }
                    order_items += '<td class="ord-photo"><img alt="#" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + place_image + '\'" class="img-fluid order_img rounded"></td>';
                } else {
                    order_items += '<td class="ord-photo"><img alt="#" src="' + place_image + '" class="img-fluid order_img rounded"></td>';
                }

                var variant_info = '';
                if (orderDetails.products[i]['variant_info']) {
                    variant_info += '<div class="variant-info">';
                    variant_info += '<ul>';
                    $.each(orderDetails.products[i]['variant_info']['variant_options'], function (label, value) {
                        variant_info += '<li class="variant"><span class="label">' + label + '</span><span class="value">' + value + '</span></li>';
                    });
                    variant_info += '</ul>';
                    variant_info += '</div>';
                }

                order_items += '<td class="prod-name">' + orderDetails.products[i]['name'] + '<div class="extra"><span class="ext-item">' + variant_info + '</span></div></td>';

                order_items += '<td class="qunt">x ' + orderDetails.products[i]['quantity'] + '</td>';

                order_items += '<td class="product_price">' + products_price + '</td>';

                order_items += '<td class="total_product_price text-right">' + productPriceTotal_val + '</td>';

                order_items += '</tr>';


            }

            order_number = orderDetails['id'];
            if (orderDetails.hasOwnProperty('deliveryCharge') && orderDetails.deliveryCharge) {
                order_shipping = orderDetails.deliveryCharge;
            }


            order_status = orderDetails['status'];
            var discount = orderDetails['coupon']['discount'];
            var discountType = orderDetails['coupon']['discountType'];
            if (discountType != "" && discountType != null && discountType != undefined) {
                order_discount = discount;
            } else {
                order_discount = 0;
            }


            var order_subtotal_main = order_subtotal;

            if (discountType == "Percentage") {
                for (let i = 0; i < orderDetails.products.length; i++) {
                    var dis = (parseFloat(order_subtotal) * parseFloat(order_discount)) / 100;
                    order_subtotal = (parseFloat(order_subtotal) - parseFloat(dis));
                    order_discount = dis;
                }
            } else {
                order_subtotal = (parseFloat(order_subtotal) - parseFloat(order_discount));
            }

            tax = 0;
            taxlabel = '';
            taxlabeltype = '';
            var total_tax_amount = 0;

            if (orderDetails.hasOwnProperty('tax') && orderDetails.tax != null && orderDetails.tax != '') {
                if (orderDetails.tax.length > 0) {
                    for (var i = 0; i < orderDetails.tax.length; i++) {
                        var data = orderDetails.tax[i];

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {

                                tax = (parseFloat(data.tax) * order_subtotal) / 100;
                                taxlabeltype = "%";
                                var taxvalue = data.tax;

                            } else {
                                tax = parseFloat(data.tax);
                                taxlabeltype = "";
                                if (currencyAtRight) {
                                    var taxvalue = parseFloat(data.tax).toFixed(decimal_degits) + "" + currentCurrency;
                                } else {
                                    var taxvalue = currentCurrency + "" + parseFloat(data.tax).toFixed(decimal_degits);

                                }

                            }
                            taxlabel = data.title;
                        }

                        total_tax_amount += parseFloat(tax);

                        if (!isNaN(tax) && tax != 0) {
                            $(".order_tax_div").removeClass('d-none');

                            if (currencyAtRight) {

                                $("#order-tax").append("<div class='d-flex align-items-center mb-2'><h6 class='font-weight-bold mb-1'>" + taxlabel + " (" + taxvalue + taxlabeltype + ")</h6><h6 class='font-weight-bold mb-1 ml-auto'>" + parseFloat(tax).toFixed(decimal_degits) + '' + currentCurrency + "</h6></div>");
                            } else {
                                $("#order-tax").append('<div class="d-flex align-items-center mb-2"><h6 class="font-weight-bold  mb-1">' + taxlabel + ' (' + taxvalue + taxlabeltype + ')</h6><h6 class="font-weight-bold mb-1 ml-auto">' + currentCurrency + parseFloat(tax).toFixed(decimal_degits) + '</h6></div>');
                            }


                        }
                    }
                }
            }
            order_total = order_subtotal + parseFloat(order_shipping) + parseFloat(total_tax_amount);

            order_total_val = "";
            order_subtotal_val = "";
            order_discount_val = "";
            order_shipping_val = "";

            if (order_discount == null || order_discount == "" || order_discount == NaN) {
                order_discount = 0;
            }


            if (currencyAtRight) {
                order_total_val = parseFloat(order_total).toFixed(decimal_degits) + "" + currentCurrency;
                order_subtotal_val = parseFloat(order_subtotal).toFixed(decimal_degits) + "" + currentCurrency;
                order_subtotal_main = parseFloat(order_subtotal_main).toFixed(decimal_degits) + "" + currentCurrency;
                order_shipping_val = parseFloat(order_shipping).toFixed(decimal_degits) + "" + currentCurrency;
                order_discount_val = parseFloat(order_discount).toFixed(decimal_degits) + "" + currentCurrency;


            } else {
                order_total_val = currentCurrency + "" + parseFloat(order_total).toFixed(decimal_degits);
                order_subtotal_val = currentCurrency + "" + parseFloat(order_subtotal).toFixed(decimal_degits);
                order_subtotal_main = currentCurrency + "" + parseFloat(order_subtotal_main).toFixed(decimal_degits);
                order_shipping_val = currentCurrency + "" + parseFloat(order_shipping).toFixed(decimal_degits);
                order_discount_val = currentCurrency + "" + parseFloat(order_discount).toFixed(decimal_degits);

            }

            $("#order-number").html(order_number);

            $("#order-items").html('<table class="order-list">' + order_items + '</table>');

            $("#order-subtotal").html(order_subtotal_main);

            $("#order-shipping").html(order_shipping_val);

            $("#order-discount").html("(-" + order_discount_val + ")");


            if (orderDetails.hasOwnProperty('couponCode') && orderDetails.couponCode != '') {
                $('.used_coupon_code_div').show();
                $("#used_coupon_code").html(orderDetails.couponCode);
            }

            $("#order-total").append(order_total_val);

            $("#order-type").html("Delivery");
            var order_restaurant = '<tr>';
            var restaurantImage = orderDetails.vendor.photo;

            if (restaurantImage == '') {
                restaurantImage = place_image;
            }
            $('.resturant-img').attr('src', restaurantImage);

            if (orderDetails.vendor.title) {
                $('.restaurant-title').html('<a class="row redirecttopage" id="resturant-view">' + orderDetails.vendor.title + '</a>');
            }

            if (orderDetails.vendor.phonenumber) {
                $('#restaurant_phone').text(orderDetails.vendor.phonenumber);
            }

            if (orderDetails.vendor.location) {
                $('#restaurant_address').text(orderDetails.vendor.location);
            }

            if (orderDetails.hasOwnProperty('driver') && orderDetails.driver!=null) {
                $(".driver_details").show();
                var driverImage = orderDetails.driver.profilePictureURL;
                if (driverImage == '') {
                    driverImage = place_image;
                }
                var dname = orderDetails.driver.name;


                $('.driver-img').attr('src', driverImage);

                if (dname) {
                    $('.driver-name-title').html(dname);
                    $('#driver_name').text(dname);
                }

                if (orderDetails.driver.phoneNumber) {
                    $('#driver_phoneno').text(orderDetails.driver.phoneNumber);
                }

                if (orderDetails.driver.email) {
                    $('#driver_email').text(orderDetails.driver.email);
                }


                if (orderDetails.driver.carNumber) {
                    $('#driver_car_number').text(orderDetails.driver.carNumber);
                }

            }
            else {
                $(".driver_details").hide();
            }

            if (!orderDetails.driver) {
                $("#order_driver_details").hide();
            }


            if (orderDetails.notes) {
                $("#order-note-box").show();
                $("#order-note").html(orderDetails.notes);
            }

        })

    }


</script>