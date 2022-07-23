<?php
include 'header.php';
?>


<!--Main Content-->

<!-- Home page and company description -->

<div class="py-2 bg-white">
	<div class="container">

		<div class="col-md-12 mx-auto py-4">
			<span class="topic text-black">Customer List</span>
			<span class="topic mx-5">
				<a href="newCustomer.php" class="btn btn-primary btn-lg">New Customer</a>
			</span>
		</div>

		<div class="row">
			<div class="col-md-6 py-4">
				<input type="search" id="search" class="form-control" placeholder="Search customer by email or name">
			</div>
		</div>

	</div>
</div>


<div class="container-fluid">
	<div class="text-center">

		<table class="table sortable mt-1 table-hover" id="cusTable">
			<thead class="thead-dark">
				<tr>
					<th>Customer's Name</th>
					<th>Customer's Email</th>
					<th>Customer's Phone Number</th>
					<th>Customer's Details</th>
				</tr>
			</thead>

			<body>
				<?php
            include "conn.php";
            $conn = getDBconnection();
            $sql = "SELECT * FROM Customer";
            $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            if (mysqli_num_rows($query) > 0){
                while($result = mysqli_fetch_assoc($query)){
                    echo "
					<tr>
					    <td>$result[customerName]</td>
                        <td>$result[customerEmail]</td>
                        <td>$result[phoneNumber]</td>
                        <td><a href='customerDetail.php?cusEmail=$result[customerEmail]'>Details</a></td>
					</tr>
					";
                }
            } else {
                // Not found
                echo "Not found<br>";
                echo $sql;
            }
            mysqli_close($conn);
            ?>
			</body>
		</table>
	</div>
</div>


<!--footer-->

<div class="bg-info">
	<div class="container my-3">
		<div class="row" style="">
			<div class="col-12 my-2 text-center text-white">
				Better Limited Management System 2022&copy;
			</div>
		</div>
	</div>
</div>

<script>
	// search function
	$(function() {
		$('#cusTable').searchable({
			searchType: 'fuzzy'
		});
	});

</script>

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="//rawgithub.com/stidges/jquery-searchable/master/dist/jquery.searchable-1.0.0.min.js"></script>
<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
