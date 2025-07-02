@include('layouts.app')

@include('layouts.header')

<div class="siddhi-popular">

    <div class="container">
        <div class="transactions-banner p-4 rounded">
            <h3 class="transactions-banner-title text-center font-weight-bold h4 text-capitalize">
                {{ trans('lang.coupons') }}</h3>
        </div>

        <div class="text-center py-5 not_found_div" style="display:none">
            <img src="{{ asset('img/no-result.png') }}">
        </div>

        <div style="display:none" class="coupon_code_copied_div mt-4 error_top text-center">
            <p>{{ trans('lang.coupon_code_copied') }}</p>
        </div>


        <div id="append_list1" class="res-search-list"></div>
        <div class="row fu-loadmore-btn">
            <a class="page-link loadmore-btn" href="javascript:void(0);" id="loadmore" onclick="moreload()"
                data-dt-idx="0" tabindex="0">{{ trans('lang.load_more') }}</a>
        </div>

    </div>
</div>


@include('layouts.footer')

@include('layouts.nav')

<script type="text/javascript">
    var newdate = new Date();
    var todaydate = new Date(newdate.setHours(23, 59, 59, 999));

    var ref = database.collection('coupons').where('isEnabled', '==', true).where('expiresAt', '>=', newdate).orderBy(
        "expiresAt").startAt(new Date());

    var pagesize = 10;
    var offest = 1;
    var end = null;
    var endarray = [];
    var start = null;
    var append_list = '';
    var totalPayment = 0;

    $(document).ready(function() {


        jQuery("#loadmore").hide();
        $("#overlay").show();
        append_list = document.getElementById('append_list1');
        append_list.innerHTML = '';

        ref.limit(pagesize).get().then(async function(snapshots) {

            // get the placeholder image URL
            const placeholderImage = await getPlaceholderImage();

            if (snapshots != undefined) {
                var html = '';
                html = buildHTML(snapshots, placeholderImage);
                jQuery("#overlay").hide();
                if (html != '') {
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
                    $(".not_found_div").show();
                }
            }

        });

    })


    function buildHTML(snapshots, placeholderImage) {
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
            var date = '';
            var time = '';
            if (val.hasOwnProperty('expiresAt') && val.expiresAt) {

                try {
                    date = val.expiresAt.toDate().toDateString();
                    time = val.expiresAt.toDate().toLocaleTimeString('en-US');
                } catch (err) {
                    date = '';
                    time = '';
                }
            }
            var price_val = '';

            if (currencyAtRight) {
                if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                    price_val = val.discount + "%";
                } else {
                    price_val = val.discount + "" + currentCurrency;
                }
            } else {
                if (val.discountType == 'Percent' || val.discountType == 'Percentage') {
                    price_val = val.discount + "%";
                } else {
                    price_val = currentCurrency + "" + val.discount;
                }
            }

            html = html +
                '<div class="transactions-list-wrap mt-4"><div class="bg-white px-4 py-3 border rounded-lg mb-3 transactions-list-view shadow-sm"><div class="gold-members d-flex align-items-center transactions-list">';


            if (val.hasOwnProperty('image') && val.image != '') {
                if (val.image) {
                    photo = val.image;
                } else {
                    photo = placeholderImage;
                }
                html = html +
                    '<img class="mr-3 rounded-circle img-fluid" style="width:65px;height:65px;"  src="' +
                    photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'">';
            } else {

                html = html +
                    '<img class="mr-3 rounded-circle img-fluid" style="width:65px;height:65px;" src="' +
                    placeholderImage + '">';
            }

            html = html + '<div class="media-body"><span class="offercoupan"><p class="mb-0 badge">' + val
                .code +
                '</p><a href="javascript:void(0)" onclick="copyToClipboard(`' + val.code +
                '`)"><i class="fa fa-copy"></i></a></span><div class="coupon-price-tag"><span class="price font-weight-bold h4"></span></div><p class="text-dark offer-des mt-2">' +
                val
                .description + '</p><br><span class="date"><strong>Expires At:</strong> ' + date + ' - ' +
                time +
                '</span>';

            html = html + '</div></div>';

            // html = html + '< class="coupon-price-tag"><span class="price font-weight-bold h4">' +
            //     price_val + '</span>';


            html = html + ' </div></div></div>  ';

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

    function copyToClipboard(text) {

        // navigator.clipboard.writeText("");
        navigator.clipboard.writeText(text);
        $(".coupon_code_copied_div").show();
        window.scrollTo(0, 0);

        setTimeout(
            function() {
                $(".coupon_code_copied_div").hide();
            }, 4000);

    }
</script>
