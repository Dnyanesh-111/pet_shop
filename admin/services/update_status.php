<div class="container-fluid">
    <form id="status-update-form">
        <input type="hidden" name="id" value="<?php echo $_GET['oid'] ?>">
        <div class="form-group">
            <label for="" class="control-label">Status</label>
            <select name="status" id="" class="custom-select custol-select-sm">
                <option value="Confirmed">Confirmed</option>
                <option value="Not Confirmed">Not Confirmed</option>
            </select>
        </div>
    </form>
</div>
<script>
    $(function () {
        $('#status-update-form').submit(function (e) {
            e.preventDefault();
            start_loader()
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=update_service_status",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_toast("An error occured", "error")
                    end_loader()
                },
                success: function (resp) {
                    if (!!resp.status && resp.status == 'success') {
                        location.reload()
                    } else {
                        console.log(resp)
                        alert_toast("An error occured", "error")
                        end_loader()
                    }
                }
            })
        })
    })
</script>