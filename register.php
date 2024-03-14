<?php
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Register';
$page_text = 'Registration Form';
include ('includes/header2.php');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array(); // Initialize an error array.

	$n = trim($_POST['name']);
	$p = trim($_POST['pass1']);
	$pn = trim($_POST['phone_no']);
	$ad = trim($_POST['address']);
	$e = trim($_POST['email']);

	if (empty($errors)) { // If everything's OK. ($fn && $ln && $e)

		require ('includes/constants.php'); // Connect to the db.

		//  Test for unique email address
		$q1 = "SELECT email FROM customer WHERE email='$e'";
		$r1 = @mysqli_query($dbc, $q1);

		if (mysqli_num_rows($r1) > 0) { // Check for unique email address
			$errors[] = "Email Address already exists.";
		} else { // Register the user in the database...

		// Make the query:
		$q = "INSERT INTO customer VALUES (0, '$n', SHA1('$p'), '$pn', '$ad', '$e', '')";
		$r = mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.

			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You are now registered.</p>';

		} else { // If it did not run OK.

			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';

			// Debugging message:
			echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.html');
		exit();

		} // End of register user into db
	}  // End of if (empty($errors)) IF.
		if ($errors) { // Report the errors.
		echo '<h1>Error!</h1>
		<div id = "errors">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</div>
		<div id = "errors">Please try again.</div> <p><br /></p>';

	}

} // End of the main Submit conditional.
?>
<h1>Register</h1>
<form action="register.php" method="post">
	<table border="0" id="reg">
		<tr>
			<td>Full Name:</td>
			<td><input type="text" name="name" size="15" maxlength="20" value="<?php if (isset($_POST['name'])) echo $_POST['name']; ?>" required /></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" required /></td>
		</tr>
		<tr>
			<td>Phone Number:</td>
			<td><input type="text" name="phone_no" size="20" maxlength="40" value= "<?php if (isset($_POST['phone_no'])) echo $_POST['phone_no']; ?>" required /></td>
		</tr>
		<tr>
			<td>Address:</td>
			<td><input type="text" name="address" size="40" maxlength="100" value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>" required /></td>
		</tr>
		<tr>
			<td>Email Address:</td>
			<td><input type="email" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" required /></td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" name="submit" value="Register" /></td>
		</tr>
	</table>
</form>

<?php include ('includes/footer.html'); ?>
