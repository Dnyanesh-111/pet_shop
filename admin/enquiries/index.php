<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Enquiries</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-bordered table-stripped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="20%">
                        <col width="20%">
                        <col width="10%">
                        <col width="15%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $qry = $conn->query("SELECT * from `enquiries` order by unix_timestamp(date_created) desc ");
                        while ($row = $qry->fetch_assoc()):
                            // $row['description'] = strip_tags(stripslashes(html_entity_decode($row['description'])));
                            ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $i++; ?>
                                </td>
                                <td>
                                    <?php echo $row['cname'] ?>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['cemail'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['cnumber'] ?>
                                    </p>
                                </td>
                                <td>
                                    <p class="truncate-1 m-0">
                                        <?php echo $row['message'] ?>
                                    </p>
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