<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockRecord[]|\Cake\Collection\CollectionInterface $stockRecord
 */
?>
<style>
    .dataTables_wrapper .dataTables_length select{
        padding: 10px;
    }
    input[type="search"]{
        width: 70%;
        display: inline;
    }
    td{
        word-break: normal !important;
    }
</style>
<nav class="large-2 medium-2 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Stock Record'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Vape Flavors'), ['controller' => 'VapeFlavors', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('Stock Summary'), ['controller' => 'StockRecord', 'action' => 'summary']) ?></li>
    </ul>
</nav>
<div class="stockRecord index large-10 medium-10 columns content">
    <h3><?= __('Stock Records') ?></h3>
    <select id="brand-selector">
        <option value="all" selected>All brands</option>
        <?php foreach($vapeBrands as $vapeBrand){

            ?>
            <option value="<?php echo $vapeBrand->disposable_vape_brand. " ". $vapeBrand->disposable_vape_variant;?>">
                <?php echo $vapeBrand->disposable_vape_brand. " ". $vapeBrand->disposable_vape_variant;?>
            </option>
        <?php } ?>
    </select>
    <table cellpadding="0" cellspacing="0" id="records-table">
        <thead>
        <tr>
            <th scope="col" style="width: 40%;">Vape Flavors</th>
            <th scope="col" style="width: 10%;">Price</th>
            <th scope="col" style="width: 15%;">Quantity</th>
            <th scope="col" style="width: 15%;">Current</th>
            <th scope="col" style="width: 10%;">Time</th>
            <th scope="col" class="actions" style="width: 10%;">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($stockRecord as $stockRecord):
            foreach ($vapeFlavors as $vapeFlavor){
                if($stockRecord->vape_flavors_id == $vapeFlavor->vape_flavors_id){
                    $stockRecordVape = $vapeFlavor;
                }
            }
             ?>
            <tr>
                <td><?= $this->Html->link($stockRecordVape->disposable_vape->disposable_vape_brand . " " . $stockRecordVape->disposable_vape->disposable_vape_variant . " " . $stockRecord->vape_flavor->vape_flavors_name, ['controller' => 'VapeFlavors', 'action' => 'edit', $stockRecord->vape_flavor->vape_flavors_id], ['class' => 'flavorLink']); ?></td>
                <td>$<?= number_format($stockRecord->stock_record_price,2) ?></td>
                <td><?= $stockRecord->stock_record_quantity ?></td>
                <td><?= $stockRecord->stock_record_stock_current ?></td>
                <td data-sort="<?php
                $time = strtotime(str_replace('/', '-',$stockRecord->stock_record_time));
                echo date('Y-m-d', $time);
                ?>"><?= $stockRecord->stock_record_time ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $stockRecord->stock_record_id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $stockRecord->stock_record_id], ['confirm' => __('Are you sure you want to delete? Stock number will be returned.')]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    let stockRecordTable = $("#records-table").DataTable({
        "pageLength": 100,
        "order": [[ 4, "desc" ], [0, 'asc']]
    });
    $("#brand-selector").on('change', function (){
        let selectedVal = $("#brand-selector option:selected").val()
        if(selectedVal==="all"){
            stockRecordTable.search("").draw();
        }
        else{
            stockRecordTable.search(selectedVal).draw();
        }
    })
</script>
