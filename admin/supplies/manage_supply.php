<?php
// fetch products from the products table
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// fetch suppliers from the suppliers table
$query = "SELECT * FROM suppliers";
$result = mysqli_query($conn, $query);
$suppliers = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `supplies` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title">
            <?php echo isset($id) ? "Update " : "Add New " ?> Supplier
        </h3>
    </div>
    <div class="card-body">
        <form action="" id="supply-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
                <select class="custom-select" name="product" required>
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product) { ?>
                        <option value="<?php echo $product['id']; ?>"><?php echo $product['product_name']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <select class="custom-select" name="supplier" required>
                    <option value="">Select Supplier</option>
                    <?php foreach ($suppliers as $supplier) { ?>
                        <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['supplier']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price" class="control-label">Price</label>
                <input type="number" name="price" id="price" cols="30" rows="2" class="form-control form no-resize"
                    value="<?php echo isset($price) ? $price : ''; ?>">
            </div>
            <div class="form-group">
                <label for="quantity" class="control-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" cols="30" rows="2"
                    class="form-control form no-resize" value="<?php echo isset($quantity) ? $quantity : ''; ?>">
            </div>
            <div class="form-group">
                <label for="total_amount" class="control-label">Toatal Amount</label>
                <input type="number" name="total_amount" id="total" cols="30" rows="2"
                    class="form-control form no-resize" value="<?php echo isset($total_amount) ? $total_amount : ''; ?>"
                    readonly>
            </div>
            <div class="form-group">
                <label for="paid_amount" class="control-label">Paid Amount</label>
                <input type="number" name="paid_amount" id="paid_amount" cols="30" rows="2"
                    class="form-control form no-resize" value="<?php echo isset($paid_amount) ? $paid_amount : ''; ?>">
            </div>
            <div class="form-group">
                <label for="remaining_amount" class="control-label">Remainig Amount</label>
                <input type="number" name="remaining_amount" id="remaining_amount" cols="30" rows="2"
                    class="form-control form no-resize"
                    value="<?php echo isset($remaining_amount) ? $remaining_amount : ''; ?>" readonly>
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="supply-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=supplies">Cancel</a>
    </div>
</div>


<script>
    function calculateTotal() {
        var price = document.getElementById('price').value;
        var quantity = document.getElementById('quantity').value;
        var total = price * quantity;
        document.getElementById('total').value = total;
    }
    function calculateRemaining() {
        var paid_amount = document.getElementById('paid_amount').value;
        var total = document.getElementById('total').value;
        var remaining_amount = total - paid_amount;
        document.getElementById('remaining_amount').value = remaining_amount;
    }

    document.getElementById('price').addEventListener('input', calculateTotal);
    document.getElementById('quantity').addEventListener('input', calculateTotal);
    document.getElementById('paid_amount').addEventListener('input', calculateRemaining);

    $(document).ready(function () {
        $('#supply-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_supply",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.href = "./?page=supplies";
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>')
                        el.addClass("alert alert-danger err-msg").text(resp.msg)
                        _this.prepend(el)
                        el.show('slow')
                        $("html, body").animate({ scrollTop: _this.closest('.card').offset().top }, "fast");
                        end_loader()
                    } else {
                        alert_toast("An error occured", 'error');
                        end_loader();
                        console.log(resp)
                    }
                }
            })
        })

        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ol', 'ul', 'paragraph', 'height']],
                ['table', ['table']],
                ['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ]
        })
    })
</script>