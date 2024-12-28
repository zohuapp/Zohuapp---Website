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


<div class="d-none">

    <div class="bg-primary border-bottom p-3 d-flex align-items-center">

        <a class="toggle togglew toggle-2" href="#"><span></span></a>

        <h4 class="font-weight-bold m-0 text-white">{{trans('lang.my_orders')}}</h4>

    </div>

</div>

<section class="py-4 siddhi-main-body">
    <input type="hidden" name="deliveryChargeMain" id="deliveryChargeMain">
    <div class="container">

        <div class="row">

            <div class="col-md-12 top-nav mb-3">

                <ul class="nav nav-tabsa custom-tabsa border-0 bg-white rounded overflow-hidden shadow-sm p-2 c-t-order"
                    id="myTab" role="tablist">


                    <li class="nav-item" role="presentation">

                        <a class="nav-link border-0 text-dark py-3 active" id="all-tab" data-toggle="tab" href="#all"
                            role="tab" aria-controls="all" aria-selected="true">

                            <i class="feather-list mr-2 text-success mb-0"></i> {{trans('lang.all')}}</a>

                    </li>

                    <li class="nav-item border-top" role="presentation">

                        <a class="nav-link border-0 text-dark py-3" id="progress-tab" data-toggle="tab" href="#progress"
                            role="tab" aria-controls="progress" aria-selected="false">

                            <i class="feather-clock mr-2 text-warning mb-0"></i> {{trans('lang.on_progress')}}</a>

                    </li>


                    <li class="nav-item" role="presentation">

                        <a class="nav-link border-0 text-dark py-3" id="intransit-tab" data-toggle="tab"
                            href="#intransit" role="tab" aria-controls="intransit" aria-selected="false">

                            <i class="feather-clock mr-2 text-success mb-0"></i> {{trans('lang.intransit')}}</a>

                    </li>


                    <li class="nav-item border-top" role="presentation">

                        <a class="nav-link border-0 text-dark py-3" id="delivered-tab" data-toggle="tab"
                            href="#delivered" role="tab" aria-controls="delivered" aria-selected="false">

                            <i class="feather-check mr-2 text-success mb-0"></i> {{trans('lang.delivered')}}</a>

                    </li>

                </ul>

            </div>

            <div class="tab-content col-md-12" id="myTabContent">

                <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">

                    <div class="order-body">

                        <div id="all_orders"></div>


                    </div>

                </div>


                <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">

                    <div class="order-body">

                        <div id="pending_orders"></div>


                    </div>

                </div>

                <div class="tab-pane fade" id="intransit" role="tabpanel" aria-labelledby="intransit-tab">

                    <div class="order-body">

                        <div id="intransit_orders"></div>


                    </div>

                </div>

                <div class="tab-pane fade" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">

                    <div class="order-body">

                        <div id="delivered_orders"></div>


                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


@include('layouts.footer')


@include('layouts.nav')


