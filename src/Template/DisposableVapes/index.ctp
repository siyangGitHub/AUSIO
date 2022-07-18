<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DisposableVape[]|\Cake\Collection\CollectionInterface $disposableVapes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Disposable Vape'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vape Flavors'), ['controller' => 'vape-flavors', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="disposableVapes index large-9 medium-8 columns content">
    <h3><?= __('Disposable Vapes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" style="width: 30%"><?= $this->Paginator->sort('product') ?></th>
                <th scope="col" style="width: 10%"><?= $this->Paginator->sort('box_size') ?></th>
                <th scope="col" style="width: 10%"><?= $this->Paginator->sort('price') ?></th>
                <th scope="col" style="width: 15%"><?= $this->Paginator->sort('price_for_3') ?></th>
                <th scope="col" style="width: 10%"><?= $this->Paginator->sort('wholesale') ?></th>
                <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($disposableVapes as $disposableVape): ?>
            <tr>
                <td><?= $disposableVape->disposable_vape_brand." ".$disposableVape->disposable_vape_variant ?></td>
                <td><?= $disposableVape->disposable_vape_box_size ?></td>
                <td>$ <?= number_format($disposableVape->disposable_vape_price,2) ?></td>
                <td>$ <?= number_format($disposableVape->disposable_vape_price_for_3,2) ?></td>
                <td>$ <?= number_format($disposableVape->disposable_vape_wholesale_price,2) ?></td>
                <td><?= h($disposableVape->disposable_vape_description) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $disposableVape->disposable_vape_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $disposableVape->disposable_vape_id], ['confirm' => __('Are you sure you want to delete # {0}?', $disposableVape->disposable_vape_id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
