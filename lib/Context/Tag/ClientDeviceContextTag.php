<?php
namespace ZealByte\Bundle\PlatformBundle\Formatter
{
	use Symfony\Component\HttpFoundation\RequestStack;
	use Symfony\Component\Cache\Adapter\ApcuAdapter;
	use DeviceDetector\DeviceDetector;
	use DeviceDetector\Parser\Device\DeviceParserAbstract;
	use DeviceDetector\Cache\PSR6Bridge;
	use DeviceDetector\Yaml\Symfony as SymfonyYamlParser;
	use ZealByte\Platform\Formatter\TagFormatterInterface;
	use ZealByte\Bundle\PlatformBundle\Entity\ClientDevice;

	class ClientDeviceFormatter implements TagFormatterInterface
	{
		protected $value;

		private $device;

		private $requestStack;

		public function __construct (RequestStack $request_stack = null)
		{
			if ($request_stack)
				$this->setRequestStack($request_stack);
		}

		public function get ()
		{
			if (!$this->device && $this->requestStack)
				$this->detectDevice();

			return $this->device;
		}

		public function set ($value)
		{
			$this->value = $value;
		}

		public function setRequestStack (RequestStack $request_stack)
		{
			$this->requestStack = $request_stack;
		}

		private function detectDevice () : void
		{
			$userAgent = $this->findUserAgent();

			if ($userAgent) {
				$detector = new DeviceDetector($userAgent);

				$this->setupDeviceDetector($detector);
				$this->parseDeviceHeader($detector);
			}
		}

		private function findUserAgent () : ?string
		{
			$request = $this->requestStack->getMasterRequest();

			if ($request && $request->headers->has('User-Agent'))
				return $request->headers->get('User-Agent');

			return null;
		}

		private function findClientIpAddress () : ?string
		{
			$request = $this->requestStack->getMasterRequest();

			if ($request && $request->headers->has('User-Agent'))
				return $request->getClientIp();

			return null;
		}

		private function setupDeviceDetector (DeviceDetector $detector) : void
		{
			//$cache = new ApcuAdapter();

			$detector->discardBotInformation();
			//$detector->setCache(new PSR6Bridge($cache));
			//$detector->setYamlParser(new SymfonyYamlParser());
		}

		private function parseDeviceHeader (DeviceDetector $detector) : void
		{
			$detector->parse();

			$this->device = (new ClientDevice())
				->setClientIpAddress($this->findClientIpAddress())
				->setIsBot($detector->isBot())
				->setIsDevice((bool) $detector->getDevice())
				->setClientInfo($detector->getClient())
				->setOperatingSystemInfo($detector->getOs())
				->setBrand($detector->getBrandName())
				->setModel($detector->getModel());
		}

	}
}
