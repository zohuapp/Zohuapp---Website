@include('layouts.app')

@include('layouts.header')

<div class="siddhi-home-page">

    <div class="bg-primary px-3 d-none mobile-filter pb-3">
        <div class="row align-items-center">
            <div class="input-group rounded shadow-sm overflow-hidden col-md-9 col-sm-9">
                <div class="input-group-prepend">
                    <button class="border-0 btn btn-outline-secondary text-dark bg-white btn-block">
                        <i class="feather-search"></i>
                    </button>
                </div>
                <input type="text" class="shadow-none border-0 form-control" placeholder="Search for vendors or dishes">
            </div>
            <div class="text-white col-md-3 col-sm-3">
                <div class="title d-flex align-items-center">
                    <a class="text-white font-weight-bold ml-auto"
                        href="{{ url('search') }}">{{ trans('lang.filter') }}</a>
                </div>
            </div>

        </div>
    </div>

    <div class="ecommerce-banner multivendor-banner section-content">

        <div class="ecommerce-inner">

            <div id="top_banner"></div>

        </div>
    </div>

    <section class="vendor-offer-section py-5">

        <div class="container section-content">
            <div class="row ltn__custom-gutter justify-content-center">
                <div class="col-lg-6 col-md-6 offer-left">
                    <div class="ltn__banner-item">
                        <div class="hm-offer-content">
                            <h3 class="coupon_description_left"></h3>
                            <span class="offer-price offer-price_left"></span>
                            <a href="{{ route('productlist.all') }}" class="btn btn-primary remove_hover">Shop Now</a>
                        </div>
                        <div class="ltn__banner-img  text-right">
                            <a href="{{ route('productlist.all') }}" class="coupon_image_left"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 ">
                    <div class="row offer-right" id="offer-right">
                    </div>
                </div>
            </div>


        </div>


    </section>

    <div class="ecommerce-content multi-vendore-content section-content">

        <section class="top-categories">

            <div class="container">

                <div class="title d-flex align-items-center text-center justify-content-center">
                    <h3 class="text-white">{{ trans('lang.top_categories') }}</h3>

                </div>

                <div class="row categories" id="append_categories"></div>
            </div>

        </section>


        <section class="popular-section">

            <div class="container">
                <div class="title d-flex mr-auto">
                    <h3>{{ trans('lang.our_products') }}</h3>

                </div>


                <ul class="nav nav-pills" role="tablist" id="item_product_tab">

                </ul>
                <div class="most_popular" id="most_sale1"></div>
            </div>

        </section>
        <section class="most-selling-section">
            <div class="container">

                <div class="title d-flex align-items-center text-center justify-content-center">
                    <h3 class="mr-auto">{{ trans('lang.most_selling_products') }}</h3>
                </div>

                <div class="row most_selling" id="most_selling_product"></div>
            </div>
        </section>


        <section class="middle-banners">

            <div class="container">

                <div class="" id="middle_banner"></div>

            </div>

        </section>
        <section class="home-categories">

            <div class="container" id="home_categories"></div>

        </section>

    </div>

    <div class="zone-error m-5 p-5" style="display: none;">
        <div class="zone-image text-center">
            <img src="{{ asset('img/zone_logo.png') }}" width="100">
        </div>
        <div class="zone-content text-center text-center font-weight-bold text-danger">
            <h3 class="title">{{ trans('lang.zone_error_title') }}</h3>
            <h6 class="text">{{ trans('lang.zone_error_text') }}</h6>
        </div>
    </div>

</div>

@include('layouts.footer')

<!-- lib styles -->
<link rel="stylesheet" href="{{ asset('css/dist/zuck.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/dist/skins/snapssenger.css') }}">
<script src="{{ asset('js/dist/zuck.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('vendor/slick/slick.min.js') }}"></script>

