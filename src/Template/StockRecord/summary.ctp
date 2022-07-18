<div class="content">
    <h2>Item worth</h2>
    <table id="summary-table">
        <thead>
        <tr>
            <th>Brand</th>
            <th>Variant</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $result){
            echo "<tr>";
            echo "<td>".$result['brand']."</td>";
            echo "<td>".$result['variant']."</td>";
            echo "<td>".number_format($result['qty'],0)."</td>";
            echo "<td>$".number_format($result['price'],2)."</td>";
            echo "<td>$".number_format($result['total'],2)."</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
        <tfoot>
        <?php foreach($sums as $sum){ ?>
            <tr>
                <th>Total</th>
                <th></th>
                <th><?php echo $sum['total']; ?></th>
                <th></th>
                <th>$<?php echo $sum['price']; ?></th>
            </tr>
        <?php } ?>
        </tfoot>
    </table>
    <h2>Total worth</h2>
    <?php foreach($sums as $sum){
        echo 'Total sticks: '.$sum['total'];
        echo "<br/>";
        echo "Total cost: $".$sum['price'];
    }?>
</div>
<script>
    $("#summary-table").DataTable({
        "paging": false
    })
</script>
