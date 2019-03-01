<?php
namespace Cubo;

defined('__CUBO__') || new \Exception("No use starting a class without an include");

final class Installation {
	protected static $_Configuration;
	protected static $_Controller;
	protected static $_Database;
	protected static $_Router;
	protected static $_Session;
	
	// Constructor automatically runs the installation
	public function __construct() {
		self::run();
	}
	
	protected static function renderPlugins($html) {
		// Render plugins
		$_Plugins = Plugin::getAll();
		foreach($_Plugins as &$_Plugin) {
			$_Plugin = (object)$_Plugin;
			$plugin = __CUBO__.'\\'.$_Plugin->name.'plugin';
			if(class_exists($plugin))
				$html = $plugin::render($html);
		}
		return $html;
	}
	
	// Render each step
	protected static function renderStep($step = 1) {
		if(!isset($_SESSION['setup'])) $_SESSION['setup'] = (object)array();
		switch($step) {
			case '3':
				$_SESSION['setup']->host_name = $_POST['host_name'] ?? $_SESSION['setup']->host_name ?? 'localhost';
				$_SESSION['setup']->dbo_driver = $_POST['dbo_driver'] ?? $_SESSION['setup']->dbo_driver ?? 'mysql';
				$_SESSION['setup']->database_name = $_POST['database_name'] ?? $_SESSION['setup']->database_name ?? 'cubo-cms';
				$_SESSION['setup']->database_user = $_POST['database_user'] ?? $_SESSION['setup']->database_user ?? '';
				$_SESSION['setup']->database_password = $_POST['database_password'] ?? $_SESSION['setup']->database_password ?? '';
				Configuration::set('database',array('dsn'=>"{$_SESSION['setup']->dbo_driver}:host={$_SESSION['setup']->host_name};dbname={$_SESSION['setup']->database_name}",'user'=>$_SESSION['setup']->database_user,'password'=>$_SESSION['setup']->database_password,'ignore_errors'=>true));
				self::$_Database || self::$_Database = new Database(Configuration::get('database'));
				//$detectedCountry = Locale::getDetectedCountry();
				if(self::$_Database->connected()) {
					// Retrieve list of all countries and select detected country as default
					$listOptions = Locale::getOptions(Locale::getCountryList(),'CW');
					$html = '<h1>Installation</h1><h4 class="text-info">Configure your Regional Settings</h4>';
					$html .= "<p>Preset the defaults for your region. You can add languages later if you want your site to be multilingual.</p>";
					$html .= "<form name=\"form-step3\" action=\"\" method=\"post\">";
					$html .= "<input name=\"next-step\" type=\"hidden\" value=\"4\" />";
					$html .= "<div class=\"form-group\"><label for=\"country-name\">Country Name</label><select name=\"country_name\" id=\"country-name\" class=\"form-control\" value=\"".($_SESSION['setup']->country_name ?? 'US')."\" autofocus />".$listOptions."</select></div>";
					$html .= "<div class=\"form-group\"><a class=\"btn btn-info\" href=\"/?debug&next_step=2\">Back</a><button class=\"btn btn-primary\" type=\"submit\">Next</button></div>";
					$html .= "</form>";
					break;
				} else {
					Session::setMessage(array('alert'=>'danger','icon'=>'exclamation','message'=>"Could not connect to the database. Please review the connection details."));
				}
			case '2':
				$_SESSION['setup']->site_name = $_POST['site_name'] ?? $_SESSION['setup']->site_name ?? '';
				$_SESSION['setup']->domain_name = $_POST['domain_name'] ?? $_SESSION['setup']->domain_name ?? '';
				$_SESSION['setup']->site_email = $_POST['site_email'] ?? $_SESSION['setup']->site_email ?? '';
				$html = '<h1>Installation</h1><h4 class="text-info">Configure your Database Connection</h4>';
				$html .= "<p><em>Cubo CMS</em> uses DBO to connect to the database. We expect you to create the database and a user with minimal permissions of SELECT, UPDATE, and INSERT. Please provide this information in the form below and turn to the next page.</p>";
				$html .= "<form name=\"form-step2\" action=\"\" method=\"post\">";
				$html .= "<input name=\"next-step\" type=\"hidden\" value=\"3\" />";
				$html .= "<div class=\"form-group\"><label for=\"site-name\">Host Name</label><input name=\"host_name\" id=\"host-name\" class=\"form-control\" type=\"text\" placeholder=\"Host Name\" value=\"".($_SESSION['setup']->host_name ?? 'localhost')."\" autofocus required /></div>";
				$html .= "<div class=\"form-group\"><label for=\"dbo-driver\">Database Driver</label><input name=\"dbo_driver\" id=\"dbo-driver\" class=\"form-control\" type=\"text\" placeholder=\"Database Driver\" value=\"".($_SESSION['setup']->dbo_driver ?? 'mysql')."\" required /></div>";
				$html .= "<div class=\"form-group\"><label for=\"database-name\">Database Name</label><input name=\"database_name\" id=\"database-name\" class=\"form-control\" type=\"text\" placeholder=\"Database Name\" value=\"".($_SESSION['setup']->database_name ?? 'cubo-cms')."\" required /></div>";
				$html .= "<div class=\"form-group\"><label for=\"database-user\">Database User</label><input name=\"database_user\" id=\"database-user\" class=\"form-control\" type=\"text\" placeholder=\"Database User\" value=\"".($_SESSION['setup']->database_user ?? '')."\" required /></div>";
				$html .= "<div class=\"form-group\"><label for=\"database-password\">Password (visible)</label><input name=\"database_password\" id=\"database-password\" class=\"form-control\" type=\"text\" placeholder=\"Password\" value=\"".htmlspecialchars($_SESSION['setup']->database_password ?? '')."\" required /></div>";
				$html .= "<div class=\"form-group\"><a class=\"btn btn-info\" href=\"/?debug&next_step=1\">Back</a><button class=\"btn btn-primary\" type=\"submit\">Next</button></div>";
				$html .= "</form>";
				break;
			case '1':
				$html = '<h1>Installation</h1><h4 class="text-info">Configure your Site</h4>';
				$html .= "<p>It looks like you just installed <em>Cubo CMS</em> on your server. On behalf of the staff of <em>Cubo CMS</em>, we like to thank you for your support in using this Content Management System.</p>";
				$html .= "<p>This installer will help you configure your web site to suit your needs. First, we need to acquire some general information about your site. Please fill in the form below and turn to the next page.</p>";
				$html .= '<form name="form-step1" action="" method="post">';
				$html .= "<input name=\"next-step\" type=\"hidden\" value=\"2\" />";
				$html .= "<div class=\"form-group\"><label for=\"site-name\">Site Name</label><input name=\"site_name\" id=\"site-name\" class=\"form-control\" type=\"text\" placeholder=\"Site Name\" value=\"".($_SESSION['setup']->site_name ?? '')."\" autofocus required /></div>";
				$html .= "<div class=\"form-group\"><label for=\"domain-name\">Domain Name</label><input name=\"domain_name\" id=\"domain-name\" class=\"form-control\" type=\"text\" placeholder=\"Domain Name\" value=\"".($_SESSION['setup']->domain_name ?? '')."\" required /></div>";
				$html .= "<div class=\"form-group\"><label for=\"site-email\">Email Site Administrator</label><input name=\"site_email\" id=\"site-email\" class=\"form-control\" type=\"email\" placeholder=\"Email Site Administrator\" value=\"".($_SESSION['setup']->site_email ?? '')."\" required /></div>";
				$html .= "<div class=\"form-group\"><button class=\"btn btn-primary\" type=\"submit\">Next</button></div>";
				$html .= "</form>";
		}
		return $html;
	}
	
