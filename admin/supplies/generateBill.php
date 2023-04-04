<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT s.id, sp.supplier, p.product_name, s.price, s.quantity, s.total_amount, s.date_created, s.paid_amount,s.remaining_amount
    FROM supplies s 
    JOIN suppliers sp ON s.supplier = sp.id 
    JOIN products p ON s.product = p.id
    WHERE s.id = {$_GET['id']}
    ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<style>
    table,
    th,
    td {
        border: none;
        border-collapse: collapse;
        padding: 5px;
    }
</style>
<div class="container">
    <div class="container" id="printable">
        <div class="card w-50 text-white bg-white">
            <div class="container bg-secondary">
                <h4 class="ml-5">PETSHOP</h4>
                <span class="ml-5">SUPPY BILL</span>
            </div>
            <div class="card px-5 bg-white">
                <table>
                    <tr>
                        <th>Supplier:</th>
                        <td class="text-right">
                            <?php echo $supplier; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Product:</th>
                        <td class="text-right">
                            <?php echo $product_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Price:</th>
                        <td class="text-right">
                            <?php echo $price; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Quantity:</th>
                        <td class="text-right">
                            <?php echo $quantity; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Amount:</th>
                        <td class="text-right">
                            <?php echo $total_amount; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Paid Amount:</th>
                        <td class="text-right">
                            <?php echo $paid_amount; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Remaining Amount:</th>
                        <td class="text-right">
                            <?php echo $remaining_amount; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Date:</th>
                        <td class="text-right">
                            <?php echo $date_created; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="btn-container text-white text-center">
        <a class="btn btn-primary ml-2" href="?page=supplies/">Back</a>
        <button id="print-button" class="btn btn-primary ml-2" onclick="printDiv('printable')">Print</button>
    </div>
</div>

<script>
    function printDiv(divID) {
        var divElements = document.getElementById(divID).innerHTML;
        var oldPage = document.body.innerHTML;
        document.body.innerHTML =
            "<body>" +
            divElements + "</body>";
        // $('#prt').hide();
        var printStyle = document.createElement('style');
        printStyle.setAttribute('media', 'print');
        printStyle.innerHTML = '@page { size: 110mm 72mm; }';
        document.head.appendChild(printStyle);
        window.print();
        // $('#prt').show();
        document.body.innerHTML = oldPage;
    }

</script>