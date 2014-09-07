<?php

	ini_set("display_errors", "off");
	error_reporting(0);

	require("classes/configuration.php");
	require("classes/web.php");

	$webApp = new WebApp();

	$webConf = new Configuration("web");
	if ($webConf == false)
	{
		die("Couldn't read from configuration file: web/main");
	}

	$mcConf = new Configuration("minecraft");
	if ($mcConf == false)
	{
		die("Couldn't read from configuration file: minecraft/main");
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
						<a class="navbar-brand" href="<?= $webConf->getConfArray()['general']['url'] ?>"><?= $webConf->getConfArray()['general']['name']; ?></a>
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
				<h1>Player Profile Lookup</h1>
				<p>Enter a name below to lookup a user's stats.</p>
				<p>
					<form action="<?= $webConf->getConfArray()['general']['url'] ?>profile.php" method="get">
						<input type="text" name="player" class="form-control"><button type="submit" class="hide">Lookup</button>
					</form>
				</p>

				<?php if ($webConf->getConfArray()['general']['show_online_players'] == true) { ?>
				<h2>Online Players</h2>
				<?php
					$response = $webApp->getServerInformation($mcConf->getConfArray()['ip'], $mcConf->getConfArray()['port'], 1);

					if ($response === false)
					{
						echo "<p class='text-danger'>Error: couldn't query server.</p>";
					}else{
						if (count($response['players'])>0)
						{
							echo "<div class='row'>";

							$current = 0;
							foreach ($response['players'] as $k => $v)
							{
								if ($current == 12)
								{
									break;
								}else{
									$current += 1;
								}
								echo "<div class='col-md-1 text-center'><a href='profile.php?player=" . $v . "'><img src='data:image/png;base64," . $webApp->getAvatar($v, 100) . "' class='img-responsive img-rounded' rel='tooltip' data-original-title='View the Stats of " . $v . "'></a></div>";
							}

							echo "</div>";
						}else{
							echo "<p class='text-muted'>No players are online.</p>";
						}
					}
				}
				?>
			</div>
		</div>

		<!-- Bootstrap Javascript Files -->
		<script src="//code.jquery.com/jquery-latest.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function() {
				$("[rel='tooltip']").tooltip();
			});
		</script>
	</body>
</html>
