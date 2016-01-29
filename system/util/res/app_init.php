/* @var $al \Composer\Autoload\ClassLoader */

$al = include __DIR__ . "/vendor/autoload.php";
$al->addPsr4("%NSS%\\", __DIR__ . "/app/src");

/**
 * @return \%NS%\Application
 **/ 
function app()
{
    static $app;
    if (is_null($app)) {
        $app = new \%NS%\Application(__DIR__ . "/app");
    }

    return $app;
}

app()->execute();
