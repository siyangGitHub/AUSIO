<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
$this->layout = 'orderLayout';
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    .plus,.minus{
        width: auto;
        padding: 0 10px;
    }
</style>

<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
<a id="scroll"><i class="fas fa-arrow-circle-up fa-4x"></i></a>
<section class="hero-section brand">
    <div class="card-grid">
        <a class="card" brand="HQD">
            <div class="card__background"
                 style="background-image: url(https://image.made-in-china.com/2f0j00pMVGFjtlAsoc/Hot-Selling-Hqd-Cuvie-Plus-1200-Puffs-Disposable-Vape-Pen.jpg)"></div>
            <div class="card__content">
                <p class="card__category">Brand</p>
                <h3 class="card__heading">HQD</h3>
            </div>
        </a>
        <a class="card" brand="IGET">
            <div class="card__background"
                 style="background-image: url(https://www.igetvape.com/repository/image/9f7b97ff-84da-4e28-ab1d-8118ddfbf778.jpg)"></div>
            <div class="card__content">
                <p class="card__category">Brand</p>
                <h3 class="card__heading">IGET</h3>
            </div>
        </a>
        <div>
</section>
<section class="hero-section variant">
    <div class="card-grid">
        <?php
        foreach ($disposableVapes as $disposableVape) {
            ?>
            <a class="card"
               brand="<?php echo $disposableVape->disposable_vape->disposable_vape_brand; ?>"
               disposable_vape_id="<?php echo $disposableVape->disposable_vape_id; ?>">
                <div class="card__background"
                     style="background-image: url(<?php echo $this->Url->image("vapes/" . $disposableVape->vape_image); ?>)"></div>
                <div class="card__content">
                    <p class="card__category"><?php echo $disposableVape->disposable_vape->disposable_vape_brand; ?></p>
                    <h3 class="card__heading"><?php echo $disposableVape->disposable_vape->disposable_vape_variant; ?></h3>
                </div>
            </a>
            <?php
        }
        ?>
        <div>
</section>

