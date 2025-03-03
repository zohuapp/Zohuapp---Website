@include('layouts.app')

@include('layouts.header')

<div class="st-brands-page pt-5 category-listing-page">

    {{-- displaying all products with their categories --}}
    <div class="container section-content">

        {{-- display item name --}}
        <div class="d-flex align-items-center mb-3 page-title">
            <h3 class="font-weight-bold text-dark" id="title"></h3>
        </div>

        <div class="row">
            {{-- display items categories --}}
            <div class="col-md-3">
                <div id="category-list"></div>
                <div id="brands-list"></div>
                <div id="attributes-list"></div>
            </div>

            {{-- display items --}}
            <div class="col-md-9">
                <div id="product-list"></div>
            </div>

        </div>

    </div>
    {{--  --}}
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


<script type="text/javascript">

    // initialize variables and their values
    var type = 'category';
    var id = 0;

    var catsRef = database.collection('vendor_categories').where('publish', '==', true);
    var productsRef = database.collection('vendor_products').where("publish", "==", true);
    var vendorRadius = '';
    var vendorRadiusRef = database.collection('settings').doc("globalSettings");

    jQuery("#overlay").show();

    // get categories
    async function getCategories() {
        catsRef.get().then(async function(snapshots) {
            if (snapshots != undefined) {
                var html = '';
                html = buildCategoryHTML(snapshots);
                // console.log(html);
                if (html != '') {
                    var append_list = document.getElementById('category-list');
                    append_list.innerHTML = html;
                    var category_id = $('#category-list .active').data('category-id');
                    // console.log(category_id);
                    if (category_id) {
                        id = category_id;
                        getProducts(type, category_id);
                        jQuery("#overlay").hide();
                    }
                }
            }
        });
    }

    // create categories list html template
    function buildCategoryHTML(snapshots) {
        var html = '';
        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        // console.log(alldata);

        html = html + '<div class="vandor-sidebar">';
        html = html + '<h3>{{ trans('lang.categories') }}</h3>';

        html = html + '<ul class="vandorcat-list">';
        alldata.forEach((listval) => {
            var val = listval;
            // console.log(val);
            if (val.photo) {
                photo = val.photo;
            } else {
                photo = placeholderImage;
            }
            if (val.id) {
                html = html + '<li class="active category-item_' + val.id + ' " data-category-id="' + val.id +
                    '" >';
                html = html +
                    '<a href="javascript:void(0)"><input class="form-check-input category-item" type="checkbox" name="category-item" data-category-id="' +
                    val.id + '">';
            } else {
                html = html + '<li class="category-item_' + val.id + '" data-category-id="' + val.id + '">';
                html = html +
                    '<a href="javascript:void(0)"><input class="form-check-input category-item" type="checkbox" name="category-item" data-category-id="' +
                    val.id + '">';
            }
            html = html + '<span><img src="' + photo + '" onerror="this.onerror=null;this.src=\'' +
                placeholderImage + '\'"></span>' + val.title + '</a>';
            html = html + '</li>';
        });
        html = html + '</ul>';

        return html;
    }

    // get products for specified categories
    async function getProducts(type, catId, checkedBrandIds, checkedAttrIds) {

        // console.log(type, catId, checkedBrandIds, checkedAttrIds);
        // console.log(id);

        jQuery("#overlay").show();
        var product_list = document.getElementById('product-list');
        product_list.innerHTML = '';
        var html = '';


        var productsRef = database.collection('vendor_products').where("publish", "==", true);
        if (type == "Multiple" && ((Array.isArray(catId) && catId.length > 0) || (Array.isArray(checkedBrandIds) &&
                checkedBrandIds.length > 0))) {
            $("#title").text("{{ trans('lang.products') }}");
        } else {
            catId = id;
            var idRef = database.collection('vendor_categories').doc(id);
            idRef.get().then(async function(idRefSnapshots) {
                var idRefData = idRefSnapshots.data();
                $("#title").text(idRefData.title + ' ' + "{{ trans('lang.products') }}");
            });
        }

        productsRef.get().then(async function(snapshots) {
            html = buildProductsHTML(snapshots, catId, checkedBrandIds, checkedAttrIds);
            if (html != '') {
                product_list.innerHTML = html;
                jQuery("#overlay").hide();
            }
        });
    }

    // document ready function
    $(document).ready(async function() {
        // execute the function on page ready
        await getCategories();

        // Click method to select different categories
        $(document).on("click", ".category-item, .brand-item, .attr-item ", function() {
            var checkboxes = document.querySelectorAll('.category-item');
            var brandcheckboxes = document.querySelectorAll('.brand-item');
            var attrcheckboxes = document.querySelectorAll('.attr-item');
            var checkedCategoryIds = [];
            var checkedBrandIds = [];
            var checkedAttrIds = [];
            checkboxes.forEach(function(cb) {
                var cat_id = ".category-item_" + cb.getAttribute('data-category-id');
                if (cb.checked) {
                    checkedCategoryIds.push(cb.getAttribute('data-category-id'));
                    $(cat_id).addClass('active')
                } else {
                    $(cat_id).removeClass('active')
                }
            });

            brandcheckboxes.forEach(function(cb) {
                var brand_id = ".brand-item_" + cb.getAttribute('data-brand-id');
                if (cb.checked) {
                    checkedBrandIds.push(cb.getAttribute('data-brand-id'));
                    $(brand_id).addClass('active')
                } else {
                    $(brand_id).removeClass('active')
                }
            });

            attrcheckboxes.forEach(function(cb) {
                var attr_id = ".attr-item_" + cb.getAttribute('data-attr-id');
                if (cb.checked) {
                    checkedAttrIds.push(cb.getAttribute('data-attr-id'));
                    $(attr_id).addClass('active')
                } else {
                    $(attr_id).removeClass('active')
                }
            });
            getProducts("Multiple", checkedCategoryIds, checkedBrandIds, checkedAttrIds);
        });

        //
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

            // var distance = await getDistanceFromLatLonInKm(vendor_lat, vendor_long, address_lat,
            //     address_lng);

            // if (distance <= vendorRadius) {
            //     // getProductList();
            // } else {
            //     jQuery(".section-content").remove();
            //     jQuery(".zone-error").show();
            //     jQuery("#overlay").hide();
            //     return false;
            // }
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

    // var product_list = document.getElementById('product-list');
    // product_list.innerHTML = '';
    // var html = '';
    // async function getProductList() {
    //     productsRef.get().then(async function(snapshots) {
    //         html = buildProductsHTML(snapshots);
    //         if (html != '') {
    //             product_list.innerHTML = html;
    //             jQuery("#overlay").hide();
    //         }
    //     });
    // }

    function buildProductsHTML(snapshots, id, checkedBrandIds, checkedAttrIds) {
        var html = '';
        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            if (Array.isArray(id) && id.length > 0 && Array.isArray(checkedBrandIds) && checkedBrandIds.length > 0) {
                if (id.includes(datas.categoryID) && checkedBrandIds.includes(datas.brandID)) {
                    datas.id = listval.id;
                    alldata.push(datas);
                }

            } else if (Array.isArray(id) && id.length > 0 && checkedBrandIds.length == 0) {
                if (id.includes(datas.categoryID)) {
                    datas.id = listval.id;
                    alldata.push(datas);
                }
            }
            else if (Array.isArray(checkedBrandIds) && checkedBrandIds.length > 0 && id.length == 0) {
                if (checkedBrandIds.includes(datas.brandID)) {
                    datas.id = listval.id;
                    alldata.push(datas);
                }
            }
            else {
                if (datas.categoryID === id) {
                    datas.id = listval.id;
                    alldata.push(datas);
                }
            }

        });

        var count = 0;
        var popularFoodCount = 0;
        html = html + '<div class="row">';

        if (alldata.length) {

            alldata.forEach((listval) => {
                var val = listval;
                var rating = 0;
                var reviewsCount = 0;
                if (val.hasOwnProperty('reviewsSum') && val.reviewsSum != 0 && val.hasOwnProperty('reviewsCount') && val.reviewsCount != 0) {
                    rating = (val.reviewsSum / val.reviewsCount);
                    rating = Math.round(rating * 10) / 10;
                    reviewsCount = val.reviewsCount;
                }

                html = html + '<div class="col-md-4 pb-3 product-list"><div class="list-card position-relative"><div class="list-card-image">';
                status = '{{trans("lang.non_veg")}}';
                statusclass = 'closed';
                if (val.veg == true) {
                    status = '{{trans("lang.veg")}}';
                    statusclass = 'open';
                }
                if (val.photo) {
                    photo = val.photo;
                } else {
                    photo = placeholderImage;
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

                var view_product_details = "{{ route('productDetail', ':id')}}";
                view_product_details = view_product_details.replace(':id', val.id);

                html = html + '<div class="member-plan position-absolute"><span class="badge badge-dark open">' + product_badge + '</span></div><a href="' + view_product_details + '"><img alt="#" src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-fluid item-img w-100"></a></div><div class="py-2 position-relative"><div class="list-card-body"><h6 class="mb-1"><a href="' + view_product_details + '" class="text-black">' + val.name + '</a></h6>';


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
                    html = html + '<span class="pro-price">' + or_price + '</span>';
                }
                else {
                    html = html + '<span class="pro-price">' + dis_price + '  <s>' + or_price + '</s></span>';
                }

                html = html + '<div class="star position-relative mt-0"><span class="badge badge-success" style="display:contents"><i class="feather-star"></i>' + rating + ' (' + reviewsCount + ')</span></div>';

                html = html + '</div>';
                html = html + '</div></div></div>';

            });

        } else {
            html = html + "<div class='no-result'><img src='../../img/no-result.png'></div>";
        }

        html = html + '</div>';
        return html;
    }

    // function buildProductsHTML(snapshots) {
    //     var html = '';
    //     var alldata = [];
    //     // console.log(snapshots.docs.length);
    //     snapshots.docs.forEach((listval) => {
    //         var datas = listval.data();
    //         datas.id = listval.id;
    //         alldata.push(datas);
    //     });

    //     // if (alldata.length) {
    //     //     alldata = alldata.slice(0, 50);
    //     // }

    //     var count = 0;
    //     var popularFoodCount = 0;
    //     html = html + '<div class="row">';

    //     if (alldata.length) {

    //         alldata.forEach((listval) => {
    //             var val = listval;

    //             html = html +
    //                 '<div class="col-md-4 pb-3 product-list"><div class="list-card position-relative"><div class="list-card-image">';

    //             if (val.photo) {
    //                 photo = val.photo;
    //             } else {
    //                 photo = placeholderImage;
    //             }

    //             var view_product_details = "{{ route('productDetail', ':id') }}";
    //             view_product_details = view_product_details.replace(':id', val.id);

    //             var dis_price = '';
    //             var or_price = '';
    //             or_price = parseFloat(val.price);
    //             var product_badge = '';
    //             if (val.hasOwnProperty('discount') && val.discount != '' && val.discount != '0') {
    //                 dis_price = parseFloat(val.discount);
    //                 dis_price = parseFloat(parseFloat(or_price) * parseFloat(dis_price)) / 100;
    //                 dis_price = or_price - dis_price;
    //                 product_badge = "-" + val.discount + "%";
    //             }

    //             html = html +
    //                 '<div class="member-plan position-absolute"><span class="badge badge-dark open">' +
    //                 product_badge + '</span></div><a href="' + view_product_details + '"><img alt="#" src="' +
    //                 photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage +
    //                 '\'" class="img-fluid item-img w-100"></a></div><div class="py-2 position-relative"><div class="list-card-body"><h6 class="mb-1"><a href="' +
    //                 view_product_details + '" class="text-black">' + val.name + '</a></h6>';

    //             if (currencyAtRight) {
    //                 or_price = or_price.toFixed(decimal_degits) + "" + currentCurrency;
    //                 if (dis_price) {
    //                     dis_price = dis_price.toFixed(decimal_degits) + "" + currentCurrency;
    //                 }

    //             } else {
    //                 or_price = currentCurrency + "" + or_price.toFixed(decimal_degits);
    //                 if (dis_price) {
    //                     dis_price = currentCurrency + "" + dis_price.toFixed(decimal_degits);
    //                 }
    //             }

    //             if (dis_price == 0 || dis_price == null || dis_price == ' ' || dis_price == undefined) {
    //                 html = html + '<span class="pro-price">' + or_price + '</span>';
    //             } else {
    //                 html = html + '<span class="pro-price">' + dis_price + '  <s>' + or_price + '</s></span>';
    //             }

    //             html = html + '</div>';
    //             html = html + '</div></div></div>';

    //         });

    //     } else {
    //         html = html + "<h5>{{ trans('lang.no_results') }}</h5>";
    //     }

    //     html = html + '</div>';
    //     return html;
    // }

    sortArrayOfObjects = (arr, key) => {
        return arr.sort((a, b) => {
            return b[key] - a[key];
        });
    };
</script>

@include('layouts.nav')
