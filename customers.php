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
	<table border="1">
		<tr>
			<th>Name</th>
			<th>Email Address</th>
			<th>Phone Number</th>
			<th>Address</th>
			<th>Registration Date</th>
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
				<td align="left">'.$data['PhoneNum'].'</td>
				<td align="left">'.$data['Address'].'</td>';
				echo "<td align='left'>" . date("H:i:s A", strtotime($data['regs_date'])) . "<br>" . date("j M Y", strtotime($data['regs_date'])) . "</td>";
			echo'</tr>';
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
