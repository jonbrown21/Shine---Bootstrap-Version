<?PHP
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 'On');  //On or Off

ini_set("session.save_path", "/var/www/tmp");
ini_set("session.save_handler","files");
ini_set("session.use_cookies","1");

#ini_set('session.save_handler', "memcache");
#ini_set('session.save_path', "tcp://127.0.0.1:11211?persistent=1&amp;weight=1&amp;timeout=1&amp;retry_interval=15");

	date_default_timezone_set('America/Chicago');

    // Application flag
    define('SPF', true);
	define('DEFAULT_IPN_URL', 'https://www.paypal.com/cgi-bin/webscr?');
	define('SANDBOX_IPN_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr?');

    // Determine our absolute document root
    define('DOC_ROOT', realpath(dirname(__FILE__) . '/../'));

    // Global include files
    require DOC_ROOT . '/includes/functions.inc.php'; // __autoload() is contained in this file
    require DOC_ROOT . '/includes/class.dbobject.php';
    require DOC_ROOT . '/includes/class.objects.php';
    require DOC_ROOT . '/includes/markdown.inc.php';
    require DOC_ROOT . '/includes/Postmark.php';

    // Fix magic quotes
    if(get_magic_quotes_gpc())
    {
        $_POST    = fix_slashes($_POST);
        $_GET     = fix_slashes($_GET);
        $_REQUEST = fix_slashes($_REQUEST);
        $_COOKIE  = fix_slashes($_COOKIE);
    }

    // Load our config settings
    $Config = Config::getConfig();

    // Store session info in the database?
    if($Config->useDBSessions === true)
        DBSession::register();

    // Initialize our session
	
	session_name('spfs');
    session_start();

    // Initialize current user
    $Auth = Auth::getAuth();

    // Object for tracking and displaying error messages
    $Error = Error::getError();

    $nav = '';
