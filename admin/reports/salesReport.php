<style>
    .btn-form {
        color: white !important;
        background-color: cornflowerblue !important;
    }
</style>

<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Sales Report</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="button-container">
                <button id="print-button" class="btn btn-form ml-2" onclick="printDiv('printable')">Print</button>
            </div>

            <div class="container-fluid" id="printable">
                <table class="table table-bordered table-stripped" id="cstRptTbl">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="5" class='tblheading'>
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div>
                                        <h3> Sales REPORT</h3>
                                    </div>
                                    <div>
                                        <h5 class=" mr-2">Date:
                                            <?php echo date('Y-m-d'); ?>
                                        </h5>
                                    </div>
                                </div>

                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Sold Quantity</th>
                            <th>Toatal Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalSales = 0;
                        $query = "SELECT p.product_name AS Product, SUM(ol.quantity) AS TotalQuantity, SUM(ol.quantity * ol.price) AS TotalSales, AVG(ol.price) AS Price FROM order_list ol JOIN products p ON ol.product_id = p.id GROUP BY p.product_name";
                        $i = 1;
                        $qry = $conn->query($query);
                        while ($row = $qry->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $row['Product'] ?>
                                </td>
                                <td>
                                    <?php echo $row['Price'] ?>
                                </td>

                                <td>
                                    <?php echo $row['TotalQuantity'] ?>
                                </td>

                                <td>
                                    <?php echo $row['TotalSales'] ?>
                                </td>
                            </tr>

                            <?php
                            $totalSales += $row['TotalSales'];
                        endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <span style="float:right" class="mr-5">
                                    <?php echo "Total: " . $totalSales ?>
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
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
        window.print();
        // $('#prt').show();
        document.body.innerHTML = oldPage;
    }

    $(document).ready(function () {
        var table = $('#cstRptTbl').DataTable({
            lengthChange: false, // disable "Show entries" dropdown
            searching: false, // disable search bar
            // scrollY: 400,
            // scrollCollapse: true,
            info: false,
            paging: false // hide pagination
        });

        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-form'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-form'
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-form'
                },
            ]
        });

        $('#button-container').append(buttons.container());

    });

</script>