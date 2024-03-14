<?php

$page_title = 'Sign In Form';
$page_text = 'Sign In Form';
include ('includes/header2.php');

if (!empty($_SESSION['CustID']) || !empty($_SESSION['AdminID'])){
	echo '
		<script>
		window.alert("\nALREADY LOGGED IN!");
		setTimeout(function(){location.href="index.php"},0);
		</script>';
}

// Run after submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Make the connection to the database
	require ('includes/constants.php');

	$errors = array(); // Initialize error array.

	$em = mysqli_real_escape_string($dbc, trim($_POST['email']));
	$p = mysqli_real_escape_string($dbc, trim($_POST['pass']));


	if (empty($errors)) { // If everything's OK.

		// Query for admin
		$q = "SELECT * FROM admin WHERE Email='$em' AND password=SHA1('$p')";
		$r = @mysqli_query ($dbc, $q); // Run the query.

		// Query for user
		$q1 = "SELECT * FROM customer WHERE Email='$em' AND password=SHA1('$p')";
		$r1 = @mysqli_query ($dbc, $q1); // Run the query.

		// Check the result:
		if (mysqli_num_rows($r) == 1) { // FOR ADMIN

			// Fetch the record:
			$row = mysqli_fetch_array($r, MYSQLI_ASSOC);

			// Set the session data:
			session_start();
			$_SESSION['AdminID'] = $row['AdminID'];
			$_SESSION['AdminName'] = $row['AdminName'];
			$_SESSION['Email'] = $em;

			// Redirect user
			header("Location:indexadmin.php");

		} elseif (mysqli_num_rows($r1) == 1) { // FOR USER
			
			// Fetch the record:
			$row = mysqli_fetch_array($r1, MYSQLI_ASSOC);

			// Set the session data:
			session_start();
			$_SESSION['CustID'] = $row['CustID'];
			$_SESSION['CustName'] = $row['CustName'];
			$_SESSION['Email'] = $em;
			$_SESSION['Address'] = $row['Address'];

			// Redirect user
			header("Location:index.php");

		} else { // Not a match!
			$errors[] = 'The email and password entered do not match those on file.';
		}
	} // End of empty($errors) IF.

	mysqli_close($dbc); // Close the database connection.

	if ($errors) { // Report the errors.
		echo '<h1>Error!</h1>
		<div id ="errors">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br/>";
		}
		echo '</div>
		<div id = "errors">Please try again.</div>'; // Close div "errors"
	}

} // End of the main submit conditional.

// Display the form:?>
<h1>Sign In</h1>
<form action="login.php" method="post">
	<table style="font-size: 100%">
		<tr>
			<td><p>E-Mail</p></td>
			<td><p><input type="email" name="email" size="40" required /></p></td>
		</tr>
		<tr>
			<td><p>Password</p></td>
			<td><p><input type="password" name="pass" size="20" required /></p></td>
		</tr>
	</table>
	<p align="right"><input type="submit" name="submit" value="Sign In" /></p>
</form>

<form action="register.php" method="get">
	<p align="right"><input type="submit" name="submit" value="Register" /></p>
</form>

<?php include ('includes/footer.html'); ?>
