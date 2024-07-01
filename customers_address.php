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

<h1><?php echo $_GET['CustName']?>'s Address List</h1>

<div class="menu">
<div class="btn-group" style="float: right; margin:-4.1em 0.5em">
	<?php echo '<button><a href="'. $_SERVER["HTTP_REFERER"] .'">Back to Customer List</a></button>';?>
	</div>
	<table border="1">
		<tr>
			<th>No</th>
			<th colspan="3">Address</th>
		</tr>
		<?php
		require ('includes/constants.php');
		$CustID = $_GET['CustID'];

		$q = "SELECT * FROM address WHERE Cust_ID = '$CustID' ORDER BY Address_ID ASC";
		$r = @mysqli_query ($dbc,$q);
		$no = 1;
		if (!mysqli_num_rows($r) == 1) {
			echo '<tr><td colspan="4">No registered address</td></tr>';
		} else {
		while ($data = mysqli_fetch_array($r)) {
			echo '
			<tr>
				<td align="left">'.$no.'</td>
				<td align="left" colspan="3">'.$data['Address'].'</td>';
			echo'</tr>';
			$no++;
		}}
		?>
	</table>
</div>
<?php
include ('includes/footer.html');
?>
