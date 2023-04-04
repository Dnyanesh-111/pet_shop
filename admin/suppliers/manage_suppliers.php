<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `suppliers` where id = '{$_GET['id']}' ");
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
        <form action="" id="suppliers-form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
                <label for="supplier" class="control-label">Supplier Name</label>
                <input type="text" name="supplier" id="" cols="30" rows="2" class="form-control form no-resize"
                    value="<?php echo isset($supplier) ? $supplier : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" name="email" id="" cols="30" rows="2" class="form-control form no-resize "
                    value="<?php echo isset($email) ? $email : ''; ?>">
            </div>
            <div class="form-group">
                <label for="mobile" class="control-label">Mobile</label>
                <input type="phone" name="mobile" id="" cols="30" rows="2" class="form-control form no-resize"
                    value="<?php echo isset($mobile) ? $mobile : ''; ?>">
            </div>
        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="suppliers-form">Save</button>
        <a class="btn btn-flat btn-default" href="?page=suppliers">Cancel</a>
    </div>
</div>
<script>

    $(document).ready(function () {
        $('#suppliers-form').submit(function (e) {
            e.preventDefault();
            var _this = $(this)
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_supplier",
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
                        location.href = "./?page=suppliers";
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