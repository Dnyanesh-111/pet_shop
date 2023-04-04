<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of supplies</h3>
        <div class="card-tools">
            <a href="?page=supplies/manage_supply" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>
                Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="12.5%">
                        <col width="12.5%">
                        <col width="12.5%">
                        <col width="12.5%">
                        <col width="12.5%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Supplier</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Amount</th>
                            <th>Paid Amount</th>
                            <th>Remaining Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT p.product_name, s.supplier, su.id,su.price, su.quantity, su.total_amount, su.paid_amount, su.remaining_amount, su.date_created FROM supplies su JOIN products p ON su.product = p.id JOIN suppliers s ON su.supplier = s.id
                        order by unix_timestamp(su.date_created) desc ");
                        while ($row = $qry->fetch_assoc()):
                            // $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $row['product_name'] ?>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['supplier'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['price'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['quantity'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['total_amount'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['paid_amount'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['remaining_amount'] ?>
                                    </p>
                                </td>
                                <td>
                                    <?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?>
                                </td>
                                <td align="center">
                                    <button type="button"
                                        class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                        data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item"
                                            href="?page=supplies/manage_supply&id=<?php echo $row['id'] ?>"><span
                                                class="fa fa-edit text-primary"></span> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                            href="?page=supplies/generateBill&id=<?php echo $row['id'] ?>"><span
                                                class="fa fa-file text-primary"></span> Bill</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)"
                                            data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span>
                                            Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('.delete_data').click(function () {
            _conf("Are you sure to delete this supplies permanently?", "delete_supply", [$(this).attr('data-id')])
        })
        $('.table').dataTable();
    })
    function delete_supplie($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_supply",
            method: "POST",
            data: { id: $id },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>