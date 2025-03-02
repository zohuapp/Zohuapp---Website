<?php
if (@$order_complete) { ?>

<div class="d-flex siddhi-cart-item-profile bg-white p-3">

    <p>{{trans('lang.your_order_placed_successfully')}}</p>

</div>

<?php } ?>

<?php $item_count = 0;
$total_price = 0;
$total_item_price = 0;

if (@$cart['item']) {


  ?>

<div class="sidebar-header p-3">
    <h3 class="font-weight-bold h6 w-100">{{trans('lang.cart')}}</h3>
</div>

<div class="bg-white p-3 sidebar-item-list">

    <h6 class="pb-3">{{trans('lang.item')}}</h6>

    <input type="hidden" name="main_vendor_id" value="" id="main_vendor_id">

   <?php    foreach ($cart['item'] as $key1 => $value_item) {
        $item_count++;?>


    <div class="product-item gold-members row align-items-center py-2 border mb-2 rounded-lg m-0"
         id="item_<?php        echo @$key1; ?>" data-id="<?php        echo @$key1; ?>">

        <input type="hidden" id="price_<?php        echo @$key1; ?>"
               value="<?php        echo floatval($value_item['price']) ?>">

        <input type="hidden" id="dis_price_<?php        echo @$key1; ?>"
               value="<?php        echo floatval($value_item['dis_price']); ?>">

        <input type="hidden" id="product_discount_<?php        echo @$key1; ?>"
               value="<?php        echo floatval($value_item['discount']); ?>">

        <input type="hidden" id="item_price_<?php        echo @$key1; ?>"
               value="<?php        echo floatval($value_item['item_price']);?>">


        <input type="hidden" id="photo_<?php        echo @$key1; ?>" value="<?php        echo $value_item['image']; ?>">

        <input type="hidden" id="name_<?php        echo @$key1; ?>" value="<?php        echo @$value_item['name']; ?>">

        <input type="hidden" id="quantity_<?php        echo @$key1; ?>" value="<?php        echo $value_item['quantity']; ?>">

        <input type="hidden" id="variant_info_<?php        echo @$key1; ?>"
               value="<?php        echo @$value_item['variant_info'] ? base64_encode(json_encode($value_item['variant_info'])) : ''; ?>">

        <input type="hidden" id="category_id_<?php        echo @$key1; ?>" value="<?php        echo $value_item['category_id']; ?>">

        <input type="hidden" id="description_<?php        echo @$key1; ?>" value="<?php        echo $value_item['description']; ?>">

        <input type="hidden" id="hsn_code_<?php        echo @$key1; ?>" value="<?php        echo $value_item['hsn_code']; ?>">

        <input type="hidden" id="unit_<?php        echo @$key1; ?>" value="<?php        echo $value_item['unit']; ?>">


        <div class="media align-items-center col-md-6">

            <div class="media-body">

                <div class="m-0 product-name">

                   <?php
        if (isset($value_item['variant_info']) && !empty($value_item['variant_info'])) {
            if (!empty($value_item['variant_info']['variant_image'])) {

                echo '<img src="' . $value_item['variant_info']['variant_image'] . '" class="img-responsive img-rounded" style="max-height: 40px; max-width: 25px;">';

            }

        } else {
            echo '<img src="' . $value_item['image'] . '" class="img-responsive img-rounded" style="max-height: 40px; max-width: 25px;">';

        }

                    ?>

                   <?php        echo $value_item['name']; ?>

                </div>


               <?php
        if (isset($value_item['variant_info']) && !empty($value_item['variant_info'])) {
            echo '<div class="variant-info">';
            echo '<ul>';
            foreach ($value_item['variant_info']['variant_options'] as $label => $value) {
                echo '<li class="variant"><span class="label">' . $label . '</span>&nbsp;<span class="value">' . $value . '</span></li>';
            }
            echo '</ul>';
            echo '</div>';
        }
                ?>
            </div>

        </div>

        <div class="d-flex align-items-center count-number-box col-md-5">

											<span class="count-number float-right">

												<button type="button" data-vendor=""
                                                        data-id="<?php        echo $key1; ?>"

                                                       <?php        if (isset($value_item['variant_info']) && !empty($value_item['variant_info'])) {
            $varient_qty = $value_item['variant_info']['variant_qty'];
                                                        ?>
                                                        data-vqty="<?php            echo $varient_qty; ?>"
                                                        data-vqtymsg="{{trans('lang.invalid_stock_qty')}}"
                                                       <?php        } else { ?>
                                                        data-vqty="<?php            echo $value_item['stock_quantity']; ?>"
                                                        data-vqtymsg="{{trans('lang.invalid_stock_qty')}}"
                                                       <?php        } ?>

                                                        class="count-number-input-cart btn-sm left dec btn btn-outline-secondary">

													<i class="feather-minus"></i>

												</button>

												<input class="count-number-input count_number_<?php        echo $key1; ?>"
                                                       type="text" readonly
                                                       value="<?php        echo $value_item['quantity']; ?>">

												<button type="button" data-vendor=""
                                                        data-id="<?php        echo $key1; ?>"

                                                       <?php        if (isset($value_item['variant_info']) && !empty($value_item['variant_info'])) {
            $varient_qty = $value_item['variant_info']['variant_qty'];
                                                        ?>
                                                        data-vqty="<?php            echo $varient_qty; ?>"
                                                        data-vqtymsg="{{trans('lang.invalid_stock_qty')}}"
                                                       <?php        } else { ?>
                                                        data-vqty="<?php            echo $value_item['stock_quantity']; ?>"
                                                        data-vqtymsg="{{trans('lang.invalid_stock_qty')}}"
                                                       <?php        } ?>

                                                        class="count-number-input-cart btn-sm right inc btn btn-outline-secondary count_number_right"
                                                        data-vendor-id="">

													<i class="feather-plus"></i>

												</button></span>

            <p class="text-gray mb-0 float-right ml-3 text-muted small">
                <span class="currency-symbol-left"></span>
                <span class="cart_iteam_total_<?php        echo $key1; ?>">

                   <?php        $totalItemPrice = @floatval($value_item['price']);
        $digit_decimal = 0;

        if (@$cart['decimal_degits']) {
            $digit_decimal = $cart['decimal_degits'];
        }
        echo number_format($totalItemPrice, $digit_decimal);
                    ?>
                </span>
                <span class="currency-symbol-right"></span>
            </p>

        </div>

        <div class="close remove_item col-md-1"
             data-vendor-id="" data-id="<?php        echo $key1; ?>"><i
                class="fa fa-times"></i></div>

    </div>

   <?php        $total_price = $total_price + (floatval($value_item['price']));
    } ?>




   <?php
    } ?>
   <?php $total_item_price = $total_price; ?>
