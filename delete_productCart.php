<?php
$page_title = 'Cart Product Deletion';
$page_text = 'Cart Product Deletion';
include ('includes/header.php');

			$i = $_GET["id"];
			unset($_SESSION["cart"][$i]);
			unset($_SESSION["amounts"][$i]);
			unset($_SESSION["cart"][$i]);
			unset($_SESSION["qty"][$i]);
			unset($_SESSION["sms"][$i]);
	

		echo '<script>
		window.alert("\nSUCCESS!\nCart product has been deleted.");
		setTimeout(function(){location.href="cart.php"},0);
		</script>';
?>
<?php
include ('includes/footer.html');
?>
