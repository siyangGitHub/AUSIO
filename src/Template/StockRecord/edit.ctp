<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockRecord $stockRecord
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stockRecord->stock_record_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stockRecord->stock_record_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stock Record'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Vape Flavors'), ['controller' => 'VapeFlavors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Vape Flavor'), ['controller' => 'VapeFlavors', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stockRecord form large-9 medium-8 columns content">
    <?= $this->Form->create($stockRecord) ?>
    <fieldset>
        <legend><?= __('Edit Stock Record') ?></legend>
        <div>
            <label for="vape_flavors_id">Flavors</label>
            <select name="vape_flavors_id" id="vape_flavors_id">
                <?php
                foreach ($vapeFlavors as $vapeFlavor){
                    ?>
                    <option
                        <?php if($stockRecord->vape_flavors_id == $vapeFlavor->vape_flavors_id){ echo "selected"; } ?>
                        value="<?php echo $vapeFlavor->vape_flavors_id; ?>">
                        <?php echo $vapeFlavor->disposable_vape->disposable_vape_brand." ".$vapeFlavor->disposable_vape->disposable_vape_variant." ".$vapeFlavor->vape_flavors_name; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <?php
            echo $this->Form->control('stock_record_price');
            echo $this->Form->control('stock_record_quantity');
            echo $this->Form->control('stock_record_stock_current');
            echo $this->Form->control('stock_record_time');
            echo $this->Form->control('stock_record_comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn']) ?>
    <?= $this->Form->end() ?>
</div>