</div>


<div class="bg-white px-3 clearfix">

    <div class="pb-3">
        <div class="input-group-sm mb-2 input-group">

            <input placeholder="{{trans('lang.promo_help')}}" data-restaurant="<?php echo @$key1; ?>"
                   data-vendor-id=""
                   value="<?php echo @$cart['coupon']['coupon_code'] ?>" id="coupon_code" type="text"
                   class="form-control">

            <div class="input-group-append">

                <button type="button" class="btn btn-primary remove_hover" id="apply-coupon-code"
                        data-vendor-id="">

                    <i class="feather-percent"></i> {{trans('lang.apply')}}

                </button>

            </div>

        </div>
    </div>
</div>

<div class="bg-white px-3 clearfix">

    <div class="border-bottom pb-3">
        <i class="feather-clock mr-2"></i>{{trans('lang.delivery_in')}}
       <?php
echo @$cart['estimatedTime'];
                ?>

    </div>
</div>
<?php if ($item_count == 0) { ?>

<div class="bg-white border-bottom py-2">

    <div class="gold-members d-flex align-items-center justify-content-between px-3 py-2 border-bottom">
        <span>{{trans('lang.your_cart_is_empty')}}</span>

    </div>

</div>

<?php } ?>

<div class="bg-white p-3 clearfix btm-total">

    <p class="mb-2">
        {{trans('lang.sub_total')}}
        <span class="float-right">
        	<span class="currency-symbol-left"></span>
        	<?php
