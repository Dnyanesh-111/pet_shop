<!-- home section starts  -->

<section class="home" id="home">

    <div class="content">
        <h3> <span>hi</span> welcome to our pet shop </h3>
        <a href="#" class="btn">shop now</a>
    </div>

    <img src="image/bottom_wave.png" class="wave" alt="">

</section>
<section class="about" id="about">

    <div class="image">
        <img src="image/about_img.png" alt="">
    </div>

    <div class="content">
        <h3>premium <span>pet food</span> seller</h3>
        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Voluptatum sint, dolore perspiciatis iure
            consequuntur eligendi quaerat vitae shaikh anas.</p>
        <a href="./?p=about" class="btn">read more</a>
    </div>

</section>
<!-- home section ends -->
<!-- dog and cat food banner section starts -->

<div class="dog-food">

    <div class="image">
        <img src="image/dog_food.png" alt="">
    </div>

    <div class="content">
        <h3> <span>air dried</span> dog food </h3>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugiat iure illo, repudiandae rem porro sunt.</p>
        <div class="amount">₹15.00 - ₹30.00</div>
        <a aria-current="page" href="./?p=products"> <img src="image/shop_now_dog.png" alt=""> </a>
    </div>

</div>

<div class="cat-food">

    <div class="content">
        <h3> <span>air dried</span> cat food </h3>
        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fugiat iure illo, repudiandae rem porro sunt.</p>
        <div class="amount">₹15.00 - ₹30.00</div>
        <a aria-current="page" href="./?p=products"> <img src="image/shop_now_cat.png" alt=""> </a>
    </div>

    <div class="image">
        <img src="image/cat_food.png" alt="">
    </div>

</div>

<!-- dog and cat food banner section ends -->
<!-- Shop Section-->
<section class="shop" id="shop">
    <h1 class=" heading"> our <span> products </span> </h1>
    <div class="box-container">
        <div class="row gx-4 gx-lg-5 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            $products = $conn->query("SELECT * FROM `products` where status = 1 order by rand() limit 8 ");
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
                            <!-- <img src="image/product_01.jpg" alt=""> -->
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
        </div>
    </div>
</section>
<!-- Shop Section Ends here-->
<section class="services" id="services">

    <h1 class="heading"> our <span>services</span> </h1>

    <div class="box-container">

        <div class="box">
            <i class="fas fa-dog"></i>
            <h3>dog boarding</h3>
            <a aria-current="page" href="./?p=petservices/dogBoarding" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-cat"></i>
            <h3>cat boarding</h3>
            <a aria-current="page" href="./?p=petservices/catBoarding" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-bath"></i>
            <h3>spa & grooming</h3>
            <a aria-current="page" href="./?p=petservices/spaGrooming" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-drumstick-bite"></i>
            <h3>healthy meal</h3>
            <a aria-current="page" href="./?p=petservices/healthyMeal" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-baseball-ball"></i>
            <h3>activity exercise</h3>
            <a aria-current="page" href="./?p=petservices/activityExercise" class="btn">read more</a>
        </div>

        <div class="box">
            <i class="fas fa-heartbeat"></i>
            <h3>health care</h3>
            <a aria-current="page" href="./?p=petservices/helthCare" class="btn">read more</a>
        </div>

    </div>

</section>

<!-- services section ends -->