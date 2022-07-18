<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\VapeFlavor $vapeFlavor
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vape Flavor'), ['action' => 'edit', $vapeFlavor->vape_flavors_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vape Flavor'), ['action' => 'delete', $vapeFlavor->vape_flavors_id], ['confirm' => __('Are you sure you want to delete # {0}?', $vapeFlavor->vape_flavors_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Vape Flavors'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vape Flavor'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Disposable Vapes'), ['controller' => 'DisposableVapes', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Disposable Vape'), ['controller' => 'DisposableVapes', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="vapeFlavors view large-9 medium-8 columns content">
    <h3><?= h($vapeFlavor->vape_flavors_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Disposable Vape') ?></th>
            <td><?= $vapeFlavor->has('disposable_vape') ? $this->Html->link($vapeFlavor->disposable_vape->disposable_vape_id, ['controller' => 'DisposableVapes', 'action' => 'view', $vapeFlavor->disposable_vape->disposable_vape_id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vape Flavors Name') ?></th>
            <td><?= h($vapeFlavor->vape_flavors_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vape Image') ?></th>
            <td><?= h($vapeFlavor->vape_image) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vape Image Color') ?></th>
            <td><?= h($vapeFlavor->vape_image_color) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vape Flavors Id') ?></th>
            <td><?= $this->Number->format($vapeFlavor->vape_flavors_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vape Stock') ?></th>
            <td><?= $this->Number->format($vapeFlavor->vape_stock) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vape Status') ?></th>
            <td><?= $this->Number->format($vapeFlavor->vape_status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Vape Sold') ?></th>
            <td><?= $this->Number->format($vapeFlavor->vape_sold) ?></td>
        </tr>
    </table>
</div>
