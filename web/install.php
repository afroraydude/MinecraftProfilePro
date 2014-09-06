<?php

	ini_set("display_errors", "off");
	error_reporting(0);

	require("classes/configuration.php");

	$mysqlConf = new Configuration("mysql");
	if ($mysqlConf == false)
	{
		die("Couldn't read from configuration file: mysql/main");
	}

	$error = false;

	try
	{
		$db = new PDO("mysql:host=" . $mysqlConf->getConfArray()['host'] . ";port=" . $mysqlConf->getConfArray()['port'] . ";dbname=" . $mysqlConf->getConfArray()['database_name'], $mysqlConf->getConfArray()['username'], $mysqlConf->getConfArray()['password'], array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_PERSISTENT => true
		));
		$view = "<p class='text-success'>• Connected to MySQL Database</p>";
	}catch (PDOException $e){
		$view = "<p class='text-danger'>• Couldn't Connect to MySQL Database</p>";
		$view .= "<p class='text-danger'>Please check your configuration files at configuration/mysql/main.json</p>";
		$error = true;
	}

	if ($error === false)
	{
		if (file_exists("mcpp/sql/players.sql") && is_readable("mcpp/sql/players.sql"))
		{
			$sql = file_get_contents("mcpp/sql/players.sql");
			$candelete = true;
			try
			{
				$db->query($sql); // It's your fault if you drop any random tables/databases if you edit the SQL file.
				$view = "<p class='text-success'>• Setup Complete — Query Accepted :: CREATE TABLE `players`</p>";
				$view .= "<p class='text-success'>Please delete install.php if the installer doesn't do it automatically.</p>";
			}catch (PDOException $e)
			{
				$view = "<p class='text-danger'>• Couldn't execute query — Query Denied :: CREATE TABLE `players`</p>";
				$view .= "<p class='text-danger'>This might be a configuration error or you've already installed MCPP.</p>";
				$candelete = false;
			}
		}else{
			$view = "<p class='text-danger'>• Couldn't Open SQL File: mcpp/sql/players.sql</p>";
			$view .= "<p class='text-danger'>Please check your that you downloaded it correctly.</p>";
			$candelete = false;
		}
	}

?>
<!doctype html>
<html>
	<head>
		<!-- Some Basic META Info -->
		<meta charset="UTF-8"> <!-- UTF-8 allows the support of a lot more common characters! -->

		<title>&lt;MinecraftProfilePro Installation&gt;</title>
		<!-- If you remove "&lt;MinecraftProfilePro&gt; - please consider donating. -->

		<!-- Bootstrap VIA Bootstrap CDN -->
		<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

		<!-- Custom Stylesheets -->
		<link rel="stylesheet" href="mcpp/css/screen.css">
	</head>
	<body>
		<div class="container">
			<div class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="http://localhost/MinecraftProfilePro/">MCPP Installation</a>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="https://github.com/matrixdevuk/MinecraftProfilePro" target="_blank">MCPP on Github</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="jumbotron">
				<h1>MinecraftProfilePro Installation</h1>
				<?= $view ?>
			</div>
		</div>

		<!-- Bootstrap Javascript Files -->
		<script src="//code.jquery.com/jquery-latest.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
</html>
<?php

	if ($candelete === true)
	{
		@unlink("install.php"); // delete install.php
	}

?>
