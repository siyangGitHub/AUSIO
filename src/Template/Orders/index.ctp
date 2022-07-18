<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order[]|\Cake\Collection\CollectionInterface $orders
 */

?>
<style>
    .dataTables_wrapper .dataTables_length select {
        padding: 10px;
    }

    input[type="search"] {
        width: 70%;
        display: inline;
    }

    #datepicker, #datepicker2 {
        width: auto;
        display: inline;
    }

    #datepicker-label {
        font-size: 15px;
        display: inline;
    }
    td{
        word-break: normal;
    }
</style>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Order'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('New Wholesale Order'), ['action' => 'create']) ?></li>
    </ul>
</nav>
<?php echo $this->Flash->render(); ?>
<div class="orders index large-10 medium-10 columns content">
    <h3><?= __('Orders') ?></h3>
    <?php echo $this->Form->create(null, ['url' => ['controller' => 'Orders', 'action' => 'report'], 'type' => 'post', 'id' => 'reportForm', 'target', '_blank']); ?>
    <div>
        <label id="datepicker-label" for="datepicker">Pick date(s): </label>
        <input type="text" id="datepicker" name="datepicker1"/>
        to
        <input type="text" id="datepicker2" name="datepicker2"/>
        <input type="hidden" id="type" name="type" />
        <button id="retail-submit" type="button">Retail</button>
        <button id="wholesale-submit" type="button">Wholesale</button>
    </div>
    <?php echo $this->Form->end(); ?>
    <table cellpadding="0" cellspacing="0" id="orders-table">
        <thead>
        <tr>
            <th scope="col" style="width: 5%">Customer</th>
            <th scope="col"  style="width: 15%">Time</th>
            <th scope="col" style="width: 50%">Detail</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= h($order->order_customer) ?></td>
                <td data-sort="<?php
                $time = strtotime(str_replace('/', '-',$order->order_time));
                echo date('Y/m/d', $time);
                ?>"><?= h($order->order_time) ?></td>
                <td><?php
                    $orderDetail = json_decode($order->order_detail);
                    foreach ($orderDetail as $orderItem) {
                        echo "$" . $orderItem->stock_record_price . " " . $orderItem->vapeProductName . " x " . $orderItem->stock_record_quantity;
                        echo "<br/>";
                    }
                    ?></td>
                <td class="actions" style="text-align: center">
                    <?php if($order->order_customer!=='Retail'&&$order->order_is_complete!=1) {echo $this->Form->postLink(__('Approve Wholesale'), ['action' => 'processOrder', $order->order_id], ['target' => '_blank', 'style' => 'word-break: break-word']);} ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $order->order_id], ['confirm' => __('Are you sure you want to delete this order?')]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div><?php echo $this->Form->postLink(__('Load all records'), ['action' => 'index', 'load-all'], ['class' => 'btn', 'style' => 'left: 25%']); ?></div>
<script>
    $("#orders-table").DataTable({
        "pageLength": 50,
        "order": [[ 1, "desc" ]]
    });
    $("#datepicker, #datepicker2").datepicker().datepicker('setDate', 'today').datepicker( "option", "dateFormat", "dd/mm/yy" );
    $("#datepicker").on('change', function (){
        $("#datepicker2").val($("#datepicker").val());
    })
    $("#retail-submit").on('click',function (){
        $("#type").val("retail");
        $("#reportForm").submit();
    })
    $("#wholesale-submit").on('click',function (){
        $("#type").val("wholesale");
        $("#reportForm").submit();
    })
</script>

