@include('layouts.app')

@include('layouts.header')


<div class="d-none">

    <div class="bg-primary p-3 d-flex align-items-center">

        <a class="toggle togglew toggle-2" href="#"><span></span></a>

        <h4 class="font-weight-bold m-0 text-white">{{trans('lang.search')}}</h4>

    </div>

</div>

<div class="siddhi-popular">


    <div class="container section-content">

        <div class="search py-5">

            <div class="input-group mb-4">


                <input type="text" class="form-control form-control-lg input_search border-right-0 food_search"
                    id="inlineFormInputGroup" value="" placeholder="{{trans('lang.search_product_items')}}">

                <div class="input-group-prepend">

                    <div class="btn input-group-text bg-white border_search border-left-0 text-primary search_food_btn">
                        <i class="feather-search"></i>

                    </div>

                </div>


            </div>

            <div class="text-center py-5 not_found_div"><img src="{{asset('img/no-result.png')}}"></div>


            <ul class="nav nav-tabs border-0 d-none" id="myTab2" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active border-0 bg-light text-dark rounded" id="home-tab" data-toggle="tab"
                        href="#home" role="tab" aria-controls="home" aria-selected="true"><i
                            class="feather-home mr-2"></i><span class="products_counts"></span></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="container mt-4 mb-4 p-0">
                        <div id="append_list2" class="res-search-list-1"></div>
                    </div>
                </div>
            </div>

        </div>


    </div>

    <div class="zone-error m-5 p-5" style="display: none;">
        <div class="zone-image text-center">
            <img src="{{asset('img/zone_logo.png')}}" width="100">
        </div>
        <div class="zone-content text-center text-center font-weight-bold text-danger">
            <h3 class="title">{{trans('lang.zone_error_title')}}</h3>
            <h6 class="text">{{trans('lang.zone_error_text')}}</h6>
        </div>
    </div>
</div>


@include('layouts.footer')


@include('layouts.nav')


