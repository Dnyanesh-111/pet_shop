<section class="py-2" id="my-account">
    <div class="container-fluid m-5">
        <div class="card rounded-0 mb-5">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b>Orders</b></h4>
                    <a href="./?p=edit_account" class="btn btn btn-dark btn-flat">
                        <div class="fa fa-user-cog"></div> Manage Account
                    </a>
                </div>
                <hr class="border-warning">
                <table class="table table-stripped text-dark">
                    <colgroup>
                        <col width="10%">
                        <col width="15">
                        <col width="25">
                        <col width="25">
                        <col width="15">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>DateTime</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT o.*,concat(c.firstname,' ',c.lastname) as client from `orders` o inner join clients c on c.id = o.client_id where o.client_id = '" . $_settings->userdata('id') . "' order by unix_timestamp(o.date_created) desc ");
                        while ($row = $qry->fetch_assoc()):
                            ?>
                            <tr>
                                <td>
                                    <?php echo $i++ ?>
                                </td>
                                <td>
                                    <?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?>
                                </td>
                                <td><a href="javascript:void(0)" class="view_order" data-id="<?php echo $row['id'] ?>"><?php
                                   echo md5($row['id']); ?></a></td>
                                <td>
                                    <?php echo number_format($row['amount']) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['status'] == 0): ?>
                                        <span class="badge badge-light text-dark">Pending</span>
                                    <?php elseif ($row['status'] == 1): ?>
                                        <span class="badge badge-primary">Packed</span>
                                    <?php elseif ($row['status'] == 2): ?>
                                        <span class="badge badge-warning">Out for Delivery</span>
                                    <?php elseif ($row['status'] == 3): ?>
                                        <span class="badge badge-success">Delivered</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="card rounded-0 mb-5">
            <div class="card-body">
                <div class="w-100 justify-content-between d-flex">
                    <h4><b>Services</b></h4>
                </div>
                <hr class="border-warning">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Plan</th>
                            <th>Charges</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * from `services_bookings` order by unix_timestamp(date_created) desc ");
                        while ($row = $qry->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $row['cname'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cemail'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cnumber'] ?>
                                </td>
                                <td>
                                    <?php echo $row['plan'] ?>
                                </td>
                                <td>
                                    <?php echo $row['charges'] ?>
                                </td>
                                <td>
                                    <?php echo $row['status'] ?>
                                </td>

                                <td>
                                    <?php echo date("Y-m-d", strtotime($row['date_created'])) ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</section>
<script>
    function cancel_book($id) {
        start_loader()
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=update_book_status",
            method: "POST",
            data: { id: $id, status: 2 },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("an error occured", 'error')
                end_loader()
            },
            success: function (resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert_toast("Book cancelled successfully", 'success')
                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else {
                    console.log(resp)
                    alert_toast("an error occured", 'error')
                }
                end_loader()
            }
        })
    }
    $(function () {
        $('.view_order').click(function () {
            uni_modal("Order Details", "./admin/orders/view_order.php?view=user&id=" + $(this).attr('data-id'), 'large')
        })
        $('table').dataTable();

    })
</script>