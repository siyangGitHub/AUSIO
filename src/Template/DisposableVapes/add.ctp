<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DisposableVape $disposableVape
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Disposable Vapes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="disposableVapes form large-9 medium-8 columns content">
    <?= $this->Form->create($disposableVape) ?>
    <fieldset>
        <legend><?= __('Add Disposable Vape') ?></legend>
        <?php
            echo $this->Form->control('disposable_vape_brand');
            echo $this->Form->control('disposable_vape_variant');
            echo $this->Form->control('disposable_vape_box_size');
            echo $this->Form->control('disposable_vape_price');
            echo $this->Form->control('disposable_vape_price_for_3');
            echo $this->Form->control('disposable_vape_wholesale_price');
            echo $this->Form->control('disposable_vape_description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => 'btn']) ?>
    <?= $this->Form->end() ?>
</div>
