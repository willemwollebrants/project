<?php

$cwd = getcwd();

if (file_exists("{$cwd}/system/app/src/Application.php")) {
    print_r("! Setup was already completed\n");
    exit();
}

$pubdir = readline("Public directory [./public]: ");

$pub = trim($pubdir? : '/public', '/');


$dirs = [
    "{$cwd}/{$pub}",
    "{$cwd}/{$pub}/css",
    "{$cwd}/{$pub}/js",
    "{$cwd}/{$pub}/img",
    "{$cwd}/system/app/src",
    "{$cwd}/system/app/src/Controller",
    "{$cwd}/system/app/src/Entity",
    "{$cwd}/system/app/src/Form",
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir);
    }
}


$files_pub = [
    "{$cwd}/{$pub}/config.rb" => __DIR__ . "/res/public_config.rb",
    "{$cwd}/{$pub}/index.php" => __DIR__ . "/res/public_index.php",
];

foreach ($files_pub as $target => $src) {
    if (!file_exists($target)) {
        file_put_contents($target, file_get_contents($src));
    }
}

$ns = readline("Namespace [\\App]: ");

$ns = trim($ns? : "\\App", '\\');
$nss = str_replace("\\", "\\\\", $ns);

$files_sys = [
    "{$cwd}/system/app/src/Application.php" => __DIR__ . "/res/app_Application.php",
    "{$cwd}/system/init.php" => __DIR__ . "/res/app_init.php",
];

foreach ($files_sys as $target => $src) {
    if (!file_exists($target)) {

        $content = str_replace(
                ["%NS%", "%NSS%"], [$ns, $nss], file_get_contents($src));
        file_put_contents($target, '<?php' . PHP_EOL . $content);
    }
}

$composer = "{$cwd}/system/composer.json";
$co =  json_decode(file_get_contents($composer), true);
$co['autoload']['psr-4']["{$nss}\\"] = "/app/src";
file_put_contents($composer, json_encode($co, JSON_UNESCAPED_SLASHES));
