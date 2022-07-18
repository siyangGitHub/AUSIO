<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->order_id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->order_id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->order_id)]) ?> </li>
        <li><?= $this->Html->link(__('List Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Order'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="orders view large-9 medium-8 columns content">
    <h3><?= h($order->order_id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Order Customer') ?></th>
            <td><?= h($order->order_customer) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Time') ?></th>
            <td><?= h($order->order_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Detail') ?></th>
            <td><?= h($order->order_detail) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Comment') ?></th>
            <td><?= h($order->order_comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Id') ?></th>
            <td><?= $this->Number->format($order->order_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Order Is Complete') ?></th>
            <td><?= $this->Number->format($order->order_is_complete) ?></td>
        </tr>
    </table>
</div>
