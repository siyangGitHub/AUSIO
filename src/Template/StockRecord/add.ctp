<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockRecord $stockRecord
 */
echo $this->Html->css('add_stock_record');
?>

<nav class="large-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Stock Record'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vape Flavors'), ['controller' => 'VapeFlavors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vape Flavor'), ['controller' => 'VapeFlavors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stockRecord form large-10 columns content">
    <?= $this->Form->create($stockRecord, ['id' => 'stockRecordForm']) ?>
    <fieldset>
        <legend><?= __('Manage Stock') ?></legend>
        <table>
            <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col" style="width: 150px;">Price</th>
                <th scope="col">Flavors & Quantity</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($disposableVapes as $disposableVape) {
                $boxSize = $disposableVape->disposable_vape_box_size;
                ?>
                <tr>
                    <td><?php echo $disposableVape->disposable_vape_brand . " " . $disposableVape->disposable_vape_variant; ?></td>
                    <td>$ <input class="stock_record_price" type="number" step="0.01" value="0" ></td>
                    <td>
                        <?php foreach ($disposableVape->vape_flavors as $vapeFlavor) {
                            $flavorName = $vapeFlavor->vape_flavors_name;
                            ?>
                            <div class="flavors">
                                <input class="flavor-checkbox" type="checkbox"
                                       id="<?php echo $vapeFlavor->vape_flavors_id; ?>"
                                       value="<?php echo $flavorName; ?>">
                                <label
                                    for="<?php echo $flavorName; ?>"><?php echo $flavorName; ?></label>
                                <button class="minus" type="button" value="<?php echo $boxSize; ?>">
                                    -<?php echo $boxSize; ?></button>
                                <button class="minus" type="button" value="1">-</button>
                                <input type="number" class="flavors-quantity" value="0">
                                <button class="plus" type="button" value="1">+</button>
                                <button class="plus" type="button" value="<?php echo $boxSize; ?>">
                                    +<?php echo $boxSize; ?></button>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </fieldset>
    <input type="hidden" name="jsonSubmit" id="jsonSubmit"/>
    <button id="submit" type="submit" class="btn">Submit</button>
    <?= $this->Form->end() ?>
</div>
<script>
    $("#vape_flavors_id").select2();

    function verifyPrice(checkbox) {
        if (checkbox.is(':checked')) {
            let price = checkbox.parents('tr').find('.stock_record_price');
            if (parseInt(price.val()) === 0) {
                alert("Please provide price");
                checkbox.prop("checked", false);
                price.focus();
                return false;
            } else {
                checkbox.parent().find('.flavors-quantity').focus();
                return true;
            }
        } else {
            checkbox.parent().find('.flavors-quantity').val(0);
        }
    }

    $("input[type='text'],input[type='number']").on("focus", function () {
        $(this).select();
    });

    $(".flavor-checkbox").on('change', function () {
        verifyPrice($(this));
    })
    $("input[type='number']").on('change', function () {
        if (!$.isNumeric($(this).val())) {
            $(this).val(0);
        }
    })
    $(".minus").on('click', function () {
        let minus = $(this);
        let checkbox = minus.parent().find(".flavor-checkbox");
        checkbox.prop("checked", true);
        if (verifyPrice(checkbox)) {
            let quantity = minus.parent().find('.flavors-quantity');
            quantity.val(parseInt(quantity.val()) - parseInt(minus.attr('value')));
        }

    })
    $(".plus").on('click', function () {
        let plus = $(this);
        let checkbox = plus.parent().find(".flavor-checkbox");
        checkbox.prop("checked", true);
        if (verifyPrice(checkbox)) {
            let quantity = plus.parent().find('.flavors-quantity');
            quantity.val(parseInt(quantity.val()) + parseInt(plus.attr('value')));
        }
    })
    $("#submit").on('click', function () {
        let jsonSubmit = [];
        $(".flavor-checkbox:checkbox:checked").each(function () {
            let obj = {};
            let checkbox = $(this);
            let id = checkbox.attr('id');
            let price = checkbox.parents('tr').find(".stock_record_price").val();
            let quantity = checkbox.parent().find(".flavors-quantity").val();
            obj.vape_flavors_id = parseInt(id);
            obj.stock_record_price = parseFloat(price);
            obj.stock_record_quantity = parseInt(quantity);
            jsonSubmit.push(obj);
        })
        $("#jsonSubmit").val(JSON.stringify(jsonSubmit));
        if (jsonSubmit.length !== 0) {
            $("#stock_record_form").submit();
        } else {
            return false;
        }
    })
</script>