<script type="text/javascript">

    cityToCountry = '<?php echo json_encode($countriesJs);?>';

    cityToCountry = JSON.parse(cityToCountry);
    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    userCity = userTimeZone.split('/')[1];
    userCountry = cityToCountry[userCity];

    var append_categories = '';

    var completedorsersref = database.collection('orders').where("userID", "==", user_uuid).orderBy('createdAt', 'desc');
    var deliveryCharge = 0;

    var deliveryChargeRef = database.collection('settings').doc('DeliveryCharge');

    deliveryChargeRef.get().then(async function (deliveryChargeSnapshots) {

        var deliveryChargeData = deliveryChargeSnapshots.data();
        deliveryCharge = deliveryChargeData.amount;
        $("#deliveryChargeMain").val(deliveryCharge);
    });

    var placeholderImage = '';
    var ref_placeholder_image = database.collection('settings').doc("placeHolderImage");
    ref_placeholder_image.get().then(async function (snapshots) {
        var placeimg = snapshots.data();
        placeholderImage = placeimg.image;
    });

    var taxSetting = [];
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

    $(document).ready(function () {
        getOrders();
        $(document).on("click", '.reorder-add-to-cart', function (event) {

            var order_id = $(this).attr('data-id');
            var item = [];

            jQuery(".order_" + order_id).each(function () {

                var id = jQuery(this).find('.product_id').val();
                var name = jQuery(this).find('.name').val();
                var price = jQuery(this).find('.price').val();
                var image = jQuery(this).find('.image').val();
                var quantity = jQuery(this).find('.quantity').val();
                var extra_price = jQuery(this).find('.extra_price').val();
                var extra = jQuery(this).find('.extra').val();
                var size = jQuery(this).find('.size').val();
                var item_price = jQuery(this).find('.item_price').val();

                var item_arr = {
                    'id': id,
                    'name': name,
                    'image': image,
                    'price': price,
                    'quantity': quantity,
                    'extra_price': extra_price,
                    'extra': extra,
                    'size': size,
                    'item_price': item_price,
                }
                item.push(item_arr);

            });
            var restaurant_id = jQuery(".restid_" + order_id).val();
            var restaurant_name = jQuery(".resttitle_" + order_id).val();
            var restaurant_location = jQuery(".restlocation_" + order_id).val();
            var restaurant_image = jQuery(".restphoto_" + order_id).val();
            var delivery_option = '<?php  echo $delivery_option = "delivery"; ?>';
            var deliveryCharge = $("#deliveryChargeMain").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo route('reorder-add-to-cart'); ?>",
                data: {
                    _token: '<?php echo csrf_token(); ?>',
                    restaurant_id: restaurant_id,
                    restaurant_location: restaurant_location,
                    restaurant_name: restaurant_name,
                    restaurant_image: restaurant_image,
                    item: item,
                    deliveryCharge: deliveryCharge,
                    delivery_option: delivery_option,
                    taxValue: taxSetting,
                    decimal_degits: decimal_degits
                },
                success: function (data) {
                    window.location.href = '{{ route("checkout")}}';
                }

            });
        });


    });


    async function getOrders() {


        completedorsersref.get().then(async function (completedorderSnapshots) {

            all_orders = document.getElementById('all_orders'); //all self create

            delivered_orders = document.getElementById('delivered_orders'); //delivered

            pending_orders = document.getElementById('pending_orders'); //inprogress

            intransit_orders = document.getElementById('intransit_orders'); // rejected


            all_orders.innerHTML = '';

            pending_orders.innerHTML = '';

            intransit_orders.innerHTML = '';

            delivered_orders.innerHTML = '';

            allOrderHtml = buildHTMLAllOrders(completedorderSnapshots);

            pendingOrderHtml = buildHTMLPendingOrders(completedorderSnapshots);

            intransitOrdersHtml = buildHTMLInTransitOrders(completedorderSnapshots);

            deliveredOrderHtml = buildHTMLCompletedOrders(completedorderSnapshots);

            if (allOrderHtml != '') {
                all_orders.innerHTML = allOrderHtml;
            } else {
                all_orders.innerHTML = '<div class="no-result"><img src="{{asset('img/no-result.png')}}"></div>';
            }

            if (pendingOrderHtml != '') {
                pending_orders.innerHTML = pendingOrderHtml;

            } else {
                pending_orders.innerHTML = '<div class="no-result"><img src="{{asset('img/no-result.png')}}"></div>';
            }
            if (intransitOrdersHtml != '') {
                intransit_orders.innerHTML = intransitOrdersHtml;

            } else {
                intransit_orders.innerHTML = '<div class="no-result"><img src="{{asset('img/no-result.png')}}"></div>';
            }
            if (deliveredOrderHtml != '') {
                delivered_orders.innerHTML = deliveredOrderHtml;

            } else {
                delivered_orders.innerHTML = '<div class="no-result"><img src="{{asset('img/no-result.png')}}"></div>';

            }

        })

    }

    function buildHTMLAllOrders(completedorderSnapshots) {

        var html = '';

        var alldata = [];

        var number = [];

        completedorderSnapshots.docs.forEach((listval) => {

            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);

        });



        alldata.forEach((listval) => {


            var val = listval;

            if (val.status == "InProcess" || val.status == "InTransit" || val.status == "Delivered") {

                var order_id = val.id;

                var view_details;

                if (val.status == "InProcess") {
                    view_details = "{{ route('pending_order', ':id')}}";
                }
                else if (val.status == "InTransit") {
                    view_details = "{{ route('intransit_order', ':id')}}";
                }
                else {
                    view_details = "{{ route('completed_order', ':id')}}";
                }


                view_details = view_details.replace(':id', 'id=' + order_id);

                var orderDetails = "{{ route('orderDetails', ':id')}}";

                orderDetails = orderDetails.replace(':id', 'id=' + order_id);

                var view_contact = "{{ route('contact_us')}}";

                var view_checkout = "{{ route('checkout')}}";

                var orderImage = '';

                if (val.products[0].hasOwnProperty('photo') && val.products[0].photo != '') {
                    orderImage = val.products[0].photo;
                } else {

                    orderImage = placeholderImage;
                }
                var bg_color = ' ';
                var otp = '';

                if (val.status == 'InProcess') {
                    bg_color = 'bg-pending';
                    otp = val.otp;


                }
                else if (val.status == 'InTransit') {
                    bg_color = 'bg-pending';
                    otp = val.otp;

                }
                else {
                    bg_color = 'bg-success';
                }

                var adrs = '';
                if(val.hasOwnProperty('address')){
                    adrs = val.address.locality;
                }

                html = html + '<div class="pb-3"><div class="p-3 rounded shadow-sm bg-white"><div class="d-flex border-bottom pb-3 m-d-flex"><div class="text-muted mr-3"><img alt="#" src="' + orderImage + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-fluid order_img rounded"></div><div><p class="mb-0 font-weight-bold"><a class="text-dark">' + val.products[0].name + '</a></p><p class="mb-0"><span class="fa fa-map-marker"></span> ' + adrs + '</p><p>ORDER ' + val.id + '</p><p class="mb-0 small view-det"><a href="' + view_details + '">View Details</a></p></div><div class="ml-auto ord-com-btn"><p class="' + bg_color + ' text-white py-1 px-2 rounded small mb-1">' + val.status + '</p><p class="small font-weight-bold text-center"><i class="feather-clock"></i> ' + val.createdAt.toDate().toDateString() + '</p>';
                if (val.status == 'InTransit') {
                    html = html + '<p class="small font-weight-bold text-center otp-box badge badge-danger py-2 px-3">OTP : ' + otp + '</p></div></div><div class="d-flex pt-3 m-d-flex"><div class="small">';
                }
                else if (val.status == 'InProcess') {
                    html = html + '<p class="small font-weight-bold text-center otp-box badge badge-danger py-2 px-3">OTP : ' + otp + '</p></div></div><div class="d-flex pt-3 m-d-flex"><div class="small">';
                }
                else {
                    html = html + '</div></div><div class="d-flex pt-3 m-d-flex"><div class="small">';
                }

                var price = 0;

                var order_subtotal = order_shipping = order_total = tip_amount = 0;

                quan = val.products.length;

                html = html + '<p class="text- font-weight-bold mb-0" id="pen_quan">' + quan + " items" + '</p>';
               
                for (let i = 0; i < val.products.length; i++) {
                  
                    if (val.products[i]['discountPrice'] != '0' && parseFloat(val.products[i]['discountPrice']) != 0 && parseFloat(val.products[i]['discountPrice']) != null && parseFloat(val.products[i]['discountPrice']) != '') {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['discountPrice']) * parseFloat(val.products[i]['quantity']);
                    } else {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['price']) * parseFloat(val.products[i]['quantity']);

                    }

                    var productPriceTotal = order_subtotal;

                    price = price + order_subtotal;

                    html = html + '<div class="order_' + String(order_id) + '">';
                    html = html + '<input type="hidden" class="product_id" value="' + String(val.products[i]['id']) + '">';
                    html = html + '<input type="hidden" class="name" value="' + String(val.products[i]['name']) + '">';
                    html = html + '<input type="hidden" class="image" value="' + String(val.products[i]['photo']) + '">';

                    html = html + '<input type="hidden" class="price" value="' + parseFloat(val.products[i]['price']) + '">';

                    html = html + '<input type="hidden" class="quantity" value="' + parseFloat(val.products[i]['quantity']) + '">';



                    html = html + '<input type="hidden" class="item_price" value="' + parseFloat(val.products[i]['price']) + '">';



                    html = html + '</div>';

                }

                var discount = val['coupon']['discount'];
                var discountType = val['coupon']['discountType'];

                if (discountType != "" && discountType != null && discountType != undefined) {
                    order_discount = discount;
                } else {
                    order_discount = 0;
                }

                if (discountType == "Percentage") {
                    for (let i = 0; i < val.products.length; i++) {
                        var dis = (parseFloat(order_subtotal) * parseFloat(order_discount)) / 100;
                        order_subtotal = (parseFloat(order_subtotal) - parseFloat(dis));
                    }
                } else {
                    order_subtotal = (parseFloat(order_subtotal) - parseFloat(order_discount));
                }
                tax = 0;
                var total_tax_amount = 0;

                if (val.hasOwnProperty('tax')) {
                    for (var i = 0; i < val.tax.length; i++) {
                        var data = val.tax[i];

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {
                                tax = (parseFloat(data.tax) * order_subtotal) / 100;
                                taxlabeltype = "%";
                            } else {
                                tax = parseFloat(data.tax);
                                taxlabeltype = "fix";
                            }
                            taxlabel = data.title;
                        }
                        total_tax_amount += parseFloat(tax);
                    }
                }
                if (val.hasOwnProperty('deliveryCharge') && val.deliveryCharge && val.deliveryCharge != null) {
                    if (val.deliveryCharge) {
                        order_shipping = val.deliveryCharge;
                    } else {
                        order_shipping = 0;
                    }
                } else {
                    order_shipping = 0;
                }

                order_total = order_subtotal + parseFloat(order_shipping) + parseFloat(total_tax_amount);

                var order_total_val = '';
                if (currencyAtRight) {
                    order_total_val = parseFloat(order_total).toFixed(decimal_degits) + '' + currentCurrency;
                } else {
                    order_total_val = currentCurrency + '' + parseFloat(order_total).toFixed(decimal_degits);
                }


                html = html + '<input type="hidden" class="restid_' + String(order_id) + '" value="' + val.vendor.id + '">';
                html = html + '<input type="hidden" class="resttitle_' + String(order_id) + '" value="' + val.vendor.title + '">';
                html = html + '<input type="hidden" class="restlocation_' + String(order_id) + '" value="' + val.vendor.location + '">';
                html = html + '<input type="hidden" class="restphoto_' + String(order_id) + '" value="' + val.vendor.photo + '">';
                html = html + '<input type="hidden" class="deliveryCharge_' + String(order_id) + '" value="' + deliveryCharge + '">';

                html = html + '</div><div class="text-muted m-0 ml-auto mr-3 small">Total Payment<br><span class="text-dark font-weight-bold">' + order_total_val + '</span></div> <div class="text-right"><a href="' + view_contact + '" class="btn btn-outline-primary px-3">Help</a> </div></div></div></div></div></div>';

            }

        });


        return html;

    }


    function buildHTMLCompletedOrders(completedorderSnapshots) {

        var html = '';

        var alldata = [];

        var number = [];

        completedorderSnapshots.docs.forEach((listval) => {

            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);

        });

        alldata.forEach((listval) => {

            var quan = 0;


            var val = listval;


            if (val.status == "Delivered") {

                var order_id = val.id;

                var view_details = "{{ route('completed_order', ':id')}}";

                view_details = view_details.replace(':id', 'id=' + order_id);

                var orderDetails = "{{ route('orderDetails', ':id')}}";

                orderDetails = orderDetails.replace(':id', 'id=' + order_id);

                var view_contact = "{{ route('contact_us')}}";

                var view_checkout = "{{ route('checkout')}}";

                var orderImage = '';

                if (val.products[0].hasOwnProperty('photo') && val.products[0].photo != '') {
                    orderImage = val.products[0].photo;
                } else {

                    orderImage = placeholderImage;
                }

                var adrs = '';
                if(val.hasOwnProperty('address')){
                    adrs = val.address.locality;
                }

                html = html + '<div class="pb-3"><div class="p-3 rounded shadow-sm bg-white"><div class="d-flex border-bottom pb-3 m-d-flex"><div class="text-muted mr-3"><img alt="#" src="' + orderImage + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-fluid order_img rounded"></div><div><p class="mb-0 font-weight-bold"><a class="text-dark">' + val.products[0].name + '</a></p><p class="mb-0"><span class="fa fa-map-marker"></span> ' + adrs + '</p><p>ORDER ' + val.id + '</p><p class="mb-0 small view-det"><a href="' + view_details + '">View Details</a></p></div><div class="ml-auto ord-com-btn"><p class="bg-success text-white py-1 px-2 rounded small mb-1">' + val.status + '</p><p class="small font-weight-bold text-center"><i class="feather-clock"></i> ' + val.createdAt.toDate().toDateString() + '</p></div></div><div class="d-flex pt-3 m-d-flex"><div class="small">';

                var price = 0;

                var order_subtotal = order_shipping = order_total = tip_amount = 0;

                quan = val.products.length;

                html = html + '<p class="text- font-weight-bold mb-0" id="pen_quan">' + quan + " items" + '</p>';

                for (let i = 0; i < val.products.length; i++) {
                    if (val.products[i]['discountPrice'] != '0' && parseFloat(val.products[i]['discountPrice']) != 0 && parseFloat(val.products[i]['discountPrice']) != null && parseFloat(val.products[i]['discountPrice']) != '') {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['discountPrice']) * parseFloat(val.products[i]['quantity']);
                    } else {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['price']) * parseFloat(val.products[i]['quantity']);

                    }

                    var productPriceTotal = order_subtotal;

                    price = price + order_subtotal;

                    html = html + '<div class="order_' + String(order_id) + '">';
                    html = html + '<input type="hidden" class="product_id" value="' + String(val.products[i]['id']) + '">';
                    html = html + '<input type="hidden" class="name" value="' + String(val.products[i]['name']) + '">';
                    html = html + '<input type="hidden" class="image" value="' + String(val.products[i]['photo']) + '">';

                    html = html + '<input type="hidden" class="price" value="' + parseFloat(val.products[i]['price']) + '">';

                    html = html + '<input type="hidden" class="quantity" value="' + parseFloat(val.products[i]['quantity']) + '">';



                    html = html + '<input type="hidden" class="item_price" value="' + parseFloat(val.products[i]['price']) + '">';



                    html = html + '</div>';

                }

                var discount = val['coupon']['discount'];
                var discountType = val['coupon']['discountType'];

                if (discountType != "" && discountType != null && discountType != undefined) {
                    order_discount = discount;
                } else {
                    order_discount = 0;
                }

                if (discountType == "Percentage") {
                    for (let i = 0; i < val.products.length; i++) {
                        var dis = (parseFloat(order_subtotal) * parseFloat(order_discount)) / 100;
                        order_subtotal = (parseFloat(order_subtotal) - parseFloat(dis));
                    }
                } else {
                    order_subtotal = (parseFloat(order_subtotal) - parseFloat(order_discount));
                }
                tax = 0;
                var total_tax_amount = 0;

                if (val.hasOwnProperty('tax')) {
                    for (var i = 0; i < val.tax.length; i++) {
                        var data = val.tax[i];

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {
                                tax = (parseFloat(data.tax) * order_subtotal) / 100;
                                taxlabeltype = "%";
                            } else {
                                tax = parseFloat(data.tax);
                                taxlabeltype = "fix";
                            }
                            taxlabel = data.title;
                        }
                        total_tax_amount += parseFloat(tax);
                    }
                }
                if (val.hasOwnProperty('deliveryCharge') && val.deliveryCharge && val.deliveryCharge != null) {
                    if (val.deliveryCharge) {
                        order_shipping = val.deliveryCharge;
                    } else {
                        order_shipping = 0;
                    }
                } else {
                    order_shipping = 0;
                }

                order_total = order_subtotal + parseFloat(order_shipping) + parseFloat(total_tax_amount);

                var order_total_val = '';
                if (currencyAtRight) {
                    order_total_val = parseFloat(order_total).toFixed(decimal_degits) + '' + currentCurrency;
                } else {
                    order_total_val = currentCurrency + '' + parseFloat(order_total).toFixed(decimal_degits);
                }

                html = html + '<input type="hidden" class="restid_' + String(order_id) + '" value="' + val.vendor.id + '">';
                html = html + '<input type="hidden" class="resttitle_' + String(order_id) + '" value="' + val.vendor.title + '">';
                html = html + '<input type="hidden" class="restlocation_' + String(order_id) + '" value="' + val.vendor.location + '">';
                html = html + '<input type="hidden" class="restphoto_' + String(order_id) + '" value="' + val.vendor.photo + '">';
                html = html + '<input type="hidden" class="deliveryCharge_' + String(order_id) + '" value="' + deliveryCharge + '">';

                html = html + '</div><div class="text-muted m-0 ml-auto mr-3 small">Total Payment<br><span class="text-dark font-weight-bold">' + order_total_val + '</span></div> <div class="text-right"><a href="' + view_contact + '" class="btn btn-outline-primary px-3">Help</a> </div></div></div></div></div></div>';

            }

        });


        return html;

    }

    function buildHTMLPendingOrders(completedorderSnapshots) {

        var html = '';

        var alldata = [];

        var number = [];

        completedorderSnapshots.docs.forEach((listval) => {

            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);

        });


        alldata.forEach((listval) => {

            var quan = 0;

            var val = listval;

            var order_id = val.id;

            var view_details = "{{ route('pending_order', ':id')}}";

            view_details = view_details.replace(':id', 'id=' + order_id);

            var view_checkout = "{{ route('checkout')}}";

            var view_contact = "{{ route('contact_us')}}";

            if (val.status == "InProcess") {

                var orderImage = '';
                if (val.products[0].hasOwnProperty('photo') && val.products[0].photo != '') {
                    orderImage = val.products[0].photo;
                } else {
                    orderImage = placeholderImage;
                }

                var adrs = '';
                if(val.hasOwnProperty('address')){
                    adrs = val.address.locality;
                }

                html = html + '<div class="pb-3"><div class="p-3 rounded shadow-sm bg-white"><div class="d-flex border-bottom pb-3 m-d-flex"><div class="text-muted mr-3"><img alt="#" src="' + orderImage + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-fluid order_img rounded"></div><div><p class="mb-0 font-weight-bold"><a class="text-dark">' + val.products[0].name + '</a></p><p class="mb-0"><span class="fa fa-map-marker"></span> ' + adrs + '</p><p>ORDER ' + val.id + '</p><p class="mb-0 small view-det"><a href="' + view_details + '">View Details</a></p></div><div class="ml-auto ord-com-btn"><p class="bg-pending text-white py-1 px-2 rounded small mb-1">' + val.status + '</p><p class="small font-weight-bold text-center"><i class="feather-clock"></i> ' + val.createdAt.toDate().toDateString() + '</p><p class="small font-weight-bold text-center badge badge-danger py-2 px-3">OTP : ' + val.otp + '</p></div></div><div class="d-flex pt-3 m-d-flex"><div class="small">';

                var price = 0;

                var order_subtotal = order_shipping = order_total = tip_amount = 0;

                quan = val.products.length;

                html = html + '<p class="text- font-weight-bold mb-0" id="pen_quan">' + quan + " items" + '</p>';

                for (let i = 0; i < val.products.length; i++) {


                    if (val.products[i]['discountPrice'] != '0' && parseFloat(val.products[i]['discountPrice']) != 0 && parseFloat(val.products[i]['discountPrice']) != null && parseFloat(val.products[i]['discountPrice']) != '') {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['discountPrice']) * parseFloat(val.products[i]['quantity']);
                    } else {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['price']) * parseFloat(val.products[i]['quantity']);

                    }

                    var productPriceTotal = order_subtotal;

                    price = price + order_subtotal;

                    html = html + '<div class="order_' + String(order_id) + '">';
                    html = html + '<input type="hidden" class="product_id" value="' + String(val.products[i]['id']) + '">';
                    html = html + '<input type="hidden" class="name" value="' + String(val.products[i]['name']) + '">';
                    html = html + '<input type="hidden" class="image" value="' + String(val.products[i]['photo']) + '">';

                    html = html + '<input type="hidden" class="price" value="' + parseFloat(val.products[i]['price']) + '">';

                    html = html + '<input type="hidden" class="quantity" value="' + parseFloat(val.products[i]['quantity']) + '">';



                    html = html + '<input type="hidden" class="item_price" value="' + parseFloat(val.products[i]['price']) + '">';



                    html = html + '</div>';

                }

                var discount = val['coupon']['discount'];
                var discountType = val['coupon']['discountType'];

                if (discountType != "" && discountType != null && discountType != undefined) {
                    order_discount = discount;
                } else {
                    order_discount = 0;
                }

                if (discountType == "Percentage") {
                    for (let i = 0; i < val.products.length; i++) {
                        var dis = (parseFloat(order_subtotal) * parseFloat(order_discount)) / 100;
                        order_subtotal = (parseFloat(order_subtotal) - parseFloat(dis));
                    }
                } else {
                    order_subtotal = (parseFloat(order_subtotal) - parseFloat(order_discount));
                }
                tax = 0;
                var total_tax_amount = 0;

                if (val.hasOwnProperty('tax')) {
                    for (var i = 0; i < val.tax.length; i++) {
                        var data = val.tax[i];

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {
                                tax = (parseFloat(data.tax) * order_subtotal) / 100;
                                taxlabeltype = "%";
                            } else {
                                tax = parseFloat(data.tax);
                                taxlabeltype = "fix";
                            }
                            taxlabel = data.title;
                        }
                        total_tax_amount += parseFloat(tax);
                    }
                }
                if (val.hasOwnProperty('deliveryCharge') && val.deliveryCharge && val.deliveryCharge != null) {
                    if (val.deliveryCharge) {
                        order_shipping = val.deliveryCharge;
                    } else {
                        order_shipping = 0;
                    }
                } else {
                    order_shipping = 0;
                }

                order_total = order_subtotal + parseFloat(order_shipping) + parseFloat(total_tax_amount);

                var order_total_val = '';
                if (currencyAtRight) {
                    order_total_val = parseFloat(order_total).toFixed(decimal_degits) + '' + currentCurrency;
                } else {
                    order_total_val = currentCurrency + '' + parseFloat(order_total).toFixed(decimal_degits);
                }


                html = html + '<input type="hidden" class="restid_' + String(order_id) + '" value="' + val.vendor.id + '">';
                html = html + '<input type="hidden" class="resttitle_' + String(order_id) + '" value="' + val.vendor.title + '">';
                html = html + '<input type="hidden" class="restlocation_' + String(order_id) + '" value="' + val.vendor.location + '">';
                html = html + '<input type="hidden" class="restphoto_' + String(order_id) + '" value="' + val.vendor.photo + '">';
                html = html + '<input type="hidden" class="deliveryCharge_' + String(order_id) + '" value="' + deliveryCharge + '">';

                html = html + '</div><div class="text-muted m-0 ml-auto mr-3 small">Total Payment<br><span class="text-dark font-weight-bold">' + order_total_val + '</span></div> <div class="text-right"><a href="' + view_contact + '" class="btn btn-outline-primary px-3">Help</a></div></div></div></div></div></div>';

            }


        });


        return html;

    }

    function buildHTMLInTransitOrders(completedorderSnapshots) {

        var html = '';

        var alldata = [];

        var number = [];

        completedorderSnapshots.docs.forEach((listval) => {

            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);

        });


        alldata.forEach((listval) => {

            var quan = 0;

            var val = listval;

            var order_id = val.id;

            var view_details = "{{ route('intransit_order', ':id')}}";

            view_details = view_details.replace(':id', 'id=' + order_id);

            var view_contact = "{{ route('contact_us')}}";

            var view_checkout = "{{ route('checkout')}}";

            if (val.status == "InTransit") {
                var orderImage = '';
                if (val.products[0].hasOwnProperty('photo') && val.products[0].photo != '') {
                    orderImage = val.products[0].photo;
                } else {
                    orderImage = placeholderImage;
                }

                var adrs = '';
                if(val.hasOwnProperty('address')){
                    adrs = val.address.locality;
                }

                html = html + '<div class="pb-3"><div class="p-3 rounded shadow-sm bg-white"><div class="d-flex border-bottom pb-3 m-d-flex"><div class="text-muted mr-3"><img alt="#" src="' + orderImage + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-fluid order_img rounded"></div><div><p class="mb-0 font-weight-bold"><a class="text-dark">' + val.products[0].name + '</a></p><p class="mb-0"><span class="fa fa-map-marker"></span> ' + adrs + '</p><p>ORDER ' + val.id + '</p><p class="mb-0 small view-det"><a href="' + view_details + '">View Details</a></p></div><div class="ml-auto ord-com-btn"><p class="bg-pending text-white py-1 px-2 rounded small mb-1">' + val.status + '</p><p class="small font-weight-bold text-center"><i class="feather-clock"></i> ' + val.createdAt.toDate().toDateString() + '</p><p class="small font-weight-bold text-center badge badge-danger py-2 px-3">OTP : ' + val.otp + '</p></div></div><div class="d-flex pt-3 m-d-flex"><div class="small">';

                var price = 0;

                var order_subtotal = order_shipping = order_total = tip_amount = 0;

                quan = val.products.length;

                html = html + '<p class="text- font-weight-bold mb-0" id="pen_quan">' + quan + " items" + '</p>';

                for (let i = 0; i < val.products.length; i++) {
                    if (val.products[i]['discountPrice'] != '0' && parseFloat(val.products[i]['discountPrice']) != 0 && parseFloat(val.products[i]['discountPrice']) != null && parseFloat(val.products[i]['discountPrice']) != '') {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['discountPrice']) * parseFloat(val.products[i]['quantity']);
                    } else {
                        order_subtotal = order_subtotal + parseFloat(val.products[i]['price']) * parseFloat(val.products[i]['quantity']);

                    }

                    var productPriceTotal = order_subtotal;

                    price = price + order_subtotal;

                    html = html + '<div class="order_' + String(order_id) + '">';
                    html = html + '<input type="hidden" class="product_id" value="' + String(val.products[i]['id']) + '">';
                    html = html + '<input type="hidden" class="name" value="' + String(val.products[i]['name']) + '">';
                    html = html + '<input type="hidden" class="image" value="' + String(val.products[i]['photo']) + '">';

                    html = html + '<input type="hidden" class="price" value="' + parseFloat(val.products[i]['price']) + '">';

                    html = html + '<input type="hidden" class="quantity" value="' + parseFloat(val.products[i]['quantity']) + '">';



                    html = html + '<input type="hidden" class="item_price" value="' + parseFloat(val.products[i]['price']) + '">';



                    html = html + '</div>';

                }

                var discount = val['coupon']['discount'];
                var discountType = val['coupon']['discountType'];

                if (discountType != "" && discountType != null && discountType != undefined) {
                    order_discount = discount;
                } else {
                    order_discount = 0;
                }

                if (discountType == "Percentage") {
                    for (let i = 0; i < val.products.length; i++) {
                        var dis = (parseFloat(order_subtotal) * parseFloat(order_discount)) / 100;
                        order_subtotal = (parseFloat(order_subtotal) - parseFloat(dis));
                    }
                } else {
                    order_subtotal = (parseFloat(order_subtotal) - parseFloat(order_discount));
                }
                tax = 0;
                var total_tax_amount = 0;

                if (val.hasOwnProperty('tax')) {
                    for (var i = 0; i < val.tax.length; i++) {
                        var data = val.tax[i];

                        if (data.type && data.tax) {
                            if (data.type == "percentage") {
                                tax = (parseFloat(data.tax) * order_subtotal) / 100;
                                taxlabeltype = "%";
                            } else {
                                tax = parseFloat(data.tax);
                                taxlabeltype = "fix";
                            }
                            taxlabel = data.title;
                        }
                        total_tax_amount += parseFloat(tax);
                    }
                }
                if (val.hasOwnProperty('deliveryCharge') && val.deliveryCharge && val.deliveryCharge != null) {
                    if (val.deliveryCharge) {
                        order_shipping = val.deliveryCharge;
                    } else {
                        order_shipping = 0;
                    }
                } else {
                    order_shipping = 0;
                }

                order_total = order_subtotal + parseFloat(order_shipping) + parseFloat(total_tax_amount);

                var order_total_val = '';
                if (currencyAtRight) {
                    order_total_val = parseFloat(order_total).toFixed(decimal_degits) + '' + currentCurrency;
                } else {
                    order_total_val = currentCurrency + '' + parseFloat(order_total).toFixed(decimal_degits);
                }

                html = html + '<input type="hidden" class="restid_' + String(order_id) + '" value="' + val.vendor.id + '">';
                html = html + '<input type="hidden" class="resttitle_' + String(order_id) + '" value="' + val.vendor.title + '">';
                html = html + '<input type="hidden" class="restlocation_' + String(order_id) + '" value="' + val.vendor.location + '">';
                html = html + '<input type="hidden" class="restphoto_' + String(order_id) + '" value="' + val.vendor.photo + '">';
                html = html + '<input type="hidden" class="deliveryCharge_' + String(order_id) + '" value="' + deliveryCharge + '">';

                html = html + '</div><div class="text-muted m-0 ml-auto mr-3 small">Total Payment<br><span class="text-dark font-weight-bold">' + order_total_val + '</span></div> <div class="text-right"><a href="' + view_contact + '" class="btn btn-outline-primary px-3">Help</a></div></div></div></div></div></div>';

            }

        });

        return html;

    }


</script>