$digit_decimal = 0;
if (@$cart['decimal_degits']) {
    $digit_decimal = $cart['decimal_degits'];
}
echo number_format($total_price, $digit_decimal);
            ?>
           	<span class="currency-symbol-right"></span>
        </span>
    </p>

   <?php  $discount_amount = 0;
$coupon_id = '';
$coupon_code = '';
$discount = '';
$discountType = '';
$isEnabled = '';
$desc = '';

if (@$cart['coupon'] && $cart['coupon']['discountType']) { ?>
    <hr>

    <p class="mb-1">
       <?php    $discountType = $cart['coupon']['discountType'];

    $coupon_code = $cart['coupon']['coupon_code'];

    $coupon_id = @$cart['coupon']['coupon_id'];

    $discount = $cart['coupon']['discount'];

    if ($discountType == "Fix Price") {

        $discount_amount = $cart['coupon']['discount'];
        $total = $total_price - $discount_amount;

        if ($total < 0) {

            $total = 0;

        }

        if ($discount_amount > $total) {

            $discount_amount = $total;

        }


    } else {

        $discount_amount = $cart['coupon']['discount'];
        $discount_amount = ($total_item_price * $discount) / 100;
        $total = $total_price - $discount_amount;
        if ($total < 0) {
            $total = 0;
        }
        if ($discount_amount > $total) {
            $discount_amount = $total;
        }


    }
        ?>
        <!-- this is begin of code -->
       <?php
    $total_discount_val = $cart['coupon']['discount'];
    $offerType = $cart['coupon']['discountType'];
    $total_discount_html = "";
    if ($offerType == "Percentage") {
        $total_discount_html = "( " . $total_discount_val . " %)";
    }
        ?>
        <!-- this is for total discount display code  -->
        {{ trans('lang.total') }} {{trans('lang.discount')}}<?php    echo $total_discount_html ?>
        <span class="float-right" style="color:red">( -
            <span
                class="currency-symbol-left"></span>
               <?php
    $digit_decimal = 0;
    if (@$cart['decimal_degits']) {
        $digit_decimal = $cart['decimal_degits'];
    }

    echo number_format(floatval($discount_amount), $digit_decimal);
                ?>
            <span class="currency-symbol-right"></span>)</span>

    </p>

   <?php } else { ?>

			<?php    $total = $total_price; ?>

	<?php } ?>


    <input type="hidden" id="discount_amount" value="<?php echo $discount_amount; ?>">

    <input type="hidden" id="coupon_id" value="<?php echo $coupon_id; ?>">

    <input type="hidden" id="coupon_code_main" value="<?php echo $coupon_code; ?>">

    <input type="hidden" id="discount" value="<?php echo $discount; ?>">

    <input type="hidden" id="discountType" value="<?php echo $discountType; ?>">

    <input type="hidden" id="isEnabled" value="">

    <input type="hidden" id="desc" value="">


   <?php

$total_item_price = $total_item_price - $discount_amount;

