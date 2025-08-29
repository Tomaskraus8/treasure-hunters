<?php declare(strict_types = 1);

	use App\Logger\DatabaseLogger;
	use App\Logger\DatabaseLoggerInterface;
	use App\Userstamp;
	use Pho\Auth\Interface\SessionConfigInterface;
	use Pho\DI\Container;
	use Pho\DI\Containers;
	use Pho\FileWatcher\FileWatcherInterface;
	use Pho\Http\Class\HttpConfig;
	use Pho\Http\Interface\HttpConfigInterface;
	use Pho\Location;
	use Pho\Logger\Logger;
	use Pho\Logger\LoggerInterface;
	use Pho\Mailer\Class\MailerConfig;
	use Pho\Mailer\Interface\MailerConfigInterface;
	use Pho\Repository\Class\Mysql;
	use Pho\Repository\Interface\DatabaseInterface;
	use Pho\Repository\Interface\UserstampInterface;

	(function() {

		/**
		 * Declare DI containers common to all environments.
		 */

		$container = new Container();

		$container->registerShared(DatabaseLoggerInterface::class, new DatabaseLogger());
		$container->registerShared(UserstampInterface::class, Userstamp::getInstance());
		$container->registerShared(Location::class, new Location(ROOT_DIR));
		$container->registerShared(SessionConfigInterface::class, SESSION);
		$container->registerShared(LoggerInterface::class, new Logger());

		$db = new Mysql(MYSQL, $container->get(DatabaseLoggerInterface::class));

		$httpConfig = new HttpConfig(HTTP_DOMAIN, ENV->isLocalhostOrDevel(), ROOT_DIR);
		$mailerConfig = new MailerConfig(MAILER->fromMail, MAILER->fromName, MAILER->host, MAILER->port, MAILER->username, MAILER->password, HTTP_DOMAIN, whitelist: MAILER->whitelist, isWhitelistActive: MAILER->isWhitelistActive);

		$container->registerShared(DatabaseInterface::class, $db);
		$container->registerShared(HttpConfigInterface::class, $httpConfig);
		$container->registerShared(MailerConfigInterface::class, $mailerConfig);
		$container->registerShared(FileWatcherInterface::class, $fileWatcher);

		Containers::add(Containers::MAIN, $container);
	})();