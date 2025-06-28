@include('layouts.app')


@include('layouts.header')
@php
    $cityToCountry = file_get_contents(asset('tz-cities-to-countries.json'));
    $cityToCountry = json_decode($cityToCountry, true);
    $countriesJs = [];
    foreach ($cityToCountry as $key => $value) {
        $countriesJs[$key] = $value;
    }
@endphp

<div class="rentalcar-detail-page pt-5 product-detail-page mb-4">

    <div class="container position-relative">

        <div class="car-detail-inner">

            <div class="car-del-top-section">

                <div class="row" id="product-detail">

                </div>

                <div class="hidden-inputs">
                    <input type="hidden" name="vendor_id" id="vendor_id" value="">
                    <input type="hidden" name="vendor_name" id="vendor_name" value="">
                    <input type="hidden" name="vendor_location" id="vendor_location" value="">
                    <input type="hidden" name="vendor_latitude" id="vendor_latitude" value="">
                    <input type="hidden" name="vendor_longitude" id="vendor_longitude" value="">
                    <input type="hidden" name="vendor_image" id="vendor_image" value="">
                </div>
            </div>

            <div class="py-2 mb-3 rental-detailed-ratings-and-reviews mt-5">
                <div class="row">
                    <div class="rental-review col-md-8">
                        <div class="main-specification mb-0"></div>
                        <div class="review-inner">
                            <div id="customers_ratings_and_review" style="display: none;"></div>
                            <div id="customers_overview"></div>
                            <div class="see_all_review_div" style="display:none">
                                <button
                                    class="btn btn-primary btn-block btn-sm see_all_reviews">{{ trans('lang.see_all_reviews') }}</button>
                            </div>
                            <!-- <p class="no_review_fount" style="display:none">{{ trans('lang.no_review_found') }}</p>  -->
                        </div>
                    </div>

                    <div class="col-md-4 store-info">

                        <div class="shipping-detail card p-4 mb-4">
                            <div class="shipping-details-bottom-border pb-3">
                                <img class="mr-2" src="{{ url('img/Payment.png') }}" alt="">
                                <span>{{ trans('lang.safe_payment') }}</span>
                            </div>
                            <div class="shipping-details-bottom-border pb-3">
                                <img class="mr-2" src="{{ url('img/money.png') }}" alt="">
                                <span>{{ trans('lang.return_policy') }}</span>
                            </div>
                            <div class="shipping-details-bottom-border">
                                <img class="mr-2" src="{{ url('img/Genuine.png') }}" alt="">
                                <span>{{ trans('lang.authentic_products') }}</span>
                            </div>
                        </div>



                        <div class="more-from-store">
                            <div class="card p-4 mb-4">
                                <div class="more-fromd-flex justify-content-center">
                                    <h3> {{ trans('lang.most_selling_products') }}</h3>
                                </div>
                                <div class="top-rated-product" id="top-rated-product"></div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container py-2 mb-3 related-products mt-4" id="related_products">

            </div>

        </div>

    </div>

</div>
<div class="modal fade" id="socialShare" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered location_modal">

        <div class="modal-content">

            <div class="modal-header">

                <div class="col-md-12 font-weight-bold" id="product_info">
                </div>
            </div>

            <div class="modal-body">
                <input type="text" id="productUrl" hidden>
                <input type="text" id="productName" hidden>
                <div class="col-md-12 d-flex social-icon">
                    <div class="col-md-3"><a href="javascript:void(0)" onclick="copyToClipboard()"><i
                                class="fa fa-copy fa-lg"></i></a>
                        <div class="code-copied" style="display:none">{{ trans('lang.copied') }}</div>
                    </div>

                    <div class="col-md-3"><a href="javascript:void(0)" target="_blank" name="whatsapp-share"
                            class="whatsapp-share"><i class="fa fa-whatsapp fa-lg"></i></a>
                    </div>
                    <div class="col-md-3">
                        <a href="mailto:?subject=Check out this product&body={{ url('product/' . $id) }}"
                            id="share-email">
                            <i class="fa fa-envelope-o"></i></a>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">close
                </button>

            </div>
        </div>

    </div>

</div>
@include('layouts.footer')

<script src="https://unpkg.com/geofirestore/dist/geofirestore.js"></script>

<script src="https://cdn.firebase.com/libs/geofire/5.0.1/geofire.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/slick/slick.min.js') }}"></script>

