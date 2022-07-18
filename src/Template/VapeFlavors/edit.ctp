<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VapeFlavor $vapeFlavor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $vapeFlavor->vape_flavors_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $vapeFlavor->vape_flavors_id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Vape Flavors'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Disposable Vapes'), ['controller' => 'DisposableVapes', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Disposable Vape'), ['controller' => 'DisposableVapes', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="vapeFlavors form large-9 medium-8 columns content">
    <?= $this->Form->create($vapeFlavor, ['enctype' => 'multipart/form-data']) ?>
    <fieldset>
        <legend><?= __('Edit Vape Flavor') ?></legend>
        <div>
            <label for="disposable_vape_id">Product</label>
            <select name="disposable_vape_id" id="disposable_vape_id">
                <?php
                foreach ($disposableVapes as $disposableVape){
                    ?>
                    <option
                        <?php if($disposableVape->disposable_vape_id == $vapeFlavor->disposable_vape_id){ echo "selected"; } ?>
                        value="<?php echo $disposableVape->disposable_vape_id; ?>">
                        <?php echo $disposableVape->disposable_vape_brand." ".$disposableVape->disposable_vape_variant; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <?php
        echo $this->Form->control('vape_flavors_name');
        echo $this->Form->control('vape_stock');
        echo $this->Form->control('vape_status');
        echo $this->Form->control('vape_sold');
        ?>
        <div>
            <label for="image">Image</label>
            <?php echo $this->Html->image('vapes/'.$vapeFlavor->vape_image); ?>
            <input id="image" name="image" type="file" />
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn']) ?>
    <?= $this->Form->end() ?>
</div>
