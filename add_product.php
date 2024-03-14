<?php
$page_title = 'Add New Product';
$page_text = 'Add New Product';
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$aName = $_POST['name'];
	$aPrice = $_POST['price'];
	$aQty = $_POST['qty'];
	$aDesc = $_POST['desc'];
	$aSize  = $_POST['size'];

	require ('includes/constants.php');

	$q = "INSERT INTO product VALUES (0, '$aName', NULL, '$aPrice', '$aQty', '$aDesc', '$aSize')";
	$r = mysqli_query ($dbc, $q); 

	if ($r) {
		echo '<script>
		window.alert("\nSUCCESS!\nA new product has been uploaded.");
		setTimeout(function(){location.href="maintenance.php"},0);
		</script>';
		
	} else {
		echo '<h1>System Error</h1>
			<p class="error">Product could not be uploaded due to a system error. We apologize for any inconvenience.</p>';
		echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
	}
}
?>

<h1>Add New Product</h1>
<form action="add_product.php" method="post">
	<table border="0" id="reg">
		<tr>
			<td>Fruit Name:</td>
			<td><input type="text" name="name" size="15" maxlength="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" required /></td>
		</tr>
		<tr>
			<td>Fruit Price(RM):</td>
			<td><input type="text" name="price" size="10" maxlength="20" value="<?php if (isset($_POST['price'])) echo $_POST['price']; ?>" required /></td>
		</tr>
		<tr>
			<td>Quantity:</td>
			<td><input type="text" name="qty" size="20" maxlength="40" value= "<?php if (isset($_POST['qty'])) echo $_POST['qty']; ?>" required /></td>
		</tr>
		<tr>
			<td>Description:</td>
			<td><input type="text" name="desc" size="40" maxlength="100" value="<?php if (isset($_POST['desc'])) echo $_POST['desc']; ?>" required /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Add Fruit" /></td>
		</tr>
	</table>
</form>
<?php
include ('includes/footer.html');
?>
