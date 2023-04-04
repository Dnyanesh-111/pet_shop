<?php
if (isset($_POST)) {

}
?>



<div class="box-container">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php
        $whereData = "";
        if (isset($_GET['search']))
            $whereData = " and (product_name LIKE '%{$_GET['search']}%' or description LIKE '%{$_GET['search']}%')";
        elseif (isset($_GET['c']) && isset($_GET['s']))
            $whereData = " and (md5(category_id) = '{$_GET['c']}' and md5(sub_category_id) = '{$_GET['s']}')";
        elseif (isset($_GET['c']))
            $whereData = " and md5(category_id) = '{$_GET['c']}' ";
        elseif (isset($_GET['s']))
            $whereData = " and md5(sub_category_id) = '{$_GET['s']}' ";
        $products = $conn->query("SELECT * FROM `products` where status = 1 {$whereData} order by rand() ");
        while ($row = $products->fetch_assoc()):
            $upload_path = base_app . '/uploads/product_' . $row['id'];
            $img = "";
            if (is_dir($upload_path)) {
                $fileO = scandir($upload_path);
                if (isset($fileO[2]))
                    $img = "uploads/product_" . $row['id'] . "/" . $fileO[2];
                // var_dump($fileO);
            }
            $inventory = $conn->query("SELECT * FROM inventory where product_id = " . $row['id']);
            $inv = array();
            while ($ir = $inventory->fetch_assoc()) {
                $inv[$ir['size']] = number_format($ir['price']);
            }
            ?>
            <div class="col mb-5">
                <div class="box">
                    <div class="icons">
                        <a href=".?p=view_product&id=<?php echo md5($row['id']) ?>" class="fas fa-shopping-cart"></a>
                        <a href="#" class="fas fa-heart"></a>
                        <a href=".?p=view_product&id=<?php echo md5($row['id']) ?>" class="fas fa-eye"></a>
                    </div>
                    <!-- Product image-->
                    <div class="image">
                        <img class="card-img-top w-100" src="<?php echo validate_image($img) ?>" alt="..." />
                    </div>

                    <!-- Product details-->
                    <div class="content">
                        <!-- Product name-->
                        <h3 class="fw-bolder">
                            <?php echo $row['product_name'] ?>
                        </h3>
                        <!-- Product price-->
                        <?php foreach ($inv as $k => $v): ?>
                            <span class="amount"><b>
                                    <?php echo $k ?>:
                                </b>
                                <?php echo $v ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php
        if ($products->num_rows <= 0) {
            echo "<h4 class='text-center'><b>No Product Listed.</b></h4>";
        }
        ?>
    </div>
</div>
</section>