	// Initiates and runs the installation
	public static function run() {
		// Get configuration
		self::$_Configuration = new Configuration;
		// Start session
		self::$_Session = new Session;
		// Call router; save URI, URL, and Route as application parameters
		self::$_Router = new Router(Configuration::setParameter('uri',$_SERVER['REQUEST_URI']));
		// Set application parameters
		Configuration::setParameter('base-url',__BASE__);
		Configuration::setParameter('brand-logo',Configuration::get('brand-logo','/vendor/cubo-cms/asset/image/cubo-w192.png'));
		Configuration::setParameter('brand-name',Configuration::get('brand-name','<strong>Cubo</strong> <em>CMS</em>'));
		Configuration::setParameter('generator',"Cubo CMS by Papiando");
		Configuration::setParameter('generator-url',"https://cubo-cms.com");
		Configuration::setParameter('language',Configuration::getDefault('language','en'));
		Configuration::setParameter('provider',"Papiando Riba Internet");
		Configuration::setParameter('provider-url',"https://papiando.com");
		Configuration::setParameter('route',self::$_Router->getRoute() ?? Configuration::getDefault('route','/'));
		Configuration::setParameter('show-user-module',SETTING_NO);
		Configuration::setParameter('site-name',Configuration::get('site-name','Cubo CMS'));
		Configuration::setParameter('template',Configuration::getDefault('template','default'));
		Configuration::setParameter('theme',Configuration::getDefault('theme','default'));
		Configuration::setParameter('title',Configuration::get('site-name','Cubo CMS'));
		Configuration::setParameter('url',__BASE__.current(explode('?',$_SERVER['REQUEST_URI'])));
		// Read route, controller, method, and name
		$html = self::renderStep($_REQUEST['next-step'] ?? 1);
		$html = self::renderPlugins($html);
		echo $html;
	}
}