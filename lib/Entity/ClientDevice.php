<?php
namespace ZealByte\Bundle\PlatformBundle\Entity
{
	class ClientDevice
	{
		private $client_info;

		private $operating_system_info;

		private $brand;

		private $model;

		private $is_device;

		private $is_bot;

		private $client_ip_address;


		public function getClientIpAddress ()
		{
			return $this->client_ip_address;
		}

		public function getClientInfo ()
		{
			return $this->client_info;
		}

		public function getOperatingSystemInfo ()
		{
			return $this->operating_system_info;
		}

		public function getBrand ()
		{
			return $this->brand;
		}

		public function getModel ()
		{
			return $this->model;
		}

		public function isDevice ()
		{
			return $this->is_device ? true : false;
		}

		public function isBot ()
		{
			return $this->is_bot;
		}


		public function setClientIpAddress (string $client_ip_address)
		{
			$this->client_ip_address = $client_ip_address;

			return $this;
		}

		public function setClientInfo (array $client_info) : self
		{
			$this->client_info = $client_info;

			return $this;
		}

		public function setOperatingSystemInfo (array $operating_system_info) : self
		{
			$this->operating_system_info = $operating_system_info;

			return $this;
		}

		public function setBrand (string $brand) : self
		{
			$this->brand = $brand;

			return $this;
		}

		public function setModel (string $model) : self
		{
			$this->model = $model;

			return $this;
		}

		public function setIsDevice (bool $is_device) : self
		{
			$this->is_device = $is_device;

			return $this;
		}

		public function setIsBot (bool $is_bot) : self
		{
			$this->is_bot = $is_bot;

			return $this;
		}

	}
}
