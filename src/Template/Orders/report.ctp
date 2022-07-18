<style>
    #records-container {
        padding: 5% 10%;
    }

    #records-table {
        border: 1px solid gray;
    }

    .products {
        white-space: nowrap;
    }
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div id="records-container">
    <table id="report-table">
        <thead>
        <tr>
            <th style="width: 70%">Product</th>
            <th style="width: 10%">Quantity</th>
            <th style="width: 10%">Total Price</th>
            <th style="width: 10%">Total Profit</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <td>Subtotal</td>
            <td id="quantity-total"></td>
            <td>$<span id="price-total"></span></td>
            <td>$<span id="profit-total"></span></td>
        </tr>
        </tfoot>
    </table>
</div>
<div id="piechart" style="width: 900px; height: 500px;"></div>

<script>
    let orderDetailArray = '<?php echo $orderDetailArray; ?>';
    orderDetailArray = JSON.parse(orderDetailArray);
    let result = [];
    orderDetailArray.reduce(function (res, value) {
        if (!res[value.vapeProductName]) {
            res[value.vapeProductName] = {
                vapeProductName: value.vapeProductName,
                stock_record_quantity: 0,
                stock_record_price: 0,
                order_profit: 0,
            };
            result.push(res[value.vapeProductName])
        }
        res[value.vapeProductName].stock_record_quantity += parseInt(value.stock_record_quantity);
        res[value.vapeProductName].stock_record_price += value.stock_record_price*value.stock_record_quantity;
        res[value.vapeProductName].order_profit += value.order_profit*value.stock_record_quantity;

        return res;
    }, {});

    let pieChartArray=[];

    result.sort((a, b) => (a.vapeProductName > b.vapeProductName) ? 1 : -1);
    let quantityTotal = 0;
    let priceTotal = 0;
    let profitTotal = 0;
    let vapeVariantCounter = 0;
    let vapeVariantPrice = 0;
    let vapeVariantProfit = 0;
    for (let i = 0; i < result.length; i++) {
        $("#report-table tbody").append("<tr>" +
            "<td class='products'>" + result[i].vapeProductName + "</td>" +
            "<td class='quantity'>" + result[i].stock_record_quantity + "</td>" +
            "<td>$<span class='price'>" + parseFloat(result[i].stock_record_price).toFixed(2) + "</span></td>" +
            "<td>$<span class='profit'>" + parseFloat(result[i].order_profit).toFixed(2) + "</span></td>" +
            "</tr>");
        vapeVariantCounter+=result[i].stock_record_quantity;
        vapeVariantPrice+=result[i].stock_record_price;
        vapeVariantProfit+=result[i].order_profit;
        let splitName = result[i].vapeProductName.split("-");
        let vapeProduct = splitName[0] + "-" + splitName[1];
        if(result[i + 1]){
            let nextSplitName = result[i + 1].vapeProductName.split("-");
            let nextVapeProduct = nextSplitName[0] + "-" + nextSplitName[1];
            if (vapeProduct !== nextVapeProduct) {
                $("#report-table tbody").append("<tr style='font-weight: bold'>" +
                    "<td>" + vapeProduct + "</td>" +
                    "<td>" + vapeVariantCounter + "</td>" +
                    "<td>$" + parseFloat(vapeVariantPrice).toFixed(2) + "</td>" +
                    "<td>$" + parseFloat(vapeVariantProfit).toFixed(2) + "</td>" +
                    "</tr>");
                pieChartArray.push([vapeProduct, vapeVariantCounter]);
                vapeVariantCounter = 0;
                vapeVariantPrice = 0;
                vapeVariantProfit = 0;
            }
        }
        else{
            $("#report-table tbody").append("<tr style='font-weight: bold'>" +
                "<td>" + vapeProduct + "</td>" +
                "<td>" + vapeVariantCounter + "</td>" +
                "<td>$" + parseFloat(vapeVariantPrice).toFixed(2) + "</td>" +
                "<td>$" + parseFloat(vapeVariantProfit).toFixed(2) + "</td>" +
                "</tr>");
            pieChartArray.push([vapeProduct, vapeVariantCounter]);

        }

        quantityTotal += result[i].stock_record_quantity;
        priceTotal += result[i].stock_record_price;
        profitTotal += result[i].order_profit;
    }
    $("#quantity-total").text(quantityTotal);
    $("#price-total").text(parseFloat(priceTotal).toFixed(2));
    $("#profit-total").text(parseFloat(profitTotal).toFixed(2));

    $("#report-table").DataTable({
        "paging": false
    });

    pieChartArray.unshift(['Vape Flavor', 'Quantity Sold'])
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);



    function drawChart() {
        var data = google.visualization.arrayToDataTable(pieChartArray);
        var options = {
            title: 'Quantity Sold'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

</script>
