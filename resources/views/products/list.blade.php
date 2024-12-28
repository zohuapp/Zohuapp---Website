@include('layouts.app')

@include('layouts.header')

<div class="st-brands-page pt-5 category-listing-page <?php echo $type; ?>">

    <div class="container">

        <div class="d-flex align-items-center mb-3 page-title">

            <h3 class="font-weight-bold text-dark" id="title"></h3>

        </div>

        <div class="row">

            <div class="col-md-3">
                <div id="category-list"></div>
                <div id="brands-list"></div>
                <div id="attributes-list"></div>
            </div>

            <div class="col-md-9">
                <div id="product-list"></div>
            </div>

        </div>

    </div>

</div>

@include('layouts.footer')


<script type="text/javascript">

    var type = '<?php echo $type; ?>';
    var id = '<?php echo $id; ?>';

    var idRef = database.collection('vendor_categories').doc(id);
    var catsRef = database.collection('vendor_categories').where('publish', '==', true);
    var brandsRef = database.collection('brands').where('is_publish', '==', true);
    var attrRef = database.collection('vendor_attributes');

    idRef.get().then(async function (idRefSnapshots) {
        var idRefData = idRefSnapshots.data();

        $("#title").text(idRefData.title + ' ' + "{{trans('lang.products')}}");
    })


    jQuery("#overlay").show();
    $(document).ready(function () {

        getCategories();
        getBrands();


        $(document).on("click", ".category-item, .brand-item, .attr-item ", function () {
            var checkboxes = document.querySelectorAll('.category-item');
            var brandcheckboxes = document.querySelectorAll('.brand-item');
            var attrcheckboxes = document.querySelectorAll('.attr-item');
            var checkedCategoryIds = [];
            var checkedBrandIds = [];
            var checkedAttrIds = [];
            checkboxes.forEach(function (cb) {
                var cat_id = ".category-item_" + cb.getAttribute('data-category-id');
                if (cb.checked) {
                    checkedCategoryIds.push(cb.getAttribute('data-category-id'));
                    $(cat_id).addClass('active')
                } else {
                    $(cat_id).removeClass('active')
                }
            });
            brandcheckboxes.forEach(function (cb) {
                var brand_id = ".brand-item_" + cb.getAttribute('data-brand-id');
                if (cb.checked) {
                    checkedBrandIds.push(cb.getAttribute('data-brand-id'));
                    $(brand_id).addClass('active')
                } else {
                    $(brand_id).removeClass('active')
                }
            });
            attrcheckboxes.forEach(function (cb) {
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

    })
    async function getCategories() {
        catsRef.get().then(async function (snapshots) {
            if (snapshots != undefined) {
                var html = '';
                html = buildCategoryHTML(snapshots);
                if (html != '') {
                    var append_list = document.getElementById('category-list');
                    append_list.innerHTML = html;
                    var category_id = $('#category-list .active').data('category-id');
                    if (category_id) {
                        getProducts(type, category_id);
                        jQuery("#overlay").hide();
                    }
                }
            }
        });
    }
    async function getBrands() {
        brandsRef.get().then(async function (snapshots) {
            if (snapshots != undefined) {
                var html = '';
                html = buildBrandHTML(snapshots);
                if (html != '') {
                    var append_list = document.getElementById('brands-list');
                    append_list.innerHTML = html;
                    jQuery("#overlay").hide();
                }
            }
        });
    }
    async function getAttributes() {
        attrRef.get().then(async function (snapshots) {
            if (snapshots != undefined) {
                var html = '';
                html = buildAttributeHTML(snapshots);
                if (html != '') {
                    var append_list = document.getElementById('attributes-list');
                    append_list.innerHTML = html;
                    jQuery("#overlay").hide();
                }
            }
        });
    }

    function buildCategoryHTML(snapshots) {
        var html = '';
        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        html = html + '<div class="vandor-sidebar">';
        html = html + '<h3>{{trans("lang.categories")}}</h3>';

        html = html + '<ul class="vandorcat-list">';
        alldata.forEach((listval) => {
            var val = listval;
            if (val.photo) {
                photo = val.photo;
            } else {
                photo = placeholderImage;
            }
            if (id == val.id) {
                html = html + '<li class="active category-item_' + val.id + ' " data-category-id="' + val.id + '" >';
                html = html + '<a href="javascript:void(0)"><input class="form-check-input category-item" type="checkbox" name="category-item" data-category-id="' + val.id + '" checked>';
            } else {
                html = html + '<li class="category-item_' + val.id + '" data-category-id="' + val.id + '">';
                html = html + '<a href="javascript:void(0)"><input class="form-check-input category-item" type="checkbox" name="category-item" data-category-id="' + val.id + '">';
            }
            html = html + '<span><img src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>' + val.title + '</a>';
            html = html + '</li>';
        });
        html = html + '</ul>';

        return html;
    }

    function buildBrandHTML(snapshots) {
        var html = '';
        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        html = html + '<div class="vandor-sidebar">';
        html = html + '<h3>{{trans("lang.brand")}}</h3>';

        html = html + '<ul class="vandorcat-list">';
        alldata.forEach((listval) => {
            var val = listval;
            if (val.photo) {
                photo = val.photo;
            } else {
                photo = placeholderImage;
            }
            if (id == val.id) {
                html = html + '<li class="active brand-item_' + val.id + ' " data-brand-id="' + val.id + '" >';
                html = html + '<a href="javascript:void(0)"><input class="form-check-input brand-item" type="checkbox" name="brand-item" data-brand-id="' + val.id + '" checked>';
            } else {
                html = html + '<li class="brand-item_' + val.id + '" data-brand-id="' + val.id + '">';
                html = html + '<a href="javascript:void(0)"><input class="form-check-input brand-item" type="checkbox" name="brand-item" data-brand-id="' + val.id + '">';
            }
            html = html + '<span><img src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>' + val.title + '</a>';
            html = html + '</li>';
        });
        html = html + '</ul>';

        return html;
    }

    function buildAttributeHTML(snapshots) {
        var html = '';
        var alldata = [];
        snapshots.docs.forEach((listval) => {
            var datas = listval.data();
            datas.id = listval.id;
            alldata.push(datas);
        });

        html = html + '<div class="vandor-sidebar">';
        html = html + '<h3>{{trans("lang.attributes")}}</h3>';

        html = html + '<ul class="vandorcat-list">';
        alldata.forEach((listval) => {
            var val = listval;
            if (val.photo) {
                photo = val.photo;
            } else {
                photo = placeholderImage;
            }
            if (id == val.id) {
                html = html + '<li class="active attr-item_' + val.id + ' " data-attr-id="' + val.id + '" >';
                html = html + '<a href="javascript:void(0)"><input class="form-check-input attr-item" type="checkbox" name="attr-item" data-attr-id="' + val.id + '" checked>';
            } else {
                html = html + '<li class="attr-item_' + val.id + '" data-attr-id="' + val.id + '">';
                html = html + '<a href="javascript:void(0)"><input class="form-check-input attr-item" type="checkbox" name="attr-item" data-attr-id="' + val.id + '">';
            }
            html = html + '<span><img src="' + photo + '" onerror="this.onerror=null;this.src=\'' + placeholderImage + '\'"></span>' + val.title + '</a>';
            html = html + '</li>';
        });
        html = html + '</ul>';

        return html;
    }

    async function getProducts(type, catId, checkedBrandIds, checkedAttrIds) {

        jQuery("#overlay").show();
        var product_list = document.getElementById('product-list');
        product_list.innerHTML = '';
        var html = '';


        var productsRef = database.collection('vendor_products').where("publish", "==", true);
        if (type == "Multiple" && ((Array.isArray(catId) && catId.length > 0) || (Array.isArray(checkedBrandIds) && checkedBrandIds.length > 0))) {
            $("#title").text("{{trans('lang.products')}}");
        } else {
            catId = id;
            var idRef = database.collection('vendor_categories').doc(id);
            idRef.get().then(async function (idRefSnapshots) {
                var idRefData = idRefSnapshots.data();
                $("#title").text(idRefData.title + ' ' + "{{trans('lang.products')}}");
            });
        }

        productsRef.get().then(async function (snapshots) {
            html = buildProductsHTML(snapshots, catId, checkedBrandIds, checkedAttrIds);
            if (html != '') {
                product_list.innerHTML = html;
                jQuery("#overlay").hide();
            }
        });
    }

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

</script>

@include('layouts.nav')
