<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of service</h3>
		<div class="card-tools">
			<a href="?page=services/manage_service" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>
				Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div class="container-fluid">
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
							<th>Action</th>
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
								<td align="center">
									<button type="button"
										class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
										data-toggle="dropdown">
										Action
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu" role="menu">
										<a class="dropdown-item confirm_data" id="update_status"
											data-id="<?php echo $row['id'], $row['status'] ?>">
											<span class="fa fa-edit text-success"></span> Confirm Booking
										</a>
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
	$(function () {
		$('#update_status').click(function () {
			// Get the HTML element by its ID
			const confirmBtn = document.getElementById('update_status');

			// Get the value of the data-id attribute
			const bookingData = confirmBtn.getAttribute('data-id');

			// Split the data values into an array
			const bookingDataArray = bookingData.split(',');

			// Use the array to retrieve the individual values
			const bookingId = bookingDataArray[0];
			const bookingStatus = bookingDataArray[1];

			// Use the bookingId and bookingStatus variables to perform further operations
			console.log(bookingId);
			console.log(bookingStatus);
			uni_modal("Update Status", `./services/update_status.php?oid=${bookingId}&status=${bookingStatus}`);
		})
	})
</script>