<script type="text/javascript">

    var productsref = database.collection('vendor_products').where('publish', '==', true);

    var append_list2 = document.getElementById('append_list2');

    var productdata = [];

    var vendorRadius = '';
    var vendorRadiusRef = database.collection('settings').doc("globalSettings");
    var vendor_lat = getCookie('restaurant_latitude');
    var vendor_long = getCookie('restaurant_longitude');
    var address_lat = getCookie('address_lat');
    var address_lng = getCookie('address_lng');

    $(document).ready(async function () {
        await vendorRadiusRef.get().then(async function (snapshot) {
            var data = snapshot.data();
            if (data.hasOwnProperty('vendorRadius') && data.vendorRadius != null && data.vendorRadius != '') {
                vendorRadius = data.vendorRadius;
            }
        });

        if (address_lat != null && address_lat != '' && address_lat != NaN && address_lng != null && address_lng != '' && address_lng != NaN) {

            var distance = await getDistanceFromLatLonInKm(vendor_lat, vendor_long, address_lat, address_lng);
            
            if (distance <= vendorRadius) {
                await getProductData();
                getResults();
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


        async function getProductData() {
            let productsnapshot = await productsref.get();
            productsnapshot.docs.forEach((listval) => {
                var val = listval.data();
                productdata.push(val);
            });
        }


        $(".food_search").keypress(function (e) {
            if (e.which == 13) {
                getResults();
            }
        })

        $(".search_food_btn").click(function () {
            getResults();
        });

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

    async function getResults() {

        var vendors = [];

        $("#overlay").show();

        var foodsearch = $(".food_search").val();

        var filter_product = [];
        var products = [];
        if (foodsearch != '') {

            productdata.forEach((listval) => {
                var data = listval;
                var Name = data.name.toLowerCase();
                var Ans = Name.indexOf(foodsearch.toLowerCase());
                if (Ans > -1) {
                    filter_product.push(data);
                    if (!products.includes(data.vendorID)) {
                        products.push(data.vendorID);
                    }

                }
            });

        } else {
            productdata.forEach((listval) => {
                var data = listval;
                filter_product.push(data);
            });

        }
        var product_keypress = buildProductHTML(filter_product);


        if (product_keypress == '') {
            $(".not_found_div").show();
            append_list2.innerHTML = '';
            $(".products_counts").text('{{trans("lang.products")}} (0)');
            $("#overlay").hide();
        } else if (product_keypress != '') {

            $(".not_found_div").hide();
            append_list2.innerHTML = '';
            append_list2.innerHTML = product_keypress;
            $("#overlay").hide();
        }
    }

    function buildProductHTML(allProductdata) {

        var html = '';

        var count = 0;
        $(".products_counts").text('{{trans("lang.products")}} (' + allProductdata.length + ')');

        if (allProductdata != undefined && allProductdata != '') {

            $('#myTab2').removeClass('d-none');


            allProductdata.forEach((listval) => {
                count++;
                var val = listval;
                if (count == 1) {
                    html = html + '<div class="row">';
                }
                var product_id_single = val.id;
                var view_product_details = "{{ route('productDetail', ':id')}}";
                view_product_details = view_product_details.replace(':id', product_id_single);
                var rating = 0;
                var reviewsCount = 0;
                if (val.hasOwnProperty('reviewsSum') && val.reviewsSum != 0 && val.hasOwnProperty('reviewsCount') && val.reviewsCount != 0) {
                    rating = (val.reviewsSum / val.reviewsCount);
                    rating = Math.round(rating * 10) / 10;
                    reviewsCount = val.reviewsCount;
                }

                html = html + '<div class="col-md-3 product-list pb-3"><div class="list-card position-relative"><div class="list-card-image">';

                if (val.photo) {
                    photo = val.photo;
                } else {
                    photo = placeholderImage;
                }


                if (val.hasOwnProperty('discount') && val.discount != '' && val.discount != '0') {
                    var dis_price = '';
                    var or_price = '';
                    val.price = parseFloat(val.price);
                    val.disPrice = parseFloat(val.discount);
                    var dis_price = parseFloat(parseFloat(val.price) * parseFloat(val.disPrice)) / 100;

                    dis_price = val.price - dis_price;

                    product_badge = "-" + val.discount + "%";
                    if (currencyAtRight) {
                        or_price = val.price.toFixed(decimal_degits) + "" + currentCurrency;
                        dis_price = dis_price.toFixed(decimal_degits) + "" + currentCurrency;
                    } else {
                        or_price = currentCurrency + "" + val.price.toFixed(decimal_degits);
                        dis_price = currentCurrency + "" + dis_price.toFixed(decimal_degits);
                    }
                

                } else {
                    var or_price = '';
                    val.price = parseFloat(val.price);
                    if (currencyAtRight) {
                        or_price = val.price.toFixed(decimal_degits) + "" + currentCurrency;
                    } else {
                        or_price = currentCurrency + "" + val.price.toFixed(decimal_degits);
                    }
                

                }

                html = html + '<div class="member-plan position-absolute"><span class="badge badge-dark open">' + product_badge + '</span></div><a href="' + view_product_details + '"><img alt="#" src="' + photo + '"  onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'" class="img-fluid item-img w-100"></a><div class="product-badge">\n' +
                    ' </div></div><div class="py-2 position-relative">' +
                    '<div class="rating-info ml-auto d-flex">';

                html = html + '</div>' +
                    '<div class="list-card-body"><h6 class="mb-1 popul-title"><a href="' + view_product_details + '" class="text-black">' + val.name + '</a></h6>';

                if (dis_price == 0 || dis_price == null || dis_price == ' ' || dis_price == undefined) {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' + or_price + '</h6>';
                }
                else {
                    html = html + '<div class="car-det-price ml-auto"><h6 class="text-gray mb-1">' + dis_price + '  <s>' + or_price + '</s></h6>';
                }
                html = html + '</div></div></div>';
                html = html + '</div></div>';
                if (count == 4) {

                    html = html + '</div>';

                    count = 0;

                }
            });

        }
        return html;
    }


</script>