<?php
$page_title = 'Product Maintenance';
$page_text = 'Product Maintenance';
include ('includes/header.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
?>

<h1>Product Maintenance</h1>

<div class="menu">
	<div class="btn-group" style="float: right; margin:-4.1em 0.5em">
		<button><a href="add_product.php">Add New Fruit</a></button>
	</div>
	<table border="1">
		<tr>
			<th>Fruit(s)</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Actions</th>
		</tr>
		<?php
		require ('includes/constants.php');

		$q = "SELECT * FROM product";
		$r = @mysqli_query ($dbc,$q);

		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">ALL PRODUCT OUT OF STOCK</td></tr>';
		} else {
		while ($data = mysqli_fetch_array($r)) {
			echo "
			<tr>
				<td style=\"border-bottom: 0px\">";
				if (!isset($data['Image'])) {
					echo "<img src=\"includes/images/image_na.png\"";
				} else {
					echo "<img src=\"includes/images/".$data['Image']."\"";
				};
				echo "</td>
				<td rowspan='2'>RM ".$data['Price']."</td>
				<td rowspan='2'>".$data['Quantity']."</td>
				<td rowspan='2'>";
				
				echo '
				<div class="btn-group">
					<button><a href="edit_product.php?id='.$data['ProductID'].'">EDIT</a></button><br><br>
					<button><a href="delete_product.php?id='.$data['ProductID'].'">DELETE</a></button>
				</div>';
				
				
				echo "</td>
				</tr>
				<tr>
					<td style=\"border-top: 0px\">".$data['Name']."</td>
				</tr>
				";
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
