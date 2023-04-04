<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
  <div class="container px-4 px-lg-5 py-4 ">
    <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
        class="navbar-toggler-icon"></span></button>
    <a class="navbar-brand" href="./">
      <img src="<?php echo validate_image($_settings->info('logo')) ?>" width="30" height="30"
        class="d-inline-block align-top" alt="" loading="lazy">
      <?php echo $_settings->info('short_name') ?>
    </a>

    <form class="form-inline" id="search-form">
      <div class="input-group">
        <input class="form-control form-control-sm form input-search " type="search" placeholder="Search"
          aria-label="Search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : "" ?>"
          aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-success btn-sm m-0 btn-search" type="submit" id="button-addon2"><i
              class="fa fa-search"></i></button>
        </div>
      </div>
    </form>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
        <li class="nav-item"><a class="nav-link" aria-current="page" href="./">Home</a></li>
        <?php
        // Retrieve all categories that have a status of 1 from the database.
        $cat_qry = $conn->query("SELECT * FROM categories where status = 1 ");

        // Loop through each category.
        foreach ($cat_qry as $crow) {
          // Check if the current category has any sub-categories.
          $sub_qry = $conn->query("SELECT * FROM sub_categories where status = 1 and parent_id = '{$crow['id']}' ");
          if ($sub_qry->num_rows <= 0) {
            // If there are no sub-categories, display the category name as a link in the navigation menu.
            echo '<li class="nav-item"><a class="nav-link" aria-current="page" href="./?p=products&c=' . md5($crow['id']) . '">' . $crow['category'] . '</a></li>';
          } else {
            // If there are sub-categories, display the category name as a dropdown menu in the navigation menu.
            echo '<li class="nav-item dropdown">';
            echo '<a class="nav-link dropdown-toggle" id="navbarDropdown' . $crow['id'] . '" href="#" role="button" data-toggle="dropdown" aria-expanded="false">' . $crow['category'] . '</a></a>';
            echo '<ul class="dropdown-menu  p-0" aria-labelledby="navbarDropdown' . $crow['id'] . '">';

            // Retrieve all sub-categories that have a status of 1 and a parent_id equal to the current category's id.
            foreach ($sub_qry as $srow) {
              // Display each sub-category name as a link within the dropdown menu.
              echo '<li><a class="dropdown-item border-bottom" href="./?p=products&c=' . md5($crow['id']) . '&s=' . md5($srow['id']) . '">' . $srow['sub_category'] . '</a></li>';
            }

            echo '</ul></li>';
          }
        }
        ?>
        <li class="nav-item"><a class="nav-link" href="./?p=services">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="./?p=contact">Contact us</a></li>
        <li class="nav-item"><a class="nav-link" href="./?p=about">About</a></li>
      </ul>
      <div class="d-flex align-items-center">
        <?php if (!isset($_SESSION['userdata']['id'])): ?>
          <button class="btn btn-outline-dark" id="login-btn" type="button">Login</button>
        <?php else: ?>
          <a class="text-dark  nav-link" href="./?p=cart">
            <i class="bi-cart-fill me-1"></i>
            Cart
            <span class="badge bg-dark text-white ms-1 rounded-pill" id="cart-count">
              <?php
              if (isset($_SESSION['userdata']['id'])):
                $count = $conn->query("SELECT SUM(quantity) as items from `cart` where client_id =" . $_settings->userdata('id'))->fetch_assoc()['items'];
                echo ($count > 0 ? $count : 0);
                echo '<a class="text-dark nav-link" href="./?p=about"><i class="fa fa-regular fa-heart fa-lg"></i></a>';
              else:
                echo "0";
              endif;
              ?>
            </span>
          </a>

          <a href="./?p=my_account" class="text-dark  nav-link"><b> Hi,
              <?php echo $_settings->userdata('firstname') ?>!
            </b></a>
          <a href="logout.php" class="text-dark  nav-link"><i class="fa fa-sign-out-alt"></i></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<script>
  $(function () {
    $('#login-btn').click(function () {
      uni_modal("", "login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
      $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
      if ($('body').offset.top == 0)
        $('#mainNav').removeClass('navbar-shrink')
    })
  })

  $('#search-form').submit(function (e) {
    e.preventDefault()
    var sTxt = $('[name="search"]').val()
    if (sTxt != '')
      location.href = './?p=products&search=' + sTxt;
  })
</script>