if ($item_count && $total_price && $cart['tax'] && @$cart['taxValue']) { ?>
    <hr>

   <?php

    foreach ($cart['taxValue'] as $val) {?>
    <p class="mb-2"><?php        echo $val['title'];?>
       <?php        if ($val['type'] == 'fix') { ?>
        ( <span class="currency-symbol-left"></span>
       <?php
            $digit_decimal = 0;
            if (@$cart['decimal_degits']) {
                $digit_decimal = $cart['decimal_degits'];
            }
            echo number_format($val['tax'], $digit_decimal);
            $tax = $val['tax'];
        ?>
        <span class="currency-symbol-right"></span> )
       <?php        } else {
            $tax = ($val['tax'] * $total_item_price) / 100;?>

        (<?php            echo $val['tax']; ?>%)
       <?php        } ?>

       <?php ?>

        <span class="float-right text-dark">
         	<span class="currency-symbol-left"></span>
         	<?php
        $digit_decimal = 0;
        if (@$cart['decimal_degits']) {
            $digit_decimal = $cart['decimal_degits'];
        }
        echo number_format($tax, $digit_decimal);
            ?>
            <span class="currency-symbol-right"></span>
        </span>

    </p><?php
        $total = $total + $tax;
    }

} ?>

    <input type="hidden" id="tax_label" value="<?php echo @$cart['tax_label']; ?>">

    <input type="hidden" id="tax" value="<?php echo @$cart['tax']; ?>">

    <hr>
    <p class="mb-2">

        {{trans('lang.deliveryCharge')}} <span class="float-right text-dark"><span
                class="currency-symbol-left"></span>


           <?php

$digit_decimal = 0;

if (@$cart['decimal_degits']) {
    $digit_decimal = $cart['decimal_degits'];
}
if ($item_count && $total_price && @$cart['deliverycharge']) {

    $total = $total + $cart['deliverycharge'];

    echo number_format(@$cart['deliverycharge'], $digit_decimal);

} else {
    echo number_format(0, $digit_decimal);
}

            ?>
           <?php  if ($item_count && $total_price && @$cart['deliverycharge']) { ?>

        <span
            class="currency-symbol-right"></span><?php    if (@$cart['deliverykm']) { ?>(<?php        echo round($cart['deliverykm'], 2); ?>Km)<?php    } ?></span>

       <?php }?>
    </p>


    <input type="hidden" value="<?php echo @$cart['deliverycharge']; ?>" id="deliveryCharge">

    <input type="hidden" value="<?php echo @$cart['estimatedTime']; ?>" id="estimatedTime">

    <input type="hidden" value="" id="deliveryChargeMain">

    <input type="hidden" id="total_pay" value="<?php echo round($total, 2); ?>">

    <hr>

    <h6 class="font-weight-bold mb-0">{{trans('lang.total')}}
        <p class="float-right">
            <span class="currency-symbol-left"></span>
            <span>
    			<?php
$digit_decimal = 0;
if (@$cart['decimal_degits']) {
    $digit_decimal = $cart['decimal_degits'];
}
echo number_format($total, $digit_decimal);
                ?>
            </span>
            <span class="currency-symbol-right"></span>
        </p>
    </h6>
</div>

<div class="p-3">

   <?php
if (@$cart['decimal_degits']) {
    $digit_decimal = $cart['decimal_degits'];
}
if ($item_count == 0) {    ?>

    <a class="btn btn-primary btn-block btn-lg disable remove_hover" href="javascript:void(0)">{{trans('lang.pay')}} <span
            class="currency-symbol-left"></span><?php    echo number_format($total, $digit_decimal); ?><span
            class="currency-symbol-right"></span><i
            class="feather-arrow-right"></i></a>

   <?php } else if (@$is_checkout) { ?>

    <a class="btn btn-primary btn-block btn-lg remove_hover" href="javascript:void(0)"
       onclick="finalCheckout()">{{trans('lang.pay')}} <span
            class="currency-symbol-left"></span><?php        echo number_format($total, $digit_decimal); ?>
        <span class="currency-symbol-right"></span><i class="feather-arrow-right"></i></a>

   <?php    } else { ?>

    <a class="btn btn-primary btn-block btn-lg remove_hover" href="{{route('checkout')}}">{{trans('lang.pay')}} <span
            class="currency-symbol-left"></span><?php        echo number_format($total, $digit_decimal); ?><span
            class="currency-symbol-right"></span><i
            class="feather-arrow-right"></i></a>

   <?php    } ?>

</div>
