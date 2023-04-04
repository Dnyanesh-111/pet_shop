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
        <h3 class="card-title">Order Report</h3>
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
                                        <h3> ORDER REPORT</h3>
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
                            <th>Order ID</th>
                            <th>Products</th>
                            <th>Customer Name</th>
                            <th>Payment Method</th>
                            <th>Total Cost</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_POST['filter'])) {
                            $filterValue = $_POST['filter'];
                            // Define the SQL query based on the selected filter option
                            if ($filterValue == 'this_month') {
                                $query = "SELECT o.id AS order_id, GROUP_CONCAT(CONCAT(ol.quantity, ' x ', p.product_name, ' (', ol.size, ')', ' - ₹', i.price) SEPARATOR ', ') AS products, c.firstname AS customer_name, o.payment_method, o.amount, o.date_created FROM orders o JOIN order_list ol ON o.id = ol.order_id JOIN products p ON ol.product_id = p.id JOIN inventory i ON p.id = i.product_id AND ol.size = i.size JOIN clients c ON o.client_id = c.id WHERE MONTH(o.date_created) = MONTH(CURRENT_DATE()) AND YEAR(o.date_created) = YEAR(CURRENT_DATE()) GROUP BY o.id ORDER BY o.date_created DESC;";
                            } else if ($filterValue == 'last_month') {
                                $query = "SELECT `firstname`,`lastname`,`gender`,`email`,`contact`,`date_created` FROM clients WHERE MONTH(date_created) = MONTH(DATE_SUB(CURRENT_DATE(), INTERVAL 1 MONTH)) AND YEAR(date_created) = YEAR(CURRENT_DATE()) ORDER BY date_created DESC";
                            } else if ($filterValue == 'last_six_months') {
                                $query = "SELECT `firstname`,`lastname`,`gender`,`email`,`contact`,`date_created` FROM clients WHERE date_created >= DATE_SUB(CURRENT_DATE(), INTERVAL 6 MONTH) ORDER BY date_created DESC";
                            } else if ($filterValue == 'this_year') {
                                $query = "SELECT `firstname`,`lastname`,`gender`,`email`,`contact`,`date_created` FROM clients WHERE YEAR(date_created) = YEAR(CURRENT_DATE()) ORDER BY date_created DESC";
                            } else if ($filterValue == 'all') {
                                $query = "SELECT o.id AS order_id, GROUP_CONCAT(CONCAT(ol.quantity, ' x ', p.product_name, ' (', ol.size, ')', ' - ₹', i.price) SEPARATOR ', ') AS products, c.firstname AS customer_name, o.payment_method, o.amount, o.date_created FROM orders o JOIN order_list ol ON o.id = ol.order_id JOIN products p ON ol.product_id = p.id JOIN inventory i ON p.id = i.product_id AND ol.size = i.size JOIN clients c ON o.client_id = c.id GROUP BY o.id ORDER BY date_created DESC";
                            }
                        } else {
                            $query = "SELECT o.id AS order_id, GROUP_CONCAT(CONCAT(ol.quantity, ' x ', p.product_name, ' (', ol.size, ')', ' - ₹', i.price) SEPARATOR ', ') AS products, c.firstname AS customer_name, o.payment_method, o.amount, o.date_created FROM orders o JOIN order_list ol ON o.id = ol.order_id JOIN products p ON ol.product_id = p.id JOIN inventory i ON p.id = i.product_id AND ol.size = i.size JOIN clients c ON o.client_id = c.id GROUP BY o.id ORDER BY date_created DESC";
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
                                    <?php echo $row['order_id'] ?>
                                </td>
                                <td>
                                    <?php echo $row['products'] ?>
                                </td>

                                <td>
                                    <?php echo $row['customer_name'] ?>
                                </td>

                                <td>
                                    <?php echo $row['payment_method'] ?>
                                </td>

                                <td>
                                    <?php echo $row['amount'] ?>
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
                                <?php echo "Total Orders: " . $qry->num_rows; ?>
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