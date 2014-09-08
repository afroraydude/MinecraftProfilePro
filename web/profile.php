<?php

	ini_set("display_errors", "off");
	error_reporting(0);

	require("classes/configuration.php");
	require("classes/web.php");

	$webConf = new Configuration("web");
	if ($webConf == false)
	{
		die("Couldn't read from configuration file: web/main");
	}

	$mysqlConf = new Configuration("mysql");
	if ($mysqlConf == false)
	{
		die("Couldn't read from configuration file: mysql/main");
	}

	$webApp = new WebApp();

	$error = false;

	if (!empty($_GET['player']))
	{
		try
		{
			$db = new PDO("mysql:host=" . $mysqlConf->getConfArray()['host'] . ";port=" . $mysqlConf->getConfArray()['port'] . ";dbname=" . $mysqlConf->getConfArray()['database_name'], $mysqlConf->getConfArray()['username'], $mysqlConf->getConfArray()['password'], array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_PERSISTENT => true
			));
		}catch (PDOExeption $e){
			$view = "<h1>Error</h1>
			<p>Failure to connect to MySQL database.</p>";
			$error = true;
		}

		if ($error === false)
		{
			try
			{
				$query = $db->prepare("SELECT `uuid`, `name`, `p_kills`, `m_kills`, `breaks`, UNIX_TIMESTAMP(`last_seen`) AS `last_seen`, `is_op`, `is_banned`, `last_gamemode`, `jumps`, `deaths`, `sword_swings`, `blocks_placed`, `diamonds_found`, `enchantments` FROM `players` WHERE `name`=:name");
				$query->execute(array(
					":name" => htmlspecialchars($_GET['player'])
				));
			}catch (PDOExeption $e){
				$view = "<h1>Error</h1>
				<p>Failure to query the MySQL database.</p>";
				$error = true;
			}

			if ($error === false)
			{
				if ($query->rowCount() == 1)
				{
					$row = $query->fetch(PDO::FETCH_ASSOC);

					$view = "<h1>" . $row['name'] . " <small class='text-muted'>" . $row['uuid'] . "</small></h1>";
					$view .= "<div class='row'>";
						$view .= "<div class='col-md-3 text-center'>";
							$view .= "<img src='data:image/png;base64," . $webApp->getAvatar($row['name'], 175) . "' class='img-responsive img-thumbnail' style='-webkit-transition-delay: 0s; -webkit-transition-duration: 0.2s; -webkit-transition-property: all; -webkit-transition-timing-function: ease-in-out; background-color: rgb(255, 255, 255); border-bottom-color: rgb(221, 221, 221); border-bottom-left-radius: 4px; border-bottom-right-radius: 4px; border-bottom-style: solid; border-bottom-width: 1px; border-left-color: rgb(221, 221, 221); border-left-style: solid; border-left-width: 1px; border-right-color: rgb(221, 221, 221); border-right-style: solid; border-right-width: 1px; border-top-color: rgb(221, 221, 221); border-top-left-radius: 4px; border-top-right-radius: 4px; border-top-style: solid; border-top-width: 1px; box-sizing: border-box; color: rgb(51, 51, 51); display: inline-block; height: 175px; line-height: 20px; margin: 0 auto; max-width: 100%; padding-bottom: 4px; padding-left: 4px; padding-right: 4px; padding-top: 4px; transition-delay: 0s; transition-duration: 0.2s; transition-property: all; transition-timing-function: ease-in-out; vertical-align: middle; width: 175px;'>";
						$view .= "</div>";

						$view .= "<div class='col-md-9'>";
							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Sword Swings</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['sword_swings']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Enchantments</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['enchantments']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Diamonds Found</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['diamonds_found']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Jumps</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['jumps']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Deaths</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['deaths']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Operator Status</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . ($row['is_op']=="yes" ? "Yes" : "No") . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								switch ($row['last_gamemode'])
								{
									case 0: $gm = "Survival"; break;
									case 1: $gm = "Creative"; break;
									case 2: $gm = "Adventure"; break;
									case 3: $gm = "Spectator"; break;
									default: $gm = "Survival";
								}

								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Last Gamemode</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . $gm . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Ban Status</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . ($row['is_banned']=="yes" ? "Yes" : "No") . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Player Kills</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['p_kills']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Mob Kills</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['m_kills']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Blocks Placed</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['blocks_placed']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-4'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Blocks Mined</h3>
											</div>
											<div class='panel-body'>
												<h2 class='text-center override'>" . number_format($row['breaks']) . "</h2>
											</div>
										</div>";
							$view .= "</div>";

							$view .= "<div class='col-md-12'>";
								$view .= "<div class='panel panel-default'>
											<div class='panel-heading'>
												<h3 class='panel-title text-center'>Last Seen</h3>
											</div>
											<div class='panel-body'>
												<h3 class='text-center'>" . $webApp->userFriendlyDate($row['last_seen']) . "</h3>
											</div>
										</div>";
							$view .= "</div>";
						$view .= "</div>";

					$view .= "</div>";
				}else{
					$view = "<h1>Error</h1>
					<p>Player stats not found.</p>";
				}
			}
		}
	}else{
		$view = "<h1>Error</h1>
		<p>No player specified, please <a href='" . $webConf->getConfArray()['general']['url'] . "'>reinitiate search</a>.</p>";
	}

?>
<!doctype html>
<html>
	<head>
		<!-- Some Basic META Info -->
		<meta charset="UTF-8"> <!-- UTF-8 allows the support of a lot more common characters! -->

		<title><?= $webConf->getConfArray()['general']['name'] ?> &lt;MinecraftProfilePro&gt;</title>
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
						<a class="navbar-brand" href="<?= $webConf->getConfArray()['general']['url'] ?>"><?= $webConf->getConfArray()['general']['name'] ?></a>
					</div>
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<li><a href="<?= $webConf->getConfArray()['general']['url'] ?>">Home</a>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a href="https://github.com/matrixdevuk/MinecraftProfilePro" target="_blank">MCPP on Github</a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="jumbotron">
				<?= $view ?>
			</div>
		</div>

		<!-- Bootstrap Javascript Files -->
		<script src="//code.jquery.com/jquery-latest.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
</html>
