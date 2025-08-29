<?php declare(strict_types = 1);

	namespace App\Logger\Handler;

	use App\Logger\MessageBuilder;
	use Exception;
	use Pho\Auth\Session\SessionService;
	use Pho\DI\Containers;
	use Pho\Http\Class\Server;
	use Pho\Http\Enum\Method;
	use Pho\Location;
	use Pho\Logger\AbstractHandler;
	use Pho\Logger\Level;
	use Pho\Logger\LevelFilter;

	class File extends AbstractHandler {

		protected Location $location;
		protected string $path;
		protected array $data = [];

		public function processMessage(Level $level, string $message): void {
			try {
				$data = $this->buildData($level, $message);
				$this->touch();
				$this->append($data);
			} catch(Exception $e) {
				// no report
			}
		}

		public function __construct(LevelFilter $levelFilter, string $filename) {
			parent::__construct($levelFilter);
			/** @var Location $location */
			$location = Containers::get()->get(Location::class);
			$this->location = $location;
			$this->path = $this->buildPath($filename);
		}

		protected function buildPath(string $filename): string {
			return $this->location->logDir()."/".$filename;
		}

		protected function touch(): void {
			$this->touchDir();
			$this->touchFile();
		}

		protected function touchDir(): void {
			$dirname = dirname($this->path);
			if(is_dir($dirname)) return;
			if(!$this->location->createPath($dirname)) throw new Exception("Unable to create dir \"$dirname\".");
			@chmod($dirname, 0766);
		}

		protected function touchFile(): void {
			$filename = $this->path;
			if(is_file($filename)) return;
			if(!touch($filename)) throw new Exception("Unable to create file\"$filename\".");
			@chmod($filename, 0666);
			$timestamp = date("Y-m-d H:i:s");
			$data = vsprintf("--- Created at %s ---", [$timestamp]);
			$this->append($data, false);
		}

		protected function buildData(Level $level, string $message): string {

			$builder = new MessageBuilder();


			$builder
				->addTime()
				->addText(" | ")
				->addIP()
				->addText(" | ")
				->addLevel($level)
				->addText(" | ")
				->addRuntime();

			$url = $this->getUrl();
			$sessionContent = $this->getSessionContent();
			$postArgs = $this->getPostArgs();
			$bodyArgs = $this->getBodyArgs();

			if($url) {
				$builder->addNewline()->addText("Url: ".$url);
			}

			if($sessionContent) {
				$builder->addNewline()->addText("Session: ".$sessionContent);
			}

			if($postArgs) {
				$builder->addNewline()->addText("POST: ".$postArgs);
			}

			if($bodyArgs) {
				$builder->addNewline()->addText("Body: ".$bodyArgs);
			}

			$builder->addNewline()->addText($message);

			return $builder->getMessage();
		}

		protected function getUrl(): ?string {
			if(!$_SERVER) return null;
			if(!array_key_exists("HTTPS", $_SERVER)) return null;
			if(!array_key_exists("HTTP_HOST", $_SERVER)) return null;
			if(!array_key_exists("REQUEST_URI", $_SERVER)) return null;

			return vsprintf("%s://%s%s", [
				$_SERVER["HTTPS"] ? "https" : "http",
				$_SERVER["HTTP_HOST"],
				$_SERVER["REQUEST_URI"],
			]);
		}

		protected function getSessionContent(): ?string {

			/** @var SessionService $sessionService */
			$sessionService = SessionService::getInstance();

			try {
				$content = $sessionService->get()->export();
				if(count($content)) {
					return $this->serialize($content);
				}
			} catch(Exception $e) {
				// null
			}

			return null;
		}

		public function getPostArgs(): ?string {

			$anonymizedPost = $this->anonymizePassword($_POST);

			if(count($anonymizedPost)) {
				return $this->serialize($anonymizedPost);
			} else {
				return null;
			}
		}

		public function getBodyArgs(): ?string {

			$server = Server::getInstance();

			$method = $server->getRequest()->getMethod();
			if($method === Method::GET) {
				return null;
			}

			$contentType = $server->getRequest()->getHeader("Content-Type");
			if(!preg_match("/^application\/json(;.*)?$/", (string) $contentType)) {
				return null;
			}

			$body = $server->getRequest()->getContent();

			$data = (array) json_decode($body, false, 512, JSON_THROW_ON_ERROR);

			return json_encode($this->anonymizePassword($data), JSON_THROW_ON_ERROR);
		}

		protected function serialize(object|array $var): string {
			return json_encode($var);
		}

		protected function anonymizePassword(array $array): array {
			$out = [];
			foreach($array as $key => $value) {
				if(preg_match("/passw/", $key)) {
					$out[$key] = str_repeat("*", 8);
				} else {
					$out[$key] = $value;
				}
			}

			return $out;
		}

		protected function append(string $data, bool $onNewline = true): void {
			$prefix = $onNewline ? "\n" : "";
			if(!file_put_contents($this->path, $prefix.$data, FILE_APPEND)) {
				throw new Exception("Unable write data to \"$this->path\".");
			}
		}
	}