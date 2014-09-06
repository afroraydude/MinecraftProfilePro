<?php

	/*
	*  MinecraftProfilePro // https://github.com/matrixdevuk/MinecraftProfilePro
	*  by @matrixdevuk
	*/

	class Configuration
	{

		protected $configuration;

		public function __construct($conf)
		{
			if (file_exists("configuration/" . $conf . "/main.json") && is_readable("configuration/" . $conf . "/main.json"))
			{
				$this->configuration = json_decode(file_get_contents("configuration/" . $conf . "/main.json"), true);
				return true;
			}else{
				return false;
			}
		}

		public function getConfArray()
		{
			return $this->configuration;
		}

	}
