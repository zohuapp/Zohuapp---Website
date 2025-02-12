@include('layouts.app')

@include('layouts.header')

<div class="st-brands-page pt-5 category-listing-page">

    <div class="container section-content">


        <div class="row">

            <div class="col-md-12">
                <div id="product-list"></div>
            </div>

        </div>

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


<script type="text/javascript">
    var productsRef = database.collection('vendor_products').where("publish", "==", true);
    var vendorRadius = '';
    var vendorRadiusRef = database.collection('settings').doc("globalSettings");

    jQuery("#overlay").show();
    $(document).ready(async function() {
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
                getProductList();
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

    var product_list = document.getElementById('product-list');
    product_list.innerHTML = '';
    var html = '';
    async function getProductList() {
        productsRef.get().then(async function(snapshots) {
            html = buildProductsHTML(snapshots);
            if (html != '') {
                product_list.innerHTML = html;
                jQuery("#overlay").hide();
            }
        });
    }

    function buildProductsHTML(snapshots) {
        var html = '';
        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        if (alldata.length) {
            alldata = alldata.slice(0, 50);
        }

        var count = 0;
        var popularFoodCount = 0;
        html = html + '<div class="row">';

        if (alldata.length) {

            alldata.forEach((listval) => {
                var val = listval;

                html = html +
                    '<div class="col-md-3 pb-3 product-list"><div class="list-card position-relative"><div class="list-card-image">';

                if (val.photo) {
                    photo = val.photo;
                } else {
                    photo = placeholderImage;
                }

                var view_product_details = "{{ route('productDetail', ':id') }}";
                view_product_details = view_product_details.replace(':id', val.id);

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
                    product_badge + '</span></div><a href="' + view_product_details + '"><img alt="#" src="' +
                    photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage +
                    '\'" class="img-fluid item-img w-100"></a></div><div class="py-2 position-relative"><div class="list-card-body"><h6 class="mb-1"><a href="' +
                    view_product_details + '" class="text-black">' + val.name + '</a></h6>';

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
                } else {
                    html = html + '<span class="pro-price">' + dis_price + '  <s>' + or_price + '</s></span>';
                }

                html = html + '</div>';
                html = html + '</div></div></div>';

            });

        } else {
            html = html + "<h5>{{ trans('lang.no_results') }}</h5>";
        }

        html = html + '</div>';
        return html;
    }

    sortArrayOfObjects = (arr, key) => {
        return arr.sort((a, b) => {
            return b[key] - a[key];
        });
    };
</script>

@include('layouts.nav')
