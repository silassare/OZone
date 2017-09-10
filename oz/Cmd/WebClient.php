<?php
	/**
	 * Copyright (c) Emile Silas Sare <emile.silas@gmail.com>
	 *
	 * This file is part of the OZone package.
	 *
	 * For the full copyright and license information, please view the LICENSE
	 * file that was distributed with this source code.
	 */

	namespace OZONE\OZ\Cmd;

	use Kli\KliAction;
	use Kli\KliOption;
	use Kli\Types\KliTypeString;
	use OZONE\OZ\Cmd\Utils\Utils;
	use OZONE\OZ\FS\OZoneFS;
	use OZONE\OZ\FS\OZoneTemplates;

	final class WebClient extends OZoneCommand
	{
		/**
		 * {@inheritdoc}
		 */
		public function execute(KliAction $action, array $options, array $anonymous_options)
		{
			switch ( $action->getName() ){
				case 'add':
					$this->add($options);
					break;
			}
		}

		/**
		 * add new web client.
		 *
		 * @param array $options
		 */
		private function add(array $options)
		{
			$host           = $options['h'];
			$folder         = $options['f'];
			$project_folder = getcwd();
			$config = Utils::loadProjectConfig($project_folder);

			if ($config === null) {
				$this->getCli()
					 ->writeLn(sprintf('Error: there is no ozone project in "%s".', $project_folder), true)
					 ->writeLn('Make sure to be in your project root folder.', true);

				return;
			}

			$project_name = $config['OZ_PROJECT_NAME'];
			$namespace    = $config['OZ_PROJECT_NAMESPACE'];
			$class_name   = $config['OZ_PROJECT_CLASSNAME'];
			$api_key      = '--YOUR OZONE API KEY HERE--';

			$inject = [
				'oz_version_name'      => OZ_OZONE_VERSION_NAME,
				'oz_time'              => time(),
				'oz_project_namespace' => $namespace,
				'oz_project_class'     => $class_name,
				'oz_default_apikey'    => $api_key
			];

			$www_index = OZoneTemplates::compute('oz:gen/index.www.otpl', $inject);

			$tpl_folder = OZ_OZONE_DIR . 'oz_templates' . DS;

			$fs = new OZoneFS($project_folder);
			$fs->cd($folder, true)
				->cd('oz_private', true)
					->mkdir('oz_templates')
					->mkdir('oz_settings')
					->cp($tpl_folder . 'gen/htaccess.deny.txt', '.htaccess')
					->cd('..')
				->wf('index.php', $www_index)
				->cp($tpl_folder . 'gen/robots.txt', 'robots.txt')
				->cp($tpl_folder . 'gen/favicon.ico', 'favicon.ico')
				->cp($tpl_folder . 'gen/htaccess.www.txt', '.htaccess');

			$this->getCli()
				 ->writeLn(sprintf('Success: web client added to project "%s".', $project_name), true)
				 ->writeLn(sprintf('Client Host  : %s', $host))
				 ->writeLn(sprintf('Client ApiKey: %s', $api_key));
		}

		/**
		 * {@inheritdoc}
		 */
		protected function describe()
		{
			$this->description("Manage your ozone web client.");
			$host_reg = '#^https?\:\/\/(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])(?:\.(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9]))*$#';

			// action: add web client
			$add = new KliAction('add');
			$add->description('Add new web client to project.');

			// option: -h alias --host
			$h = new KliOption('h');
			$h->alias('host')
			  ->offsets(1)
			  ->required()
			  ->type((new KliTypeString)->pattern($host_reg,'"%s" is not a valid hostname.'))
			  ->prompt(true, 'The web client hostname')
			  ->description('The web client hostname.');

			// option: -f alias --folder
			$n = new KliOption('-f');
			$n->alias('folder')
			  ->offsets(2)
			  ->type((new KliTypeString)->pattern('#^[^\\/?%*:|"<>]+$#'))
			  ->description('The name of the subfolder in which a web client will be generated.');

			$add->addOption($h)->addOption($f);

			$this->addAction($create);
		}
	}