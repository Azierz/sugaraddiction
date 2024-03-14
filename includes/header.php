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
		<img src = "includes/images/cakey.png" style="width: 100%; height: auto;">
		<h1>Sugar Addiction Website </h1>
		<h2><?php echo $page_text; ?> </h2>
	</div>
	<div id="navigation">
		<ul>
		<?php
		if (!empty($_SESSION['CustID'])) {
			if (isset($_SERVER["HTTP_REFERER"])) {
				echo '<li><a href="'. $_SERVER["HTTP_REFERER"] .'">Back</a></li>';
			}
		} elseif (!empty($_SESSION['AdminID'])) {
			echo '<li><a href="logout.php">Sign Out</a></li>
			<li><a href="indexadmin.php">Back to Home</a></li>';
		}

		

		?>

		</ul>
	</div>
	<div id="content">
