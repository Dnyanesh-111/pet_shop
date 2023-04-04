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
        <h3 class="card-title">Supplies Report</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form method="post" action="">
                <div class="d-flex align-items-center">
                    <div class="m-2">
                        <label for="filter">Filter by:</label>
                        <select class="form-control" id="filter" name='filter' value="filterby">
                            <option value="all">All</option>
                            <option value="this_month">This Month</option>
                            <option value="last_month">Last Month</option>
                            <option value="last_six_months">Last Six Month</option>
                            <option value="this_year">Last Year</option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <input class="mt-2 p-1 px-2" type="submit" value="Submit">
                    </div>
                </div>
            </form>
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
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th colspan="7" class='tblheading'>
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div>
                                        <h3> SUPPLIES REPORT</h3>
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
                            <th>Supplier</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['filter'])) {
                            $filterValue = $_POST['filter'];
                            // Define the SQL query based on the selected filter option
                            if ($filterValue == 'this_month') {
                                $query = "SELECT s.id, sp.supplier AS Supplier, p.product_name AS Product, s.price, s.quantity, s.total_amount, s.date_created 
                                FROM supplies s 
                                JOIN suppliers sp ON s.supplier = sp.id 
                                JOIN products p ON s.product = p.id
                                WHERE MONTH(s.date_created) = MONTH(CURRENT_DATE()) AND YEAR(s.date_created) = YEAR(CURRENT_DATE())";
                            } else if ($filterValue == 'last_month') {
                                $query = "SELECT s.id, sp.supplier AS Supplier, p.product_name AS Product, s.price, s.quantity, s.total_amount, s.date_created 
                                FROM supplies s 
                                JOIN suppliers sp ON s.supplier = sp.id 
                                JOIN products p ON s.product = p.id
                                WHERE s.date_created >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH) AND s.date_created < DATE_SUB(CURRENT_DATE(), INTERVAL 0 MONTH)";
                            } else if ($filterValue == 'last_six_months') {
                                $query = "SELECT s.id, sp.supplier AS Supplier, p.product_name AS Product, s.price, s.quantity, s.total_amount, s.date_created 
                                FROM supplies s 
                                JOIN suppliers sp ON s.supplier = sp.id 
                                JOIN products p ON s.product = p.id
                                WHERE s.date_created >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH) AND s.date_created <= CURRENT_DATE()";
                            } else if ($filterValue == 'this_year') {
                                $query = "SELECT s.id, sp.supplier AS Supplier, p.product_name AS Product, s.price, s.quantity, s.total_amount, s.date_created 
                                FROM supplies s 
                                JOIN suppliers sp ON s.supplier = sp.id 
                                JOIN products p ON s.product = p.id
                                WHERE s.date_created >= DATE_SUB(CURRENT_DATE(), INTERVAL 1 YEAR) AND s.date_created <= CURRENT_DATE()";
                            } else if ($filterValue == 'all') {
                                $query = "SELECT s.id, sp.supplier AS Supplier, p.product_name AS Product, s.price, s.quantity, s.total_amount, s.date_created FROM supplies s JOIN suppliers sp ON s.supplier = sp.id JOIN products p ON s.product = p.id;";
                            }
                        } else {
                            $query = "SELECT s.id, sp.supplier AS Supplier, p.product_name AS Product, s.price, s.quantity, s.total_amount, s.date_created FROM supplies s JOIN suppliers sp ON s.supplier = sp.id JOIN products p ON s.product = p.id";
                        }
                        $i = 1;
                        $qry = $conn->query($query);
                        while ($row = $qry->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $row['Supplier'] ?>
                                </td>
                                <td>
                                    <?php echo $row['Product'] ?>
                                </td>

                                <td>
                                    <?php echo $row['price'] ?>
                                </td>

                                <td>
                                    <?php echo $row['quantity'] ?>
                                </td>

                                <td>
                                    <?php echo $row['total_amount'] ?>
                                </td>

                                <td>
                                    <?php echo $row['date_created'] ?>
                                </td>

                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <?php echo "Total Supplies: " . $qry->num_rows; ?>
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