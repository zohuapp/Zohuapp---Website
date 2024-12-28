@include('layouts.app')


@include('layouts.header')

<div class="siddhi-favorites">

    <div class="container  py-5 section-content">
        <h2 class="font-weight-bold mb-3">{{trans('lang.favorite_products')}}</h2>
        <div class="text-center py-5 not_found_div d-none"><img src="{{asset('img/no-result.png')}}"></div>
        <div class="product-list">
        </div>

        <div id="append_list1" class="row"></div>
    </div>

    <div class="row fu-loadmore-btn section-content ">
        <a class="page-link loadmore-btn" href="javascript:void(0);" id="loadmore" onclick="moreload()" data-dt-idx="0"
            tabindex="0">{{trans('lang.load_more')}} </a>
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
</div>


@include('layouts.footer')

@include('layouts.nav')


<script type="text/javascript">

    var newdate = new Date();
    var todaydate = new Date(newdate.setHours(23, 59, 59, 999));
    var ref = database.collection('favorite_item').where('user_id', '==', user_uuid);
    var pagesize = 10;
    var offest = 1;
    var end = null;
    var endarray = [];
    var start = null;
    var append_list = '';

    var vendorRadius = '';
    var vendorRadiusRef = database.collection('settings').doc("globalSettings");
    var vendor_lat = getCookie('restaurant_latitude');
    var vendor_long = getCookie('restaurant_longitude');
    var address_lat = getCookie('address_lat');
    var address_lng = getCookie('address_lng');
    var place_image = '';
    var ref_placeholder_image = database.collection('settings').doc("placeHolderImage");
    ref_placeholder_image.get().then(async function (snapshots) {
        var placeimg = snapshots.data();
        place_image = placeimg.image;
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
                jQuery("#loadmore").hide();
                $("#overlay").show();
                append_list = document.getElementById('append_list1');
                append_list.innerHTML = '';

                ref.limit(pagesize).get().then(async function (snapshots) {

                    if (snapshots != undefined) {
                        var html = '';
                        html = buildHTML(snapshots);
                        jQuery("#overlay").hide();
                        
                        if (html != '') {
                            jQuery('.not_found_div').hide();
                            append_list.innerHTML = html;
                            start = snapshots.docs[snapshots.docs.length - 1];
                            endarray.push(snapshots.docs[0]);
                            $("#overlay").hide();
                            if (snapshots.docs.length < pagesize) {

                                jQuery("#loadmore").hide();
                            } else {
                                jQuery("#loadmore").show();
                            }
                        } else {
                            jQuery('.not_found_div').show();
                        }
                    }

                });

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


    })


    function buildHTML(snapshots) {
        var html = '';
        var alldata = [];
        var number = [];
        var vendorIDS = [];

        snapshots.docs.forEach((listval) => {
            var datas = listval.data();

            datas.id = listval.id;
            alldata.push(datas);
        });

        alldata.forEach((listval) => {

            var val = listval;
            if (val.photo) {
                photo = product.photo;
            } else {
                photo = placeholderImage;
            }
            if (val.product_id != undefined) {
                const product_name = productName(val.product_id);
            }

            html = html + '<div class="col-md-3 mb-3 product-list check-product-'+ val.product_id +'"><div class="list-card bg-white h-100 rounded overflow-hidden position-relative shadow-sm grid-card">';

            html = html + '<div class="list-card-image">';

            var fav = [val.user_id, val.product_id];
            html = html + '<div class="favourite-heart text-danger position-absolute"><a href="javascript:void(0);"  onclick="unFeveroute(`' + fav + '`)"><i class="fa fa-heart" style="color:red"></i></a></div>';

            html = html + '<a href="#" class="rurl_' + val.product_id + '"></a>';
            html = html + '</div>';

            html = html + '<div class="py-2 position-relative">';

            html = html + '<div class="list-card-body"><h6 class="mb-1"><a href="#" class="text-black rtitle_' + val.product_id + '"></a></h6>';

            html = html + '<span class="text-gray mb-0 pro-price rprice_' + val.product_id + '"></span>';

            html = html + '</div></div>';

            html = html + '</div></div>';


        });

        return html;

    }

    async function moreload() {
        if (start != undefined || start != null) {
            jQuery("#overlay").hide();

            listener = ref.startAfter(start).limit(pagesize).get();
            listener.then(async (snapshots) => {

                html = '';
                html = await buildHTML(snapshots);

                jQuery("#overlay").hide();
                if (html != '') {
                    append_list.innerHTML += html;
                    start = snapshots.docs[snapshots.docs.length - 1];

                    if (endarray.indexOf(snapshots.docs[0]) != -1) {
                        endarray.splice(endarray.indexOf(snapshots.docs[0]), 1);
                    }
                    endarray.push(snapshots.docs[0]);

                    if (snapshots.docs.length < pagesize) {

                        jQuery("#loadmore").hide();
                    } else {
                        jQuery("#loadmore").show();
                    }
                }
            });
        }
    }


    async function productName(productID) {

        var productName = '';
        var product_url = '';
        var product_photo = '';
        var product_price = '';
        var rating = 0;
        var reviewsCount = 0
        await database.collection('vendor_products').where("id", "==", productID).get().then(async function (snapshotss) {

            if (snapshotss.docs[0]) {

                var product = snapshotss.docs[0].data();
                productName = product.name;

                if (product.photo != '') {
                    product_photo = product.photo;
                } else {
                    product_photo = place_image;
                }
                product_url = "{{ route('productDetail', ':id')}}";
                product_url = product_url.replace(':id', product.id);
                product.price = parseFloat(product.price);
                if (currencyAtRight) {
                    var or_price = product.price.toFixed(decimal_degits) + "" + currentCurrency;
                } else {
                    var or_price = currentCurrency + "" + product.price.toFixed(decimal_degits);
                }

                if (product.hasOwnProperty('discount') && product.discount != '' && product.discount != '0') {
                    product.discountPrice = parseFloat(product.discount);
                    product.discountPrice = (product.price * product.discountPrice) / 100;
                    product.discountPrice = product.price - product.discountPrice;


                    if (currencyAtRight) {
                        var dis_price = product.discountPrice.toFixed(decimal_degits) + "" + currentCurrency;

                    } else {
                        var dis_price = currentCurrency + "" + product.discountPrice.toFixed(decimal_degits);
                    }

                    jQuery(".rprice_" + productID).html('<span>' + dis_price + '  <s>' + or_price + '</s></span>');

                } else {
                    jQuery(".rprice_" + productID).html('<span>' + or_price + '</span>');
                }


                if (product.hasOwnProperty('reviewsSum') && product.reviewsSum != 0 && product.hasOwnProperty('reviewsCount') && product.reviewsCount != 0) {
                    rating = (product.reviewsSum / product.reviewsCount);
                    rating = Math.round(rating * 10) / 10;
                    reviewsCount = product.reviewsCount;
                }

                jQuery(".rtitle_" + productID).html(productName);
                jQuery(".rtitle_" + productID).attr('href', product_url);
                jQuery(".rurl_" + productID).attr('href', product_url);
                jQuery(".rurl_" + productID).html('<img alt="#" src="' + product_photo + '" onerror="this.onerror=null;this.src=\'' + place_image + '\'" class="img-fluid item-img w-100 rimage_' + product.product_id + '">');
                jQuery(".rreview_" + productID).append(rating + '(' + reviewsCount + '+)');

            } else {
                
                $('.check-product-'+productID).remove();
               
            }
        });
        return productName;
    }

    async function unFeveroute(id) {
        var data = id.split(",");
        var user_id = data[0];
        var product_id = data[1];

        const doc = await database.collection('favorite_item').where('user_id', '==', user_id).where('product_id', '==', product_id).get();
        doc.forEach(element => {
            element.ref.delete().then(function (result) {
                window.location.href = '{{ url()->current() }}';
            });

        });
    }


</script>