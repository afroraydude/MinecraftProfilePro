<?php

	/*
	*  MinecraftProfilePro // https://github.com/matrixdevuk/MinecraftProfilePro
	*  by @matrixdevuk
	*/

	class WebApp
	{

		public function userFriendlyDate($original)
		{
			$chunks = array(
				array(60 * 60 * 24 * 365, "year"),
				array(60 * 60 * 24 * 30, "month"),
				array(60 * 60 * 24 * 7, "week"),
				array(60 * 60 * 24, "day"),
				array(60 * 60, "hour"),
				array(60, "min"),
				array(1, "sec"),
			);

			$today = time();
			$since = $today - $original;

			for ($i = 0, $j = count($chunks); $i < $j; $i++)
			{

				$seconds = $chunks[$i][0];
				$name = $chunks[$i][1];

				if (($count = floor($since / $seconds)) != 0)
				{
					break;
				}
			}

			$print = ($count == 1) ? "1 " . $name : $count . " " . $name . "s";

			$print .= ", ";

			if ($i + 1 < $j)
			{
				$seconds2 = $chunks[$i + 1][0];
				$name2 = $chunks[$i + 1][1];

				if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0)
				{
					$print .= ($count2 == 1) ? " 1 " . $name2 : " " . $count2 . " " . $name2 . "s";
				}
			}

			$print .= " ago";

			if (strstr(substr($print, 0, 7), "sec"))
			{
				return "Just now";
			}else{
				return $print;
			}
		}

		public function getAvatar($user, $size)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'http://s3.amazonaws.com/MinecraftSkins/' . $user . '.png');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			$output = curl_exec($ch);
			$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			if ($status != '200') {
				// Default Skin: http://www.minecraft.net/skin/char.png
				$output = 'iVBORw0KGgoAAAANSUhEUgAAAEAAAAAgCAMAAACVQ462AAAABGdBTUEAALGPC/xhBQAAAwBQTFRFAAAAHxALIxcJJBgIJBgKJhg';
				$output .= 'LJhoKJxsLJhoMKBsKKBsLKBoNKBwLKRwMKh0NKx4NKx4OLR0OLB4OLx8PLB4RLyANLSAQLyIRMiMQMyQRNCUSOigUPyoVKCgoP';
				$output .= 'z8/JiFbMChyAFtbAGBgAGhoAH9/Qh0KQSEMRSIOQioSUigmUTElYkMvbUMqb0UsakAwdUcvdEgvek4za2trOjGJUj2JRjqlVkn';
				$output .= 'MAJmZAJ6eAKioAK+vAMzMikw9gFM0hFIxhlM0gVM5g1U7h1U7h1g6ilk7iFo5j14+kF5Dll9All9BmmNEnGNFnGNGmmRKnGdIn';
				$output .= '2hJnGlMnWpPlm9bnHJcompHrHZaqn1ms3titXtnrYBttIRttolsvohst4Jyu4lyvYtyvY5yvY50xpaA////AAAAAAAAAAAAAAA';
				$output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
				$output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
				$output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
				$output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
				$output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
				$output .= 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';
				$output .= 'AAAAAAAAAAAAAAAAAAAAAPSUN6AAAAQB0Uk5T/////////////////////////////////////////////////////////////';
				$output .= '//////////////////////////////////////////////////////////////////////////////////////////////////';
				$output .= '//////////////////////////////////////////////////////////////////////////////////////////////////';
				$output .= '///////////////////////////////////////////////////////////////////////////////////AFP3ByUAAAAYdEV';
				$output .= 'YdFNvZnR3YXJlAFBhaW50Lk5FVCB2My4zNqnn4iUAAAKjSURBVEhLpZSLVtNAEIYLpSlLSUITLCBaGhNBQRM01M2mSCoXNUURI';
				$output .= 'kZFxQvv/wz6724Wij2HCM7J6UyS/b+dmZ208rsww6jiqo4FhannZb5yDqjaNgDVwE/8JAmCMqF6fwGwbU0CKjD/+oAq9jcM27g';
				$output .= 'xAFpNQxU3Bwi9Ajy8fgmGZuvaGAcIuwFA12CGce1jJESr6/Ot1i3Tnq5qptFqzet1jRA1F2XHWQFAs3RzwTTNhQd3rOkFU7c0D';
				$output .= 'ijmohRg1TR9ZmpCN7/8+PX954fb+sTUjK7VLKOYi1IAaTQtUrfm8pP88/vTw8M5q06sZoOouSgHEDI5vrO/eHK28el04yxf3N8';
				$output .= 'ZnyQooZiLfwA0arNb6d6bj998/+vx8710a7bW4E2Uc1EKsEhz7WiQBK9eL29urrzsB8ngaK1JLDUXpYAkGSQH6e7640fL91dWX';
				$output .= 'jxZ33138PZggA+Sz0WQlAL4gmewuzC1uCenqXevMPWc9XrMX/VXh6Hicx4ByHEeAfRg/wtgSMAvz+CKEkYAnc5SpwuD4z70PM+';
				$output .= 'hUf+4348ixF7EGItjxmQcCx/Dzv/SOkuXAF3PdT3GIujjGLELNYwxhF7M4oi//wsgdlYZdMXCmEUUSsSu0OOBACMoBTiu62BdR';
				$output .= 'PEjYxozXFyIpK7IAE0IYa7jOBRqGlOK0BFq3Kdpup3DthFwP9QDlBCGKEECoHEBEDLAXHAQMQnI8jwFYRQw3AMOQAJoOADoAVc';
				$output .= 'DAh0HZAKQZUMZdC43kdeqAPwUBEsC+M4cIEq5KEEBCl90mR8CVR3nxwCdBBS9OAe020UGnXb7KcxzPY9SXoEEIBZtgE7UDgBKy';
				$output .= 'LMhgBS2YdzjMJb4XHRDAPiQhSGjNOxKQIZTgC8BiMECgarxprjjO0OXiV4MAf4A/x0nbcyiS5EAAAAASUVORK5CYII=';
				$output = base64_decode($output);
			}

			$im = imagecreatefromstring($output);
			$av = imagecreatetruecolor($size, $size);
			imagecopyresized($av, $im, 0, 0, 8, 8, $size, $size, 8, 8);
			imagecolortransparent($im, imagecolorat($im, 63, 0));
			imagecopyresized($av, $im, 0, 0, 40, 8, $size, $size, 8, 8);
			ob_start();
			imagepng($av);
			$image_data = ob_get_contents();
			ob_end_clean();
			return base64_encode($image_data);
		}

		public function getServerInformation($host, $port = 25565, $timeout = 1)
		{
			//Set up our socket
			$fp = fsockopen("udp://" . $host, $port, $errno, $errstr, $timeout);

			if(!$fp || is_null($fp) || empty($fp))
			{ return false; }

			// Get the challenge token; send 0xFE 0xFD 0x09 and a 4-byte session id
			$str1 = "\xFE\xFD\x09\x01\x02\x03\x04";	// Arbitrary session id at the end (4 bytes)
			fwrite($fp, $str1);
			$resp1 = fread($fp, 256);

			if(!$resp1 || $resp1[0] != "\x09")	// Check for a valid response
			{ return false; }

			// Parse the challenge token from string to integer
			$token = 0;
			for($i = 5; $i < (strlen($resp1) - 1); $i++)
			{
				$token *= 10;
				$token += $resp1[$i];
			}

			// Divide the int32 into 4 bytes
			$token_arr = array(0 => ($token / (256*256*256)) % 256, 1 => ($token / (256*256)) % 256, 2 => ($token / 256) % 256, 3 => ($token % 256));

			// Get the full version of server status. ID and challenge tokens appended to command 0x00, payload padded to 8 bytes.
			$str = "\xFE\xFD\x00\x01\x02\x03\x04" . chr($token_arr[0]) . chr($token_arr[1]) . chr($token_arr[2]) . chr($token_arr[3]) . "\x00\x00\x00\x00";
			fwrite($fp, $str);
			$data2 = fread($fp, 4096);
			$full_stat = substr($data2, 11);	// Strip the crap from the start

			$tmp = explode("\x00\x01player_\x00\x00", $full_stat);	// First, split the payload in two parts
			$t = explode("\x00", $tmp[0]);		// Divide the first part from every NULL-terminated string end into key1 val1 key2 val2...
			unset($t[count($t) - 1]);		// Unset the last entry, because the are two 0x00 bytes at the end
			$t2 = explode("\x00", $tmp[1]);		// Explode the player information from the second part

			$info = array();
			for($i = 0; $i < count($t); $i += 2)
			{
				if($t[$i] == "")
				{ break; }

				$info[$t[$i]] = $t[$i + 1];
			}

			$players = array();
			foreach($t2 as $one)
			{
				if($one == "")
				{ break; }

				$players[] = $one;
			}

			$full_stat = $info;
			$full_stat['players'] = $players;

			return $full_stat;
		}

	}
