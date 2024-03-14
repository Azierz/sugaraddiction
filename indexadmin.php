<?php
$page_title = 'Welcome back!';
$page_text = 'Admin Home Page';
include ('includes/aheader.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
?>

<h1>Category</h1>

	<div class="menu">
		<table>
		  <tr>
		    <th>Product Maintenance</th>
		    <th>Customer List</th>
		    <th>Order List</th>
		  </tr>
			<tr>
				<td><button class="btn"><a href="maintenance.php">GO</a></button></td>
				<td><button class="btn"><a href="customers.php">GO</a></button></td>
				<td><button class="btn"><a href="orders.php">GO</a></button></td>
			</tr>
		</table>
	</div>
<?php
include ('includes/footer.html');
?>