<script type="text/javascript">
    cityToCountry = '<?php echo json_encode($countriesJs); ?>';

    cityToCountry = JSON.parse(cityToCountry);
    var userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    userCity = userTimeZone.split('/')[1];
    userCountry = cityToCountry[userCity];
    var id = '<?php echo $id; ?>';

    var productsRef = database.collection('vendor_products').doc(id);
    // console.log(productsRef);

    var firestore = app1.firestore();
    var geoFirestore = new GeoFirestore(firestore);

    var review_pagesize = 5;
    var review_start = null;
    var specialOfferVendor = [];
    let specialOfferForHour = [];
    var reviewAttributes = {};
    var vendorLongitude = '';
    var vendorLatitude = '';

    var taxValue = [];
    var reftaxSetting = database.collection('tax').where('country', '==', userCountry).where('enable', '==', true);
    reftaxSetting.get().then(async function(snapshots) {
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
                taxValue.push(obj);

            })
        }
    });

    var DeliveryCharge = database.collection('settings').doc('DeliveryCharge');
    DeliveryCharge.get().then(async function(deliveryChargeSnapshots) {
        deliveryChargemain = deliveryChargeSnapshots.data();

        deliveryCharge = deliveryChargemain.amount;

        $("#deliveryChargeMain").val(deliveryCharge);

        $("#deliveryCharge").val(deliveryCharge);
    });
    var deliveryChargemain = [];

    var refReviewAttributes = database.collection('review_attributes');
    refReviewAttributes.get().then(async function(snapshots) {
        if (snapshots != undefined) {
            snapshots.forEach((doc) => {
                var data = doc.data();
                reviewAttributes[data.id] = data.title;
            });
        }
    });
    $(document).ready(async function() {

        await getProductDetail();

        $(document).on('swipe, afterChange', '.nav-slider', function(event, slick, direction) {
            $('.main-slider').slick('slickGoTo', slick.currentSlide);
        });

        $(document).on('click', '.nav-slider .product-image', function() {
            $('.main-slider').slick('slickGoTo', $(this).data('slick-index'));
        });

        $(document).on('click', '.attribute_list .attribute-drp .attribute-selection', function() {
            var product = $(this).parent().parent().parent().data('product');
            $('.attribute_price_div').removeClass('d-none');
            $('.product_price_div').addClass('d-none');
            getVariantPrice(product);
        });

        $(document).on('click', '.top-rated-product .store-product', function() {
            var pid = $(this).data('product-id');
            var view_product_details = "{{ route('productDetail', ':id') }}";
            view_product_details = view_product_details.replace(':id', pid);
            window.location.href = view_product_details;
        });

        $(document).on("click", '.add-to-cart', function(event) {

                @guest
                window.location.href = '<?php echo route('login'); ?>';
                return false;
            @endguest

            var $elem = $(this);

            var id = $(this).attr('data-id');
            var quantity = $('input[name="quantity_' + id + '"]').val();

            if (quantity == 0) {
                Swal.fire({
                    text: "{{ trans('lang.invalid_qty') }}",
                    icon: "error"
                });
                return false;
            }
            var description = $('input[name="description_' + id + '"]').val();

            var discount = parseFloat($('input[name="discount_' + id + '"]').val());
            var dis_price = parseFloat($('input[name="dis_price_' + id + '"]').val());

            var hsn_code = $('input[name="hsn_code_' + id + '"]').val();
            var unit = $('input[name="unit_' + id + '"]').val();
            var name = $('input[name="name_' + id + '"]').val();

            var item_price = parseFloat($('input[name="price_' + id + '"]').val());

            if (dis_price != '0' && dis_price != 0) {
                item_price = dis_price;
            }
            var ItemActualPrice = item_price; price = item_price;
            var stock_quantity = $('#quantity_' + id).val();

            var variant_info = {};

            var element = $('#variation_info_' + id).find('#variant_price');
            var variant_id = element.attr('data-vid');
            if (variant_id != undefined) {

                var variant_sku = element.attr('data-vsku');
                var variant_img = element.attr('data-vimg');
                if (variant_img == undefined) {
                    variant_img = placeholderImage;
                }
                var variant_options = $.parseJSON(element.attr('data-vinfo'));
                var variant_price = parseFloat(element.attr('data-vprice'));
                var variant_qty = parseFloat(element.attr('data-vqty'));

                if (quantity > variant_qty && variant_qty != -1) {
                    Swal.fire({
                        text: "{{ trans('lang.invalid_stock_qty') }}",
                        icon: "error"
                    });
                    return false;
                }
                variant_info['variant_id'] = variant_id;
                variant_info['variant_sku'] = variant_sku;
                variant_info['variant_options'] = variant_options;
                variant_info['variant_price'] = variant_price;
                variant_info['variant_qty'] = variant_qty;
                variant_info['variant_image'] = variant_img;
                ItemActualPrice = variant_price;
                price = variant_price;
                discount = 0;
                dis_price = 0;
            } else {

                if (stock_quantity != undefined && stock_quantity != -1 && parseInt(quantity) >
                    parseInt(stock_quantity)) {

                    Swal.fire({
                        text: "{{ trans('lang.invalid_stock_qty') }}",
                        icon: "error"
                    });
                    return false;
                }
            }


            var category_id = $('input[name="category_id_' + id + '"]').val(); setCookie(
                'deliveryChargemain', JSON.stringify(deliveryChargemain), 356);

            price = price * quantity;
            var image = $('input[name="image_' + id + '"]').val();

            var total_price = price;

            image = image ? image : placeholderImage;

            $.ajax({
                type: 'POST',

                url: "<?php echo route('add-to-cart'); ?>",
                data: {
                    _token: '<?php echo csrf_token(); ?>',
                    id: id,
                    quantity: quantity,
                    stock_quantity: stock_quantity,
                    name: name,
                    price: price,
                    dis_price: dis_price,
                    discount: discount,
                    image: image,
                    item_price: ItemActualPrice,
                    taxValue: taxValue,
                    variant_info: variant_info,
                    category_id: category_id,
                    decimal_degits: decimal_degits,
                    description: description,
                    hsn_code: hsn_code,
                    unit: unit

                },
                success: function(data) {
                    data = JSON.parse(data);
                    $('#cart_list').html(data.html);
                    loadcurrency();
                    $('#close_' + id).trigger("click");

                    if ($elem.hasClass('booknow')) {
                        window.location.href = '<?php echo route('checkout'); ?>';
                    } else {
                        Swal.fire({
                            text: "{{ trans('lang.added_tocart') }}",
                            icon: "success"
                        });
                    }
                }
            });
        });


    $(document).on("click", '.remove_item', function(event) {
        var id = $(this).attr('data-id');
        var vendor_id = $(this).attr('data-vendor');
        $.ajax({
            type: 'POST',
            url: "<?php echo route('remove-from-cart'); ?>",
            data: {
                _token: '<?php echo csrf_token(); ?>',
                vendor_id: vendor_id,
                id: id
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#cart_list').html(data.html);
                loadcurrency();
            }
        });
    });

    $(document).on("click", '.count-number-input-cart', function(event) {
        var id = $(this).attr('data-id');
        var vendor_id = $(this).attr('data-vendor');
        var quantity = $('.count_number_' + id).val();
        $.ajax({
            type: 'POST',
            url: "<?php echo route('change-quantity-cart'); ?>",
            data: {
                _token: '<?php echo csrf_token(); ?>',
                vendor_id: vendor_id,
                id: id,
                quantity: quantity,
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#cart_list').html(data.html);
                loadcurrency();
            }
        });
    });

    $(document).on("click", '#apply-coupon-code', function(event) {
        var coupon_code = $("#coupon_code").val();
        var vendor_id = $('input[name="vendor_id"]').val();
        var endOfToday = new Date();
        var couponCodeRef = database.collection('coupons').where('code', "==", coupon_code).where(
            'isEnabled', "==", true).where('expiresAt', ">=", endOfToday);

        couponCodeRef.get().then(async function(couponSnapshots) {
            if (couponSnapshots.docs && couponSnapshots.docs.length) {
                var coupondata = couponSnapshots.docs[0].data();
                if (coupondata.vendorID != undefined && coupondata.vendorID != '') {
                    if (coupondata.vendorID == vendor_id) {
                        discount = coupondata.discount;
                        coupon_id = coupondata.id;
                        discountType = coupondata.discountType;

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo route('apply-coupon'); ?>",
                            data: {
                                _token: '<?php echo csrf_token(); ?>',
                                coupon_code: coupon_code,
                                discount: discount,
                                discountType: discountType,
                                coupon_id: coupondata.id,
                            },

                            success: function(data) {
                                data = JSON.parse(data);
                                $('#cart_list').html(data.html);
                                loadcurrency();
                            }
                        });
                    } else {
                        alert("Coupon code is not valid.");
                        $("#coupon_code").val('');
                    }

                } else {
                    discount = coupondata.discount;
                    discountType = coupondata.discountType;
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo route('apply-coupon'); ?>",
                        data: {
                            _token: '<?php echo csrf_token(); ?>',
                            coupon_code: coupon_code,
                            discount: discount,
                            discountType: discountType,
                            coupon_id: coupondata.id,
                        },

                        success: function(data) {
                            data = JSON.parse(data);
                            $('#cart_list').html(data.html);
                            loadcurrency();
                        }
                    });
                }

            } else {
                alert("Coupon code is not valid.");
                $("#coupon_code").val('');
            }
        });
    });

    $(document).on("click", '#Other_tip', function(event) {
        $("#tip_amount").val('');
        $("#add_tip_box").show();
    });

    $(document).on("click", '.addon-checkbox', function(event) {
        if ($(this).is(':checked')) {
            $(this).next().addClass('active');
        } else {
            $(this).next().removeClass('active');
        }
    });

    $(document).on("click", '.this_tip', function(event) {
        var this_tip = $(this).val();
        var data = $(this);
        $("#tip_amount").val(this_tip);
        $("#add_tip_box").hide();
        if ((data).is('.tip_checked')) {
            data.removeClass('tip_checked');
            $(this).prop('checked', false);
            tipAmountChange('minus');
        } else {
            $(this).addClass('tip_checked');
            tipAmountChange('plus');
        }
    });
    });

    function tipAmountChange(type = "plus") {
        var this_tip = $("#tip_amount").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo route('order-tip-add'); ?>",
            data: {
                _token: '<?php echo csrf_token(); ?>',
                tip: this_tip,
                type: type
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#cart_list').html(data.html);
                loadcurrency();
            }
        });
    }

    function getProductDetail() {
        $("#overlay").show();
        productsRef.get().then(async function(snapshots) {
            // console.log(snapshots.data());
            if (snapshots != undefined) {
                var html = '';
                html = await buildHTML(snapshots);
                jQuery("#overlay").hide();
                if (html != '') {
                    var append_list = document.getElementById('product-detail');
                    append_list.innerHTML = html;
                    slickCarousel();
                }
            }
        });
    }

    function loadcurrency() {
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

    function getOverview(vendorProduct, limit) {
        var overviewHTML = '';
        overviewHTML = buildOverviewsHTML(vendorProduct);
        if (overviewHTML != '') {
            jQuery("#customers_overview").append(overviewHTML);

        }

    }


    function buildOverviewsHTML(vendorProduct) {

        var reviewhtml = '<h3>{{ trans('lang.overview') }}</h3>';



        reviewhtml +=
            '<div class="customers-overview-list"><ul><li><label>Brand:</label><span class="brand"></span></li>';
        database.collection('brands').doc(vendorProduct.brandID).get().then((result) => {
            var brand_name = result.exists ? result.data().title : '';
            if (brand_name) {
                $(".brand").html(brand_name);
            }
        });
        reviewhtml += '<li><label>Category:</label><span class="cat_name"></span></li>';

        database.collection('vendor_categories').doc(vendorProduct.categoryID).get().then((result) => {
            var cat_name = result.exists ? result.data().title : '';
            if (cat_name) {
                $(".cat_name").html(cat_name);
            }
        });


        // var expiry = vendorProduct.expiry_date.toDate().toLocaleDateString('en', {
        //     year: "numeric",
        //     month: "short",
        //     day: "numeric"
        // });

        // reviewhtml += '<li><label>Shelf Life:</label><span class="shelf_life">' + vendorProduct.shelf_life +
        //     '</span></li><li><label>Country:</label><span class="country">' + vendorProduct.country +
        //     '</span></li><li><label>FSSAI License:</label><span class="fssai_license">' + vendorProduct.license_fssai +
        //     '</span></li><li><label>Expiry Date:</label><span class="expiry_date">' + expiry +
        //     '</span></li><li><label>Packaging Type:</label><span class="packaging_type">' + vendorProduct
        //     .packaging_type + '</span></li><li><label>Seller FSSAI:</label><span class="seller_fssai">' + vendorProduct
        //     .seller_fssai + '</span></li><li><label>HSN Code:</label><span class="hsn_code">' + vendorProduct.hsn_code +
        //     '</span></li><li><label>Unit:</label><span class="unit">' + vendorProduct.unit +
        //     '</span></li><li><label>Disclaimer:</label><span class="disclaimer">' + vendorProduct.disclaimer +
        //     '</span></li>';

        // displaying only the country information
        reviewhtml += '<li><label>Country:</label><span class="country">' + vendorProduct.country + '</span></li><li>';



        reviewhtml += '</ul></div>';

        return reviewhtml;
    }

    async function checkFavoriteProduct(productID) {
        if (user_uuid != undefined) {
            var user_id = user_uuid;
        } else {
            var user_id = '';
        }

        await database.collection('favorite_item').where('product_id', '==', productID).where('user_id', '==',
            user_id).get().then(async function(favoriteItemsnapshots) {

            if (favoriteItemsnapshots.docs.length > 0) {

                $('.addToFavorite').html(
                    '<i class="font-weight-bold fa fa-heart" style="color:red"></i> {{ trans('lang.add_to_wishlist') }}'
                );
            } else {

                $('.addToFavorite').html(
                    '<i class="font-weight-bold feather-heart" ></i> {{ trans('lang.add_to_wishlist') }}'
                );
            }
        });
    }


    $(document).on("click", "a[name='loginAlert']", function(e) {
        Swal.fire({
            text: "{{ trans('lang.login_to_add_favorite') }}",
            icon: "error"
        });

    });
    $(document).on("click", "a[name='addToFavorite']", function(e) {

        var user_id = user_uuid;
        var store_id = this.id;
        var product_id = '<?php echo $id; ?>';

        database.collection('favorite_item').where('product_id', '==', product_id).where('user_id', '==',
            user_id).get().then(async function(favoriteItemsnapshots) {
            //
            if (favoriteItemsnapshots.docs.length > 0) {
                var id = favoriteItemsnapshots.docs[0].id;
                database.collection('favorite_item').doc(id).delete().then(function() {
                    $('.addToFavorite').html(
                        '<i class="font-weight-bold feather-heart" ></i> {{ trans('lang.add_to_wishlist') }}'
                    );
                });
            } else {
                var id = "<?php echo uniqid(); ?>";
                database.collection('favorite_item').doc(id).set({
                    'store_id': store_id,
                    'user_id': user_id,
                    'product_id': product_id
                }).then(function(result) {
                    $('.addToFavorite').html(
                        '<i class="font-weight-bold fa fa-heart" style="color:red"></i>  {{ trans('lang.add_to_wishlist') }}'
                    );
                });
            }
        });


    });

    async function buildHTML(snapshots) {

        // get the placeholder image URL
        const placeholderImage = await getPlaceholderImage();

        var vendorProduct = snapshots.data();
        if (vendorProduct != undefined) {
            var productID = vendorProduct.id;

            <?php if (Auth::check()) { ?>
            setTimeout(() => {
                checkFavoriteProduct(productID);
            }, 3000);
            <?php } ?>
            getOverview(vendorProduct, true);

            getRelatedProducts(vendorProduct);
            getTopRatedProducts(vendorProduct);
            if (vendorProduct.brandID) {
                getBrandData(vendorProduct.brandID);
            }

            var html = '';

            var price = vendorProduct.price;
            if (vendorProduct.hasOwnProperty('discount') && vendorProduct.discount != '' && vendorProduct
                .discount != '0') {
                var dis_price = parseFloat(parseFloat(or_price) * parseFloat(vendorProduct.discount)) / 100;
                price = price - dis_price;
            }

            if (vendorProduct.photo != null && vendorProduct.photo != "") {
                photo = vendorProduct.photo;
            } else {
                photo = placeholderImage;
            }

            var view_product_details = "{{ route('productDetail', ':id') }}";
            view_product_details = view_product_details.replace(':id', 'id=' + vendorProduct.id);

            html = html + '<div class="col-md-6 rent-cardet-left">';
            if (vendorProduct.photos != null && vendorProduct.photos.length > 0) {
                html = html + '<div class="main-slider">';
                vendorProduct.photos.forEach((photo) => {
                    html = html + '<div class="product-image">';
                    html = html + '<img alt="#" src="' + photo +
                        '" onerror="this.onerror=null;this.src=\'' + placeholderImage +
                        '\'" class="img-fluid item-img w-100">';
                    html = html + '</div>';
                });
                html = html + '</div>';
                html = html + '<div class="nav-slider">';
                vendorProduct.photos.forEach((photo) => {
                    html = html + '<div class="product-image">';
                    html = html + '<img alt="#" src="' + photo +
                        '" onerror="this.onerror=null;this.src=\'' + placeholderImage +
                        '\'" class="img-fluid item-img w-100">';
                    html = html + '</div>';
                });
                html = html + '</div>';
            } else {
                html = html + '<div class="product-image">';
                html = html + '<img alt="#" src="' + photo + '" onerror="this.onerror=null;this.src=\'' +
                    placeholderImage + '\'" class="img-fluid item-img w-100">';
                html = html + '</div>';
            }
            html = html + '</div>';

            html = html + '<div class="col-md-6 rent-cardet-right">';

            html = html + '<div class="carrent-det-rg-inner">';

            html = html + '<div class="car-det-head mb-3">';

            html = html + '<div class="car-det-head-top">';

            html = html + '<div class="car-det-title">';

            html = html + '<h2>' + vendorProduct.name + '</h2>';
            var rating = 0;
            var reviewsCount = 0;
            if (vendorProduct.hasOwnProperty('reviewsSum') && vendorProduct.reviewsSum != 0 && vendorProduct
                .hasOwnProperty('reviewsCount') && vendorProduct.reviewsCount != 0) {
                rating = (vendorProduct.reviewsSum / vendorProduct.reviewsCount);
                rating = Math.round(rating * 10) / 10;
                reviewsCount = vendorProduct.reviewsCount;
            }


            html = html + '</div>';

            html = html + '<div class="description mt-2 mb-3">';
            html = html + '<p>' + vendorProduct.description + '</p>';
            html = html + '</div>';

            html = html + '<div class="car-det-price ml-auto">';

            html = html + '<div class="attribute_price_div d-none">';
            html = html + '<span class="price">';
            html = html + '<div class="variation_info" id="variation_info_' + vendorProduct.id + '">';
            html = html + '<span id="variant_price"></span>';
            html = html + '<span id="variant_qty"></span>';
            html = html + '</div>';
            html = html + '</span> </div>';



            vendorProduct.price = parseFloat(vendorProduct.price);
            html = html + '<div class="product_price_div">';

            if (vendorProduct.hasOwnProperty('discount') && vendorProduct.discount != '' && vendorProduct
                .discount != '0') {

                var disPrice = (parseFloat(vendorProduct.discount) * parseFloat(vendorProduct.price)) / 100;
                disPrice = vendorProduct.price - disPrice;
                var dis_price = '';
                var or_price = '';
                if (currencyAtRight) {
                    or_price = vendorProduct.price.toFixed(decimal_degits) + "" + currentCurrency;
                    dis_price = disPrice.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    or_price = currentCurrency + "" + vendorProduct.price.toFixed(decimal_degits);
                    dis_price = currentCurrency + "" + disPrice.toFixed(decimal_degits);
                }
                html = html + '<span class="price">' + dis_price + '  <s>' + or_price + '</s></span>';
                html += '<input type="hidden" id="dis_price_' + vendorProduct.id + '" name="dis_price_' +
                    vendorProduct.id + '" value="' + disPrice + '">';

            } else {
                var or_price = '';
                if (currencyAtRight) {
                    or_price = vendorProduct.price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    or_price = currentCurrency + "" + vendorProduct.price.toFixed(decimal_degits);
                }
                html = html + '<span class="price">' + or_price + '</span>';
                html += '<input type="hidden" id="dis_price_' + vendorProduct.id + '" name="dis_price_' +
                    vendorProduct.id + '" value="0">';

            }

            if (vendorProduct.hasOwnProperty('quantity')) {
                if (vendorProduct.quantity == -1) {
                    html = html +
                        '<span id="variant_qty">{{ trans('lang.qty_left') }}: {{ trans('lang.unlimited') }}</span>';
                } else {
                    html = html + '<span id="variant_qty">{{ trans('lang.qty_left') }}: ' + vendorProduct
                        .quantity + '</span>';
                }
            }
            html = html + '</div>';



            html = html + '</div>';

            html = html + '</div>';
            html = html + '</div>';

            if (vendorProduct.brandID) {
                await database.collection('brands').doc(vendorProduct.brandID).get().then((result) => {
                    var brand_name = result.exists ? result.data().title : '';
                    if (brand_name) {

                        html = html + '<div class="brand mt-2 mb-3">';
                        html = html + '<h3>{{ trans('lang.brand') }} | ' + brand_name + '</h3>';

                        html = html + '</div>';
                    }


                });
            }
            html = html + '<div class="store mt-2 mb-3">';
            html = html + '</div>';



            if (vendorProduct.item_attribute != null && vendorProduct.item_attribute != "" && vendorProduct
                .item_attribute.attributes.length > 0 && vendorProduct.item_attribute.variants.length > 0) {
                var attributes = vendorProduct.item_attribute.attributes;
                var variants = vendorProduct.item_attribute.variants;
                html = html + '<div class="attributes mt-2 mb-0">';
                html = html + '<div class="v-boxariants">';
                html = html + '<div class="attribute_list" id="attribute-list-' + vendorProduct.id +
                    '" data-pid="' + vendorProduct.id + '" data-product="' + btoa(encodeURIComponent(JSON.stringify(
                        vendorProduct))) + '"></div>';
                html = html + '</div>';
                html = html + '</div>';
                getVariantsHtml(vendorProduct, attributes, variants)
            }

            if (vendorProduct.quantity == 0) {
                html = html +
                    '<div class="unlimited-product-bar"><p class="quantity-status-bar">{{ trans('lang.products_sold_out') }}</p><div class="product-progress"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:' +
                    (100 - vendorProduct.quantity) +
                    '%"></div></div><span class="qty-bar-val">{{ trans('lang.not_available') }}</span></div></div>';
            } else if (vendorProduct.quantity == -1) {
                html = html +
                    '<div class="unlimited-product-bar d-none"><p class="quantity-status-bar"></p><div class="product-progress"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div></div><span class="qty-bar-val"></span></div></div>';

            } else {
                html = html +
                    '<div class="unlimited-product-bar"><p class="quantity-status-bar">{{ trans('lang.products_almost_sold_out') }}</p><div class="product-progress"><div class="progress"><div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:' +
                    (100 - vendorProduct.quantity) + '%"></div></div><span class="qty-bar-val"">' + vendorProduct
                    .quantity + '' + ' {{ trans('lang.available') }}</span></div></div>';
            }
            html = html + '</div>';

            html = html + '<div class="quantity mt-2 mb-3">';
            html += '<div class="d-flex align-items-center product-item-box">';
            var label_qty = "{{ trans('lang.quantity') }}";
            html += '<h3 class="m-0">' + label_qty + '</h3>';
            html += '<div class="ml-auto">';
            html += '<span class="count-number">';
            html +=
                '<button type="button" class="btn-sm left dec btn btn-outline-secondary food_count_decrese"><i class="feather-minus"></i></button>';
            html += '<input class="count-number-input" name="quantity_' + vendorProduct.id +
                '" type="text"  value="1">';
            html +=
                '<button type="button" class="btn-sm right inc btn btn-outline-secondary"><i class="feather-plus"></i></button>';
            html += '</span>';
            html += '</div>';
            html += '</div>';
            html = html + '</div>';

            html = html + '<div class="addtocart mt-2 mb-3">';
            html += "<button data-id='" + String(vendorProduct.id) +
                "' type='button' class='add-to-cart btn btn-dark btn-lg btn-block' ><i class='feather-shopping-cart'></i> {{ trans('lang.add_to_cart') }}</button>";
            html += '<input type="hidden" name="name_' + vendorProduct.id + '" id="name_' + vendorProduct.id +
                '" value="' + vendorProduct.name + '">';
            html += '<input type="hidden" id="price_' + vendorProduct.id + '" name="price_' + vendorProduct.id +
                '" value="' + vendorProduct.price + '">';
            html += '<input type="hidden" id="discount_' + vendorProduct.id + '" name="discount_' + vendorProduct
                .id + '" value="' + vendorProduct.discount + '">';
            html += '<input type="hidden" id="quantity_' + vendorProduct.id + '" name="quantity_' + vendorProduct
                .id + '" value="' + vendorProduct.quantity + '">';
            html += '<input type="hidden" id="description_' + vendorProduct.id + '" name="description_' +
                vendorProduct.id + '" value="' + vendorProduct.description + '">';
            html += '<input type="hidden" id="hsn_code_' + vendorProduct.id + '" name="hsn_code_' + vendorProduct
                .id + '" value="' + vendorProduct.hsn_code + '">';
            html += '<input type="hidden" id="unit_' + vendorProduct.id + '" name="unit_' + vendorProduct.id +
                '" value="' + vendorProduct.unit + '">';

            html += '<input type="hidden" id="image_' + vendorProduct.id + '" name="image_' + vendorProduct.id +
                '" value="' + vendorProduct.photo + '">';
            html += '<input type="hidden" id="category_id_' + vendorProduct.id + '" name="category_id_' +
                vendorProduct.id + '" value="' + vendorProduct.categoryID + '">';

            html += "<button data-id='" + String(vendorProduct.id) +
                "' type='button' class='add-to-cart btn btn-primary btn-lg btn-block booknow' ><i class='feather-shopping-bag'></i> {{ trans('lang.book_now') }}</button>";
            html = html + '<div class="description mt-2 mb-3">';

            html = html + '</div>';
            html = html + '</div>';

            html = html + '<div class="product-fav-share">';
            html = html + '<div class="add-to-favorite">';

            @auth
            html = html +
                '<a  name="addToFavorite"  class="count addToFavorite" href="javascript:void(0)"><i  class="font-weight-bold feather-heart"></i> {{ trans('lang.add_to_wishlist') }}</a>';
        @else
            html = html +
                '<a  name="loginAlert" class="loginAlert count" href="javascript:void(0)"><i  class="font-weight-bold feather-heart"></i>{{ trans('lang.add_to_wishlist') }}</a>';
        @endauth

        html = html + '</div>';
        html = html + '<div class="share-btn">';
        var route1 = '{{ route('productDetail', ':id') }}';
        route1 = route1.replace(':id', vendorProduct.id);

        html = html + '<a  data-toggle="modal" data-target="#socialShare"  name="social-share-icon" data-url="' +
            route1 + '" data-name="' + vendorProduct.name +
            '" class="share-btn" href="javascript:void(0)"><i  class="font-weight-bold feather-share-2"></i> {{ trans('lang.share_this_product') }}</a>';
        html = html + '</div>';
        html = html + '</div>';
        return html;

    }
    }

    function getBrandData(brandID) {
        database.collection('brands').doc(brandID).get().then((result) => {
            return result.exists ? result.data() : null;
        });
    }

    function slickcatCarousel(type) {
        if (type == "related_product") {

            if ($(".related-products").html() != "") {
                $('.related-products').slick({
                    arrows: true,
                    dots: true,
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

    async function getRelatedProducts(vendorProduct) {
        var html = '';

        // get the placeholder image URL
        const placeholderImage = await getPlaceholderImage();

        // Fetch related products from the database using product category id
        database.collection('vendor_products').where('categoryID', "==", vendorProduct.categoryID).where("publish",
            "==", true).where('id', "!=", vendorProduct.id).limit(4).get().then(async function(snapshots) {

            if (snapshots.docs.length > 0) {
                html = buildHTMLRelatedProducts(snapshots, vendorProduct.categoryID, placeholderImage);
                // slickcatCarousel("related_product");
            }

            var append_list = document.getElementById('related_products');

            if (html != '') {
                append_list.innerHTML = html;
            } else {
                html = html +
                        '<div class="title d-flex align-items-center"><h3>{{ trans('lang.related_products') }}</h3></div>';
                    html = html + '<div class="row">';
                    html = html + '<p class="font-weight-bold">{{ trans('lang.not_product_found') }}</p>';
                    html = html + '</div>';
                    append_list.innerHTML = html;
            }
        });

    }

    function buildHTMLRelatedProducts(snapshots, cat_id, placeholderImage) {

        var html = '';

        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        var count = 0;
        var popularFoodCount = 0;

        var view_product_details = "{{ route('productList', [':type', ':id']) }}";
        view_product_details = view_product_details.replace(':type', 'category');
        view_product_details = view_product_details.replace(':id', cat_id);



        html = html + '<div class="title d-flex align-items-center"><h3>{{ trans('lang.related_products') }}</h3>';
        html = html + '<span class="see-all ml-auto"><a href="' + view_product_details +
            '">{{ trans('lang.view_all') }}</a></span></div>';
        html = html + '<div class="row">';

        // Loop through each product and build the HTML
        alldata.forEach((listval) => {

            var val = listval;
            var vendor_id_single = val.id;
            var view_vendor_details = "{{ route('productDetail', ':id') }}";
            view_vendor_details = view_vendor_details.replace(':id', vendor_id_single);

            var rating = 0;
            var reviewsCount = 0;
            if (val.hasOwnProperty('reviewsSum') && val.reviewsSum != 0 && val.hasOwnProperty('reviewsCount') &&
                val.reviewsCount != 0) {
                rating = (val.reviewsSum / val.reviewsCount);
                rating = Math.round(rating * 10) / 10;
                reviewsCount = val.reviewsCount;
            }

            html = html +
                '<div class="mb-4 mb-lg-0 col-md-6 col-lg-3 product-list"><div class="list-card position-relative"><div class="list-card-image">';

            if (val.photo) {
                photo = val.photo;
            } else {
                photo = placeholderImage;
            }

            html = html + '<a href="' + view_vendor_details + '"><img alt="#" src="' + photo +
                '" onerror="this.onerror=null;this.src=\'' + placeholderImage +
                '\'" class="img-fluid item-img w-100"></a></div><div class="py-2 position-relative"><div class="list-card-body position-relative"><h6 class="product-title mb-1"><a href="' +
                view_vendor_details + '" class="text-black">' + val.name + '</a></h6>';
            html = html + '<h6 class="mb-1 popular_food_category_ pro-cat" id="popular_food_category_' + val
                .categoryID + '_' + val.id + '" ></h6>';

            val.price = parseFloat(val.price);
            if (val.hasOwnProperty('discount') && val.discount != '' && val.discount != '0') {
                var dis_price = '';
                var or_price = '';
                dis_price = ((parseFloat(val.price) * parseFloat(val.discount)) / 100);
                var disPrice = parseFloat(val.price) - dis_price;

                if (currencyAtRight) {
                    or_price = val.price.toFixed(decimal_degits) + "" + currentCurrency;
                    dis_price = disPrice.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    or_price = currentCurrency + "" + val.price.toFixed(decimal_degits);
                    dis_price = currentCurrency + "" + disPrice.toFixed(decimal_degits);
                }

                html = html + '<span class="pro-price">' + dis_price + '  <s>' + or_price + '</s></span>';
            } else {
                var or_price = '';
                if (currencyAtRight) {
                    or_price = val.price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    or_price = currentCurrency + "" + val.price.toFixed(decimal_degits);
                }

                html = html + '<span class="pro-price">' + or_price + '</span>'
            }

            html = html +
                '<div class="star position-relative mt-3"><span class="badge badge-success" style="display:contents"><i class="feather-star"></i>' +
                rating + ' (' + reviewsCount + ')</span></div>';

            html = html + '</div>';

            html = html + '</div></div></div>';
        });

        html = html + '</div>';

        return html;
    }
    async function getTopRatedProducts(vendorProduct) {
        var html = '';
        var append_list = document.getElementById('top-rated-product');
        append_list.innerHTML = '';
        database.collection('orders').get().then(async function(snapshots) {
            if (snapshots.docs.length > 0) {
                var productFreq = {};
                snapshots.docs.forEach(listval => {
                    var data = listval.data();

                    data.products.forEach(product => {
                        if (product.category_id == vendorProduct.categoryID) {
                            var productId = product.id;
                            productFreq[productId] = (productFreq[productId] || 0) + 1;
                        }
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
                database.collection('vendor_products').where('id', 'in', mostSellingProduct).limit(3)
                    .get().then(async function(snapshots) {

                        if (snapshots.docs.length > 0) {

                            append_list.innerHTML = await buildHTMLTopRatedProducts(snapshots);

                        } else {
                            append_list.innerHTML =
                                '<p class="font-weight-bold">{{ trans('lang.not_product_found') }}</p>';

                        }
                    })
            } else {
                append_list.innerHTML =
                    '<p class="font-weight-bold">{{ trans('lang.not_product_found') }}</p>';

            }
        })
    }

    function buildHTMLTopRatedProducts(snapshots) {
        var html = '';

        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        alldata.forEach((listval) => {

            var val = listval;
            var product_id_single = val.id;
            var view_product_details = "{{ route('productDetail', ':id') }}";
            view_product_details = view_product_details.replace(':id', product_id_single);

            var rating = 0;
            var reviewsCount = 0;
            if (val.hasOwnProperty('reviewsSum') && val.reviewsSum != 0 && val.hasOwnProperty('reviewsCount') &&
                val.reviewsCount != 0) {
                rating = (val.reviewsSum / val.reviewsCount);
                rating = Math.round(rating * 10) / 10;
                reviewsCount = val.reviewsCount;
            }

            if (val.photo) {
                photo = val.photo;
            } else {
                photo = placeholderImage;
            }

            val.price = parseFloat(val.price);
            var dis_price = '';
            var or_price = '';
            if (val.hasOwnProperty('discount') && val.discount != '' && val.discount != '0') {
                var discount = parseFloat(val.price) - (parseFloat(val.discount) * parseFloat(val.price) / 100);
                if (currencyAtRight) {
                    or_price = val.price.toFixed(decimal_degits) + "" + currentCurrency;
                    dis_price = discount.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    or_price = currentCurrency + "" + val.price.toFixed(decimal_degits);
                    dis_price = currentCurrency + "" + discount.toFixed(decimal_degits);
                }
            } else {
                var or_price = '';
                if (currencyAtRight) {
                    or_price = val.price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    or_price = currentCurrency + "" + val.price.toFixed(decimal_degits);
                }
            }

            html = html + '<div class="store-product" data-product-id="' + product_id_single + '">';
            html = html + '<div class="product-content">';
            html = html + '<div class="store-image">';
            html = html + '<img src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage +
                '\'">';
            html = html + '</div>';
            html = html + '<div class="product-detail">';
            html = html + '<div class="basic">';
            html = html + '<div class="product-name">';
            html = html + '<span class="flash-product-title">' + val.name + '</span>';
            html = html + '</div>';


            html = html + '<div class="strike-price">';
            if (dis_price && or_price) {
                html = html + '<strike>' + or_price + '</strike>';
                html = html + '<div class="product-price">' + dis_price + '</div>';
            } else {
                html = html + '<div class="product-price">' + or_price + '</div>';
            }
            html = html + '</div>';
            html = html + '</div>';
            html = html + '</div>';
            html = html + '</div>';
            html = html + '</div>';
            html = html + '</div>';
        });

        return html;

    }

    function slickCarousel() {
        $('.main-slider').slick({
            slidesToShow: 1,
            arrows: false,
            draggable: false
        });
        $('.nav-slider').slick({
            slidesToShow: 7,
            arrows: true
        });
    }

    async function getVariantsHtml(vendorProduct, attributes, variants) {
        var attributesHtml = '';

        for (attribute of attributes) {
            var attributeHtmlRes = getAttributeHtml(vendorProduct, attribute);
            var attributeHtml = await attributeHtmlRes.then(function(html) {
                return html;
            })
            attributesHtml += attributeHtml;
        }
        $('#attribute-list-' + vendorProduct.id).html(attributesHtml);

        var variation_info = {};
        var variation_sku = '';
        $('#attribute-list-' + vendorProduct.id + ' .attribute-drp').each(function() {
            variant_title = $(this).data('atitle') + '-';
            variation_sku += $(this).find('input[type="radio"]:checked').val() + '-';
            variation_info[$(this).data('atitle')] = $(this).find('input[type="radio"]:checked').val();
        });
        variation_sku = variation_sku.replace(/-$/, "");

        if (variation_sku) {
            var variant_info = $.map(vendorProduct.item_attribute.variants, function(v, i) {
                if (v.variant_sku == variation_sku) {
                    return v;
                }
            });
            var variant_id = variant_image = variant_price = variant_price = variant_quantity = '';
            if (variant_info.length > 0) {
                var variant_id = variant_info[0].variant_id;
                var variant_image = variant_info[0].variant_image;
                var variant_price = parseFloat(variant_info[0].variant_price);
                var variant_sku = variant_info[0].variant_sku;
                var variant_img = variant_info[0].variant_image;
                var variant_quantity = variant_info[0].variant_quantity;
                if (currencyAtRight) {
                    var pro_price = variant_price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    var pro_price = currentCurrency + "" + variant_price.toFixed(decimal_degits);
                }

                $('#variation_info_' + vendorProduct.id).find('#variant_price').html(pro_price);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vid', variant_id);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vprice', variant_price);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vqty', variant_quantity);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vsku', variant_sku);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vimg', variant_img);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vinfo', JSON.stringify(
                    variation_info));
                if (variant_quantity == '-1') {
                    $('#variation_info_' + vendorProduct.id).find('#variant_qty').html(
                        '{{ trans('lang.qty_left') }}: {{ trans('lang.unlimited') }}');
                } else {
                    $('#variation_info_' + vendorProduct.id).find('#variant_qty').html(
                        '{{ trans('lang.qty_left') }}: ' + variant_quantity);
                }

            }
        }
    }

    function getAttributeHtml(vendorProduct, attribute) {

        var html = '';
        var vendorAttributesRef = database.collection('vendor_attributes').where('id', "==", attribute.attribute_id);
        attributeHtmlRes = vendorAttributesRef.get().then(async function(attributeRef) {
            var attributeInfo = attributeRef.docs[0].data();
            html += '<div class="attribute-drp" data-aid="' + attribute.attribute_id + '" data-atitle="' +
                attributeInfo.title + '">';
            html += '<h3 class="attribute-label">' + attributeInfo.title + '</h3>';
            html += '<div class="attribute-options">';
            $.each(attribute.attribute_options, function(i, option) {

                ischecked = '';
                html +=
                    '<div class="custom-control custom-radio border-bottom py-2 attribute-selection">';
                html += '<input type="radio" id="attribute-' + attribute.attribute_id + '-' +
                    option + '" name="attribute-options-' + attribute.attribute_id + '" value="' +
                    option + '" ' + ischecked + ' class="custom-control-input">';
                html += '<label class="custom-control-label attribute-' + attribute.attribute_id +
                    '-' + option + '" for="attribute-' + attribute.attribute_id + '-' + option +
                    '">' + option + '</label>';
                html += '</div>';
            });
            html += '</div>';
            html += '</div>';
            return html;
        })
        return attributeHtmlRes;
    }

    function getVariantPrice(vendorProduct) {
        var vendorProduct = $.parseJSON(decodeURIComponent(atob(vendorProduct)));
        var variation_info = {};
        var variation_sku = '';
        $('#attribute-list-' + vendorProduct.id + ' .attribute-drp').each(function() {
            var aid = $(this).parent().parent().data('aid');
            variation_sku += $(this).find('input[type="radio"]:checked').val() + '-';
            variation_info[$(this).data('atitle')] = $(this).find('input[type="radio"]:checked').val();
        });
        variation_sku = variation_sku.replace(/-$/, "");
        if (variation_sku) {
            var variant_info = $.map(vendorProduct.item_attribute.variants, function(v, i) {
                if (v.variant_sku == variation_sku) {
                    return v;
                }
            });

            var variant_id = variant_image = variant_price = variant_price = variant_quantity = '';
            if (variant_info.length > 0) {

                var variant_id = variant_info[0].variant_id;
                var variant_image = variant_info[0].variant_image;
                if (variant_image == undefined) {
                    variant_image = placeholderImage
                }
                var variant_price = parseFloat(variant_info[0].variant_price);
                var variant_sku = variant_info[0].variant_sku;
                var variant_quantity = variant_info[0].variant_quantity;
                if (currencyAtRight) {
                    var pro_price = variant_price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    var pro_price = currentCurrency + "" + variant_price.toFixed(decimal_degits);
                }

                $('#variation_info_' + vendorProduct.id).find('#variant_price').html(pro_price);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vid', variant_id);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vprice', variant_price);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vqty', variant_quantity);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vsku', variant_sku);
                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vimg', variant_image);

                $('#variation_info_' + vendorProduct.id).find('#variant_price').attr('data-vinfo', JSON.stringify(
                    variation_info));
                if (variant_quantity == '-1') {
                    $('#variation_info_' + vendorProduct.id).find('#variant_qty').html(
                        '{{ trans('lang.qty_left') }}: {{ trans('lang.unlimited') }}');
                } else {
                    $('#variation_info_' + vendorProduct.id).find('#variant_qty').html(
                        '{{ trans('lang.qty_left') }}: ' + variant_quantity);
                }
                if (parseFloat(variant_quantity) == 0) {
                    $('.unlimited-product-bar').removeClass('d-none');
                    $('.quantity-status-bar').html('{{ trans('lang.products_sold_out') }}');
                    $('.qty-bar-val').html('{{ trans('lang.not_available') }}')
                } else if (parseFloat(variant_quantity) == -1) {
                    $('.unlimited-product-bar').addClass('d-none');
                } else {
                    $('.unlimited-product-bar').removeClass('d-none');
                    $('.quantity-status-bar').html('{{ trans('lang.products_almost_sold_out') }}');
                    $('.qty-bar-val').html(parseFloat(variant_quantity) + ' {{ trans('lang.available') }}')
                }
                $('.progress-bar').css('width', (100 - parseFloat(variant_quantity) + '%'));

            }
        }
    }
    $(document).on("click", "a[name='social-share-icon']", async function(e) {
        var productUrl = $(this).attr('data-url');
        var productName = $(this).attr('data-name');
        $('#productUrl').val(productUrl);
        $('#productName').val(productName);
        $('#product_info').html(productName);
    });
    $(document).on("click", "a[name='whatsapp-share']", async function(e) {
        var productUrl = $('#productUrl').val();
        var productName = $('#productName').val();
        html = productName + " \n" + productUrl;
        $(this).attr('href', 'https://api.whatsapp.com/send?text=' + html + '');

    })
    $(document).on("click", "a[name='email-share']", async function(e) {
        e.preventDefault();
        var productUrl = $('#productUrl').val();
        var subject = $('#productName').val();
        var mailtoLink = 'mailto:?subject=' + encodeURIComponent(subject) + '&body=' + encodeURIComponent(
            productUrl);
        $(this).attr('href', mailtoLink);
        window.location.href = mailtoLink;
    })

    function copyToClipboard() {
        var productUrl = $('#productUrl').val();
        var productName = $('#productName').val();
        html = productName + "\n" + productUrl;
        navigator.clipboard.writeText("");
        navigator.clipboard.writeText(html);
        $(".code-copied").show();
        setTimeout(
            function() {
                $(".code-copied").hide();
            }, 4000);

    }
</script>

@include('layouts.nav')