<div class="orders">
    <?= $this->Form->create($order, ['id' => 'orderForm']) ?>
    <div class="vape-list container card-grid">
        <?php
        foreach ($vapeFlavors as $vapeFlavor) {
            ?>
            <div class="vape-product card"
                 disposable_vape_id="<?php echo $vapeFlavor->disposable_vape->disposable_vape_id; ?>"
                 brand="<?php echo $vapeFlavor->disposable_vape->disposable_vape_brand; ?>"
                 vape_flavors_id="<?php echo $vapeFlavor->vape_flavors_id; ?>">
                <div class="image">
                    <?php echo $this->Html->image('vapes/' . $vapeFlavor->vape_image, ['class' => 'vape-image']); ?>
                </div>
                <div
                    class="product" disposable_vape_id="<?php echo $vapeFlavor->disposable_vape_id; ?>"
                    vape_flavors_id="<?php echo $vapeFlavor->vape_flavors_id; ?>"
                    style="color: <?php echo $vapeFlavor->vape_image_color; ?>"
                ><?php echo $vapeFlavor->disposable_vape->disposable_vape_brand . " " . $vapeFlavor->disposable_vape->disposable_vape_variant . " - " . $vapeFlavor->vape_flavors_name; ?></div>
                <div>
                    <span
                        class="price">$<span
                            class="priceNumber"><?php echo number_format($vapeFlavor->disposable_vape->disposable_vape_wholesale_price, 2); ?></span></span>
                </div>
                <div class="quantity-button">
                    <button class="minus" type="button" quantity="<?php echo $vapeFlavor->disposable_vape->disposable_vape_box_size; ?>">
                        -<?php echo $vapeFlavor->disposable_vape->disposable_vape_box_size; ?>
                    </button>
                    <input style="width: 45px" class="quantity" value="0" type="number" />
                    <button class="plus" type="button" quantity="<?php echo $vapeFlavor->disposable_vape->disposable_vape_box_size; ?>">
                        +<?php echo $vapeFlavor->disposable_vape->disposable_vape_box_size; ?>
                    </button>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <input type="hidden" id="jsonOrderRecords" name="jsonOrderRecords"/>
    <?= $this->Form->end() ?>
</div>
<div id="cart" style="display: none">
    <div id="close-cart2"></div>
    <a id="close-cart"><i class="far fa-times-circle"></i></a>
    <h3>Your shopping cart</h3>
    <table id="cart-table">
        <tbody>

        </tbody>
    </table>
</div>
<div class="bottom-sticky">
    <span class="large-4 medium-4 small-6 columns">
        <a id="viewCart"><i class="fas fa-shopping-cart"></i></a><b id="quantityCounter">0</b> Item(s)
    </span>
    <span class="large-4 medium-4 small-6 columns">Total: $<b id="totalPrice">0.00</b></span>
    <span
        class="large-4 medium-4 small-12 columns">    <?= $this->Form->button(__('Submit'), ['class' => 'btn submit']) ?>
</span>

</div>
<script>

    let cart = localStorage.getItem('cart');
    if (cart === null) {
        cart = [];
    }
    $(".minus").on('click', function () {
        let minus = $(this);
        let quantity = minus.parent().find('.quantity');
        let size = parseInt(minus.attr('quantity'));
        if (parseInt(quantity.val()) - size < 0) {
            alert("Quantity cannot be negative!");
            quantity.val(0);
        } else {
            quantity.val(parseInt(quantity.val()) - size);
        }
    })
    $(".plus").on('click', function () {
        let plus = $(this);
        let quantity = plus.parent().find('.quantity');
        let size = parseInt(plus.attr('quantity'));

        let max = parseInt(quantity.attr("max"));
        quantity.val(parseInt(quantity.val()) + size);
    })
    $(".plus,.minus").on("click", function () {
        let plusMinus = $(this);
        let vapeProduct = plusMinus.parents('.vape-product');
        let vape_flavors_id = parseInt(vapeProduct.find('.product').attr('vape_flavors_id'));
        let disposable_vape_id = parseInt(vapeProduct.find('.product').attr('disposable_vape_id'));
        let vapeProductName = vapeProduct.find('.product').text();
        let stock_record_price = parseFloat(vapeProduct.find(".priceNumber").text());
        let stock_record_quantity = parseInt(vapeProduct.find(".quantity").val());
        let cartObj = {};
        cartObj.vape_flavors_id = vape_flavors_id;
        cartObj.disposable_vape_id = disposable_vape_id;
        cartObj.vapeProductName = vapeProductName;
        cartObj.stock_record_price = stock_record_price;
        cartObj.stock_record_quantity = stock_record_quantity;
        cartObj.product_original_price = stock_record_price;
        pushCart(cartObj);
        updateCart();
        $("#jsonOrderRecords").val(JSON.stringify(cart));
    })

    $(".quantity").on("keyup", function () {
        let quantity = $(this);
        let vapeProduct = quantity.parents('.vape-product');
        let vape_flavors_id = parseInt(vapeProduct.find('.product').attr('vape_flavors_id'));
        let disposable_vape_id = parseInt(vapeProduct.find('.product').attr('disposable_vape_id'));
        let vapeProductName = vapeProduct.find('.product').text();
        let stock_record_price = parseFloat(vapeProduct.find(".priceNumber").text());
        let stock_record_quantity = parseInt(vapeProduct.find(".quantity").val());
        let cartObj = {};
        cartObj.vape_flavors_id = vape_flavors_id;
        cartObj.disposable_vape_id = disposable_vape_id;
        cartObj.vapeProductName = vapeProductName;
        cartObj.stock_record_price = stock_record_price;
        cartObj.stock_record_quantity = stock_record_quantity;
        cartObj.product_original_price = stock_record_price;
        pushCart(cartObj);
        updateCart();
        $("#jsonOrderRecords").val(JSON.stringify(cart));
    })

    function pushCart(cartObj) {
        let counter = 0;
        for (let i = 0; i < cart.length; i++) {
            if (cart[i].vape_flavors_id === cartObj.vape_flavors_id) {
                cart.splice(i, 1);
                if (cartObj.stock_record_quantity !== 0) {
                    cart.push(cartObj);
                }
                counter++;
            }
        }
        if (counter === 0) {
            cart.push(cartObj);
        }
    }

    function updateCart() {
        let subTotal = 0.00;
        let quantityCounter = 0;
        let cartTable = $("#cart-table > tbody");
        cartTable.children().remove();
        for (let i = 0; i < cart.length; i++) {
            if (parseInt(cart[i].stock_record_quantity) !== 0) {
                cartTable.append("<tr>" +
                    "<td class='table-price'>$ " + cart[i].stock_record_price + "</td>" +
                    "<td class='table-name'>" + cart[i].vapeProductName + "</td>" +
                    "<td class='table-quantity'>" + cart[i].stock_record_quantity + "</td>" +
                    "<td><a class='remove-index' onclick=removeIndex(" + i + "," + cart[i].vape_flavors_id + ") ><i class='far fa-trash-alt fa-lg'></i></a></td>" +
                    "</tr>")

                quantityCounter += cart[i].stock_record_quantity;
                cart[i].total = (cart[i].stock_record_quantity * cart[i].stock_record_price).toFixed(2);
                subTotal += parseFloat(cart[i].total);
            }
            $("#quantityCounter").text(quantityCounter);
            $("#totalPrice").text((Math.round(subTotal * 10) / 10).toFixed(2));
        }
        return quantityCounter;
    }

    function removeIndex(index, vapeId) {
        cart.splice(index, 1);
        $(".vape-product[vape_flavors_id=" + vapeId + "]").find(".quantity").val(0);
        updateCart();
        $("#jsonOrderRecords").val(JSON.stringify(cart));
    }

    $("#viewCart").on('click', function () {
        $("#cart").toggle();
    })

    $("#close-cart, #close-cart2").on('click', function () {
        $("#cart").toggle();
    })


    $('.plus').on('click', function () {
        let viewcart = $('#viewCart');
        var imgtodrag = $(this).parents('.vape-product').find("img");
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                    top: imgtodrag.offset().top,
                    left: imgtodrag.offset().left
                })
                .css({
                    'opacity': '0.8',
                    'position': 'absolute',
                    'height': '150px',
                    'width': '150px',
                    'z-index': '100'
                })
                .appendTo($('body'))
                .animate({
                    'top': viewcart.offset().top + 10,
                    'left': viewcart.offset().left + 10,
                    'width': 75,
                    'height': 75
                }, 1500, 'easeInOutExpo');

            setTimeout(function () {
                viewcart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach()
            });
        }
    });

    $(".submit").on('click', function () {
        if (updateCart() !== 0) {
            $("#orderForm").submit();
        } else {
            alert("Maybe add something to your cart first?");
        }
    })

    $(".brand .card-grid .card").on('click', function () {
        let brand = $(this).attr('brand');
        $(".variant .card-grid .card").hide();
        $(".variant .card-grid .card[brand='" + brand + "']").show();
        let firstBrand = $(".variant .card-grid .card[brand='" + brand + "']").first();
        $([document.documentElement, document.body]).animate({
            scrollTop: firstBrand.offset().top - 100
        }, 1000);
        $(".brand .card-grid .card").removeClass('card-selected');
        $(this).addClass('card-selected');
        $(".vape-product").hide();
        let variantProduct = $(".vape-product[brand='" + brand + "']");
        variantProduct.show();
    })

    $(".variant .card-grid .card").on('click', function () {
        let variant = $(this).attr('disposable_vape_id');
        $(".vape-product").hide();
        let variantProduct = $(".vape-product[disposable_vape_id='" + variant + "']");
        variantProduct.show();
        let firstProduct = variantProduct.first();
        $([document.documentElement, document.body]).animate({
            scrollTop: firstProduct.offset().top - 50
        }, 1000);
        $(".variant .card-grid .card").removeClass('card-selected');
        $(this).addClass('card-selected');
    })

    $("#scroll").on('click', function () {
        $('html, body').animate({scrollTop: 0}, 'fast');
    })

</script>
