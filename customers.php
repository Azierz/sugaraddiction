<?php
$page_title = 'Customer List';
$page_text = 'Customer List';
include ('includes/header.php');

if (empty($_SESSION['AdminID'])) {
	echo '
		<script>
		window.alert("\nPLEASE LOGIN FIRST!");
		setTimeout(function(){location.href="login.php"},0);
		</script>';
}
?>

<h1>Customer List</h1>

<div class="menu">
<div class="btn-group" style="float: right; margin:-4.1em 0.5em">
		<button><a href="register.php">Add New Customer</a></button>
	</div>
	<table border="1" style="width: max-content; margin:0.5em 8em">
		<tr>
			<th>Name</th>
			<th>Email Address</th>
			<th>Phone Number</th>
			<th>Date of Birth</th>
			<th>Address</th>
			<th>Registration Date</th>
			<th>Actions</th>
		</tr>
		<?php
		require ('includes/constants.php');

		$q = "SELECT * FROM customer ORDER BY regs_date DESC";
		$r = @mysqli_query ($dbc,$q);

		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">No registered customers</td></tr>';
		} else {
		while ($data = mysqli_fetch_array($r)) {
			echo '
			<tr>
				<td align="left">'.$data['CustName'].'</td>
				<td align="left">'.$data['Email'].'</td>
				<td align="left">'.$data['PhoneNum'].'</td>';
				if (empty($data['dateofbirth'])) {
					
					echo '<td align="left"> No Record</td>';
				} else {
					echo '<td align="left">'.date("j M Y",strtotime($data['dateofbirth'])).'</td>';
					}					
				echo '<td align="left">';
				echo '
				<form action="customers_address.php" method="GET">
					<input type="text" name="CustID" value="'.$data["CustID"].'" hidden>
					<input type="text" name="CustName" value="'.$data["CustName"].'" hidden>
					<input type="submit" name="submit" value="Address List" />
				</form>';
				echo "</td><td align='left'>" . date("H:i:s A", strtotime($data['regs_date'])) . "<br>" . date("j M Y", strtotime($data['regs_date'])) . "</td>";
				echo '<td align="left">
				<form action="edit_customer.php" method="GET">
				<input type="text" name="CustID" value="'.$data["CustID"].'" hidden>
				<input type="text" name="CustName" value="'.$data["CustName"].'" hidden>
				<input type="submit" name="submit" value="Edit" />
				</form>
				<form action="delete_customer.php" method="GET">
				<input type="text" name="CustID" value="'.$data["CustID"].'" hidden>
				<input type="text" name="CustName" value="'.$data["CustName"].'" hidden>
				<input type="submit" name="submit" value="Delete" />
				</form>
				</td>';
			echo'</tr>';
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
