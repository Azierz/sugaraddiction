<?php session_start(); ?>
<html>
<head>
	<title><?php echo $page_title; ?></title>
	<link rel="stylesheet" href="includes/style.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
</head>
<body>
	<div id="header">
		<img src = "includes/images/cakey.png">
		<img src = "includes/images/cakey.png">
		<h1>Sugar Addiction Website </h1>
		<h2><?php echo $page_text; ?> </h2>

	</div>
	<div id="navigation">
		<ul>
		<?php
		if (isset($_SESSION['CustID'])) {
			echo '
			<!-- search bar -->
			<div class="search-container">
				<form action="menu.php" method="GET">
					<input type="text" placeholder="Search..." name="search" size="25">
					<button type="submit"><i class="fa fa-search"></i></button>
				</form>
		 	</div>

			<a class="cart" href="cart.php"><i class="fa fa-shopping-cart"></i></a>
			<li><a href="logout.php">Sign Out</a></li>
			<li><a href="cust_orders.php">Order History</a></li>
			<li><a href="faq.php">FAQ</a></li>
			<li><a href="menu.php">Menu</a></li>
			<li><a href="index.php">Home</a></li>';
		} elseif (!empty($_SESSION['AdminID'])) {
				echo '<li><a href="customers.php">Back</a></li>';
		} else {
			echo '
			<li><a href="login.php">Sign In</a></li>
			<li><a href="faq.php">FAQ</a></li>
			<li><a href="index.php">Home</a></li>';
		}
		?>
		</ul>
	</div>
	<div id="content">