<script type="text/javascript">
    var itemCategoriesref = database.collection('vendor_categories').where('publish', '==', true);

    var bannerref = database.collection('menu_items').where("is_publish", "==", true).orderBy('set_order', 'asc');

    var couponsRef = database.collection('coupons').where('isEnabled', '==', true).orderBy("expiresAt").startAt(
        new Date()).limit(4);

    var couponsList = database.collection('coupons').where('isEnabled', '==', true).limit(3);
    var ordersRef = database.collection('orders');
    var position1_banners = [];
    var position2_banners = [];
    var vendorRadius = '';
    var vendorRadiusRef = database.collection('settings').doc("globalSettings");

    var currentCurrency = '';
    var currencyAtRight = false;
    var refCurrency = database.collection('currencies').where('isActive', '==', true);
    var currencyData = '';
    var decimal_degits = 0;

    refCurrency.get().then(async function(snapshots) {
        currencyData = snapshots.docs[0].data();
        currentCurrency = currencyData.symbol;
        decimal_digit = currencyData.decimal_degits;
        currencyAtRight = currencyData.symbolAtRight;
        if (currencyData.decimal_degits) {
            decimal_degits = currencyData.decimal_degits;
        }
    });

    bannerref.get().then(async function(banners) {

        banners.docs.forEach((banner) => {
            var bannerData = banner.data();
            var redirect_type = '';
            var redirect_id = '';
            if (bannerData.position == 'top') {
                if (bannerData.hasOwnProperty('redirect_type')) {
                    redirect_type = bannerData.redirect_type;
                    redirect_id = bannerData.redirect_id;
                }

                var object = {
                    'photo': bannerData.photo,
                    'redirect_type': redirect_type,
                    'redirect_id': redirect_id,
                };

                position1_banners.push(object);
            }

            if (bannerData.position == 'middle') {

                if (bannerData.hasOwnProperty('redirect_type')) {
                    redirect_type = bannerData.redirect_type;
                    redirect_id = bannerData.redirect_id;
                }
                var object = {
                    'photo': bannerData.photo,
                    'redirect_type': redirect_type,
                    'redirect_id': redirect_id,
                };
                position2_banners.push(object);
            }
        });

        if (position1_banners.length > 0) {
            var html = '';
            var photo = placeholderImage;
            for (banner of position1_banners) {
                html += '<div class="banner-item">';
                html += '<div class="banner-img">';

                var redirect_id = 'javascript::void()';

                if (banner.redirect_type != '') {
                    if (banner.redirect_type == "product") {

                        redirect_id = "{{ route('productDetail', ':id') }}";
                        redirect_id = redirect_id.replace(':id', banner.redirect_id);


                    } else if (banner.redirect_type == "external_link") {
                        redirect_id = banner.redirect_id;
                    }
                }
                if (banner.photo) {
                    photo = banner.photo;
                }

                html += '<a href="' + redirect_id + '"><img src="' + photo +
                    '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></a>';
                html += '</div>';
                html += '</div>';
            }

            $("#top_banner").html(html);
        } else {
            $('.ecommerce-banner').remove();
        }

        if (position2_banners.length > 0) {
            var html = '';
            var photo = placeholderImage;
            for (banner of position2_banners) {
                html += '<div class="banner-item">';
                html += '<div class="banner-img">';

                var redirect_id = 'javascript::void()';
                if (banner.redirect_type != '') {
                    if (banner.redirect_type == "product") {

                        redirect_id = "{{ route('productDetail', ':id') }}";
                        redirect_id = redirect_id.replace(':id', banner.redirect_id);


                    } else if (banner.redirect_type == "external_link") {
                        redirect_id = banner.redirect_id;
                    }
                }
                if (banner.photo) {
                    photo = banner.photo;
                }

                html += '<a href="' + redirect_id + '"><img src="' + photo +
                    '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></a>';
                html += '</div>';
                html += '</div>';
            }
            $("#middle_banner").html(html);

        } else {
            $('.middle-banners').remove();
        }

        slickcatCarousel("banner");
    });

    $(document).ready(async function() {
        $('#overlay').show();

        await vendorRadiusRef.get().then(async function(snapshot) {
            var data = snapshot.data();
            if (data.hasOwnProperty('vendorRadius') && data.vendorRadius != null && data
                .vendorRadius != '') {
                vendorRadius = data.vendorRadius;
            }
        });

        var vendor_lat = getCookie('restaurant_latitude');
        var vendor_long = getCookie('restaurant_longitude');
        var address_lat = getCookie('address_lat');
        var address_lng = getCookie('address_lng');
        if (address_lat != null && address_lat != '' && address_lat != NaN && address_lng != null &&
            address_lng != '' && address_lng != NaN) {

            var distance = await getDistanceFromLatLonInKm(vendor_lat, vendor_long, address_lat,
                address_lng);

            if (distance <= vendorRadius) {

                getItemCategories();
                getCouponsList();
                getHomepageCategory();
                mostSellingProduct();
            } else {
                jQuery(".section-content").remove();
                jQuery(".zone-error").show();
                jQuery("#overlay").hide();
                return false;
            }

        } else {
            jQuery(".section-content").remove();
            jQuery(".zone-error").show();
            jQuery("#overlay").hide();
            return false;
        }



    });

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

    function slickcatCarousel(type, countProducts = 0) {

        if (type == "banner") {
            if ($("#top_banner").html() != "") {
                $('#top_banner').slick({
                    slidesToShow: 1,
                    dots: true,
                    arrows: true
                });
            }

            if ($("#middle_banner").html() != "") {

                $('#middle_banner').slick({
                    slidesToShow: 3,
                    dots: true,
                    arrows: true,
                    responsive: [{
                            breakpoint: 991,
                            settings: {
                                slidesToShow: 3,
                            }
                        },
                        {
                            breakpoint: 767,
                            settings: {
                                slidesToShow: 2,
                            }
                        },
                        {
                            breakpoint: 650,
                            settings: {
                                slidesToShow: 1,
                            }
                        }
                    ]
                });
            }

        }

        if (type == "categories") {
            if ($("#append_categories").html() != "") {

                $('#append_categories').slick({
                    arrows: true,
                    dots: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    prevArrow: '<a class="slick-prev"><i class="fas fa-arrow-left" alt="Arrow Icon"></i></a>',
                    nextArrow: '<a class="slick-next"><i class="fas fa-arrow-right" alt="Arrow Icon"></i></a>',
                    responsive: [{
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 580,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 375,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }
        }

        if (type == "products" && countProducts > 2) {

            if ($(".product_items").html() != "") {
                $('.product_items').slick({
                    arrows: true,
                    slidesToShow: 4,
                    prevArrow: '<a class="slick-prev"><i class="fas fa-arrow-left" alt="Arrow Icon"></i></a>',
                    nextArrow: '<a class="slick-next"><i class="fas fa-arrow-right" alt="Arrow Icon"></i></a>',
                    responsive: [{
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 580,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }
        }

        if (type == "most_sale_product" && countProducts > 2) {

            if ($(".most_selling").html() != "") {
                $('.most_selling').slick({
                    arrows: true,
                    dots: false,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    prevArrow: '<a class="slick-prev"><i class="fas fa-arrow-left" alt="Arrow Icon"></i></a>',
                    nextArrow: '<a class="slick-next"><i class="fas fa-arrow-right" alt="Arrow Icon"></i></a>',
                    responsive: [{
                            breakpoint: 1200,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 3,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 580,
                            settings: {
                                arrows: false,
                                dots: true,
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }
        }



    }

    async function getItemCategories() {
        itemCategoriesref.limit(6).get().then(async function(foodCategories) {
            append_categories = document.getElementById('append_categories');
            append_categories.innerHTML = '';
            var foodCategorieshtml = await buildHTMLItemCategory(foodCategories);
            append_categories.innerHTML = foodCategorieshtml;
            slickcatCarousel("categories");
            $('#overlay').hide();

        })
    }

    async function buildHTMLItemCategory(foodCategories) {
        var html = '';
        var alldata = [];
        foodCategories.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        var itemCount = await getTotalItem();

        var photo = placeholderImage;

        var view_product = "{{ route('productlist.all') }}";

        html = html + '<div class="col-md-3 top-cat-list"><a href="' + view_product +
            '" class="d-block text-center cat-link"><span class="cat-img"><img alt="#" src="' + photo +
            '"  onerror="this.onerror=null;this.src=\'' + placeholderImage +
            '\'" class="img-fluid mb-2"></span><h4 class="m-0">Browse All</h4><h6>' + itemCount + '</h6></a></div>';

        var category_html = '';

        var category_count = 0;

        for (listval of alldata) {
            var active_class = '';

            var val = listval;

            var category_id = "";

            if (val.photo) {
                photo = val.photo;
            }
            var view_product_details = "{{ route('productList', [':type', ':id']) }}";
            view_product_details = view_product_details.replace(':type', 'category');
            view_product_details = view_product_details.replace(':id', val.id);

            if (category_count == 0) {

                active_class = "active show";
                category_id = val.id;
            }
            category_html += '<li class="nav-item">\n' +
                '                        <a class="nav-link ' + active_class + ' category_product_list" id="' + val
                .id + '" data-toggle="pill" href="#list_' + val.id + '" role="tab" aria-selected="false">' + val
                .title + '</a>\n' +
                '                    </li>';

            category_count = category_count + 1;

            var itemCatCount = await getTotalItem(val.id, category_id);

            html = html + '<div class="col-md-3 top-cat-list"><a href="' + view_product_details +
                '" class="d-block text-center cat-link"><span class="cat-img"><img alt="#" src="' + photo +
                '"  onerror="this.onerror=null;this.src=\'' + placeholderImage +
                '\'" class="img-fluid mb-2"></span><h4 class="m-0">' + val.title + '</h4><h6>' + itemCatCount +
                '</h6></a></div>';
        }

        $('#item_product_tab').html(category_html);

        return html;
    }

    async function getCouponsList() {
        var html = '';
        var couponsRef2 = database.collection('coupons').where('isEnabled', '==', true).where('expiresAt', '>=',
            new Date()).limit(3);
        couponsRef2.get().then(async function(couponListSnapshot) {
            const numberOfRecords = couponListSnapshot.size;
            if (numberOfRecords === 1) {
                $(".offer-left").removeClass("col-lg-6");
                $(".offer-left").addClass("col-lg-12");
            }

            if (numberOfRecords === 0) {
                $(".vendor-offer-section").hide();
            } else {
                couponListSnapshot.docs.forEach((listval, index) => {
                    var val = listval.data();
                    var photo = placeholderImage;
                    var coupon_description = "";
                    var coupon_discount = "0%";
                    var discount = 0;
                    var view_product = "{{ route('productlist.all') }}";

                    if (val.image)
                        photo = val.image;

                    if (val.discount)
                        discount = val.discount;

                    if (val.discountType && val.discountType == "Percentage")
                        coupon_discount = discount + "%";

                    if (val.discountType && val.discountType == "Fix Price") {
                        if (currencyAtRight) {
                            coupon_discount = parseFloat(discount).toFixed(decimal_degits) +
                                " " + currentCurrency;
                        } else {
                            coupon_discount = currentCurrency + " " + parseFloat(discount)
                                .toFixed(decimal_degits);
                        }
                    }

                    if (val.description)
                        coupon_description = val.description;

                    if (index === 0) {
                        $(".coupon_description_left").text(coupon_description);
                        $(".offer-price_left").text(coupon_discount);
                        $(".coupon_image_left").html('<img src="' + photo + '">');
                    } else {
                        html = html +
                            '<div class="col-lg-12"><div class="ltn__banner-item"><div class="ltn__banner-item-inner d-flex align-items-center">';
                        html = html + '<div class="ltn__banner-img mr-3"><a href="' +
                            view_product + '"><img src="' + photo + '"></a></div>';
                        html = html +
                            '<div class="hm-offer-content"><h3 class="coupon_description">' +
                            coupon_description + '</h3><span class="offer-price">' +
                            coupon_discount + '</span><a href="' + view_product +
                            '" class="btn btn-primary">Shop Now</a></div>';
                        html = html + '</div></div></div>';
                    }
                });
                coupons_right = document.getElementById('offer-right');
                coupons_right.innerHTML = html;
            }
        })
    }


    async function getTotalItem(categoryId = '', category_id) {
        var itemRef = database.collection('vendor_products').where('publish', '==', true);

        if (categoryId) {
            itemRef = itemRef.where('categoryID', '==', categoryId);
        }

        var totalItems = itemRef.get().then(async function(itemRefData) {

            if (category_id == categoryId) {
                var append_trending_vendor = document.getElementById('most_sale1');
                append_trending_vendor.innerHTML = '';

                var get_data = await buildHTMLPopularItem(itemRefData, category_id);

                if (get_data.html != "") {
                    append_trending_vendor.innerHTML = get_data.html;
                    slickcatCarousel("products", get_data.count);

                } else {
                    append_trending_vendor.innerHTML =
                        '<div class="notfound"><h5>{{ trans('lang.not_product_found') }}</h5></div>';
                }

            }
            return "(" + itemRefData.docs.length + (itemRefData.docs.length > 1 ? " Items" : " Item") +
                ")";
        });

        return totalItems;


    }

    $(document).on('click', '.category_product_list', async function() {
        $('#overlay').show();
        var id = $(this).attr('id');
        await getTotalItem(id, id);
        $('#overlay').hide();

    });

    function buildHTMLPopularItem(popularItemsnapshot, category_id) {
        var html = '';
        var alldata = [];

        popularItemsnapshot.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;

            var rating = 0;
            var reviewsCount = 0;
            if (datas.hasOwnProperty('reviewsSum') && datas.reviewsSum != 0 && datas.hasOwnProperty(
                    'reviewsCount') && datas.reviewsCount != 0) {
                rating = (datas.reviewsSum / datas.reviewsCount);
                rating = Math.round(rating * 10) / 10;
            }
            datas.rating = rating;

            alldata.push(datas);

        });

        if (alldata.length > 0) {


            var photo = placeholderImage;

            html = html + '<div class="row tab-pane active show product_items" id="list_' + category_id +
                '" role="tabpanel">';
            var count = 0;
            alldata.forEach((listval) => {

                var val = listval;
                var vendor_id_single = val.id;

                var view_vendor_details = "{{ route('productDetail', ':id') }}";
                view_vendor_details = view_vendor_details.replace(':id', vendor_id_single);

                var rating = 0;
                var reviewsCount = 0;
                if (val.hasOwnProperty('reviewsSum') && val.reviewsSum != 0 && val.hasOwnProperty(
                        'reviewsCount') && val.reviewsCount != 0) {
                    rating = (val.reviewsSum / val.reviewsCount);
                    rating = Math.round(rating * 10) / 10;
                    reviewsCount = val.reviewsCount;
                }

                html = html +
                    '<div class="col-md-3 product-list"><div class="list-card position-relative"><div class="list-card-image">';

                if (val.photo) {
                    photo = val.photo;
                }

                var dis_price = '';
                var or_price = '';

                or_price = parseFloat(val.price);

                var product_badge = '';
                if (val.hasOwnProperty('discount') && val.discount != '' && val.discount != '0') {
                    dis_price = parseFloat(val.discount);

                    dis_price = parseFloat(parseFloat(or_price) * parseFloat(dis_price)) / 100;

                    dis_price = or_price - dis_price;

                    product_badge = "-" + val.discount + "%";
                }


                html = html +
                    '<div class="member-plan position-absolute"><span class="badge badge-dark open">' +
                    product_badge + '</span></div><a href="' + view_vendor_details + '"><img alt="#" src="' +
                    photo + '"  onerror="this.onerror=null;this.src=\'' + placeholderImage +
                    '\'" class="img-fluid item-img w-100"></a><div class="product-badge">\n' +
                    '                                                </div></div><div class="py-2 position-relative">' +
                    '<div class="rating-info ml-auto d-flex">';

                html = html + '</div>' +
                    '<div class="list-card-body"><h6 class="mb-1 popul-title"><a href="' + view_vendor_details +
                    '" class="text-black">' + val.name + '</a></h6>';
                html = html + '<h6 class="text-gray mb-1 cat-title" id="popular_food_category_' + val
                    .categoryID + '_' + val.id + '"></h6>';

                if (currencyAtRight) {
                    or_price = or_price.toFixed(decimal_degits) + "" + currentCurrency;
                    if (dis_price) {
                        dis_price = dis_price.toFixed(decimal_degits) + "" + currentCurrency;
                    }

                } else {
                    or_price = currentCurrency + "" + or_price.toFixed(decimal_degits);
                    if (dis_price) {
                        dis_price = currentCurrency + "" + dis_price.toFixed(decimal_degits);
                    }
                }

                if (dis_price == 0 || dis_price == null || dis_price == ' ' || dis_price == undefined) {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' + or_price +
                        '</h6>';
                } else {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' + dis_price +
                        '  <s>' + or_price + '</s></h6>';
                }

                html = html + '</div></div>';
                html = html + '</a></div></div></div>';

            });

            html = html + '</div>';
        }

        return {
            count: alldata.length,
            html: html
        };

    }

    function mostSellingProduct() {
        ordersRef.get().then(async function(snapshots) {
            if (snapshots.docs.length > 0) {
                var productFreq = {};
                snapshots.docs.forEach(listval => {
                    var data = listval.data();
                    data.products.forEach(product => {
                        var productId = product.id;
                        productFreq[productId] = (productFreq[productId] || 0) + 1;

                    });
                });
                var frequencyArray = Object.keys(productFreq).map(productId => ({
                    productId,
                    frequency: productFreq[productId]
                }));
                frequencyArray.sort((a, b) => b.frequency - a.frequency);
                var topProducts = frequencyArray.slice(0, 10);
                var mostSellingProduct = [];
                topProducts.forEach(element => {
                    mostSellingProduct.push(element.productId);
                });
                database.collection('vendor_products').where('id', 'in', mostSellingProduct).get().then(
                    async function(snapshots) {

                        if (snapshots.docs.length > 0) {
                            most_selling_product = document.getElementById('most_selling_product');
                            most_selling_product.innerHTML = '';
                            var most_selling_product_html = await buildHTMLMostSellingProduct(
                                snapshots);
                            most_selling_product.innerHTML = most_selling_product_html;
                            slickcatCarousel("most_sale_product", snapshots.docs.length);
                        }
                    })
            } else {
                $('.most-selling-section').remove();
            }
        })

    }

    async function buildHTMLMostSellingProduct(snapshots) {

        var html = '';
        var alldata = [];

        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        if (alldata.length > 0) {

            var photo = placeholderImage;
            var count = 0;
            alldata.forEach((listval) => {

                var val = listval;
                var vendor_id_single = val.id;

                var view_vendor_details = "{{ route('productDetail', ':id') }}";
                view_vendor_details = view_vendor_details.replace(':id', vendor_id_single);

                html = html +
                    '<div class="col-md-3 product-list"><div class="list-card position-relative"><div class="list-card-image">';

                if (val.photo) {
                    photo = val.photo;
                }

                var dis_price = '';
                var or_price = '';

                or_price = parseFloat(val.price);

                var product_badge = '';
                if (val.hasOwnProperty('discount') && val.discount != '' && val.discount != '0') {
                    dis_price = parseFloat(val.discount);

                    dis_price = parseFloat(parseFloat(or_price) * parseFloat(dis_price)) / 100;

                    dis_price = or_price - dis_price;

                    product_badge = "-" + val.discount + "%";
                }

                html = html +
                    '<div class="member-plan position-absolute"><span class="badge badge-dark open">' +
                    product_badge + '</span></div><a href="' + view_vendor_details +
                    '"><img alt="#" src="' + photo + '"  onerror="this.onerror=null;this.src=\'' +
                    placeholderImage +
                    '\'" class="img-fluid item-img w-100"></a><div class="product-badge">\n' +
                    '                                                </div></div><div class="py-2 position-relative">' +
                    '<div class="rating-info ml-auto d-flex">';

                html = html + '</div>' +
                    '<div class="list-card-body"><h6 class="mb-1 popul-title"><a href="' +
                    view_vendor_details + '" class="text-black">' + val.name + '</a></h6>';
                html = html + '<h6 class="text-gray mb-1 cat-title" id="popular_food_category_' + val
                    .categoryID + '_' + val.id + '"></h6>';

                if (currencyAtRight) {
                    or_price = or_price.toFixed(decimal_degits) + "" + currentCurrency;
                    if (dis_price) {
                        dis_price = dis_price.toFixed(decimal_degits) + "" + currentCurrency;
                    }

                } else {
                    or_price = currentCurrency + "" + or_price.toFixed(decimal_degits);
                    if (dis_price) {
                        dis_price = currentCurrency + "" + dis_price.toFixed(decimal_degits);
                    }
                }

                if (dis_price == 0 || dis_price == null || dis_price == ' ' || dis_price == undefined) {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' +
                        or_price + '</h6>';
                } else {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' +
                        dis_price + '  <s>' + or_price + '</s></h6>';
                }

                html = html + '</div></div>';
                html = html + '</a></div></div></div>';

            });

        }

        return html;

    }

    async function getHomepageCategory() {

        var home_cat_ref = database.collection('vendor_categories').where("publish", "==", true).limit(4);

        home_cat_ref.get().then(async function(homeCategories) {
            home_categories = document.getElementById('home_categories');
            home_categories.innerHTML = '';

            var homeCategorieshtml = '';
            var alldata = [];

            homeCategories.docs.forEach((listval) => {
                var datas = listval.data();
                datas.id = listval.id;

                alldata.push(datas);

            });
            for (listval of alldata) {


                var val = listval;

                var category_id = val.id;
                if (val.photo) {
                    photo = val.photo;
                } else {
                    photo = placeholderImage;
                }
                var haveProductRes = catHaveProducts(category_id);
                var haveProducts = await haveProductRes.then(function(status) {
                    return status;
                });

                if (haveProducts == true) {
                    var view_product_details = "{{ route('productList', [':type', ':id']) }}";
                    view_product_details = view_product_details.replace(':type', 'category');
                    view_product_details = view_product_details.replace(':id', category_id);
                    homeCategorieshtml += '<div class="category-content mb-5 ">';
                    homeCategorieshtml += '<div class="title d-flex align-items-center">';
                    homeCategorieshtml += '<h5>' + val.title + '</h5>';
                    homeCategorieshtml += '<span class="see-all ml-auto"><a href="' +
                        view_product_details + '">{!! trans('lang.see_all') !!}</a></span>';
                    homeCategorieshtml += '</div>';
                    var productHtmlRes = buildHTMLHomeCategoryProducts(category_id);
                    var productHtml = await productHtmlRes.then(function(html) {
                        return html;
                    })

                    homeCategorieshtml += productHtml;
                    homeCategorieshtml += '</div>';
                    homeCategorieshtml += '</div>';
                }

            }

            if (homeCategorieshtml != '') {
                home_categories.innerHTML = homeCategorieshtml;
            } else {
                $('.home-categories').remove();
            }
        })
    }
    async function catHaveProducts(categoryId) {
        var response = database.collection('vendor_products').where("categoryID", "==", categoryId).get().then(
            function(CatProducts) {
                if (CatProducts.docs.length > 0) {
                    return true;
                } else {
                    return false;
                }
            });
        return response;
    }

    function buildHTMLHomeCategoryProducts(category_id) {

        var html = '';

        var vendorCatRef = database.collection('vendor_products').where('categoryID', "==", category_id).limit(4);

        var storeHtmlRes = vendorCatRef.get().then(async function(productSnapshots) {

            var alldata = [];
            productSnapshots.docs.forEach((listval) => {
                var datas = listval.data();
                datas.id = listval.id;
                alldata.push(datas);
            });

            var count = 0;

            html = html + '<div class="row">';
            alldata.forEach((listval) => {
                var val = listval;
                var vendor_id_single = val.id;

                var view_vendor_details = "{{ route('productDetail', ':id') }}";
                view_vendor_details = view_vendor_details.replace(':id', vendor_id_single);

                html = html +
                    '<div class="col-md-3 product-list"><div class="list-card position-relative"><div class="list-card-image">';

                if (val.photo) {
                    photo = val.photo;
                }

                var dis_price = '';
                var or_price = '';

                or_price = parseFloat(val.price);

                var product_badge = '';
                if (val.hasOwnProperty('discount') && val.discount != '' && val.discount != '0') {
                    dis_price = parseFloat(val.discount);

                    dis_price = parseFloat(parseFloat(or_price) * parseFloat(dis_price)) / 100;

                    dis_price = or_price - dis_price;

                    product_badge = "-" + val.discount + "%";
                }

                html = html +
                    '<div class="member-plan position-absolute"><span class="badge badge-dark open">' +
                    product_badge + '</span></div><a href="' + view_vendor_details +
                    '"><img alt="#" src="' + photo + '"  onerror="this.onerror=null;this.src=\'' +
                    placeholderImage +
                    '\'" class="img-fluid item-img w-100"></a><div class="product-badge">\n' +
                    '                                                </div></div><div class="py-2 position-relative">' +
                    '<div class="rating-info ml-auto d-flex">';

                html = html + '</div>' +
                    '<div class="list-card-body"><h6 class="mb-1 popul-title"><a href="' +
                    view_vendor_details + '" class="text-black">' + val.name + '</a></h6>';
                html = html + '<h6 class="text-gray mb-1 cat-title" id="popular_food_category_' +
                    val.categoryID + '_' + val.id + '"></h6>';

                if (currencyAtRight) {
                    or_price = or_price.toFixed(decimal_degits) + "" + currentCurrency;
                    if (dis_price) {
                        dis_price = dis_price.toFixed(decimal_degits) + "" + currentCurrency;
                    }

                } else {
                    or_price = currentCurrency + "" + or_price.toFixed(decimal_degits);
                    if (dis_price) {
                        dis_price = currentCurrency + "" + dis_price.toFixed(decimal_degits);
                    }
                }

                if (dis_price == 0 || dis_price == null || dis_price == ' ' || dis_price ==
                    undefined) {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' +
                        or_price + '</h6>';
                } else {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' +
                        dis_price + '  <s>' + or_price + '</s></h6>';
                }

                html = html + '</div></div>';
                html = html + '</a></div></div></div>';



            });
            html = html + '</div>';

            return html;
        });

        return storeHtmlRes;
    }
</script>

@include('layouts.nav')
