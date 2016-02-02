<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(-1);

require_once __DIR__ . '/../vendor/autoload.php';
//require_once '../temp/test-includes.php';
$avatar = \Shift\AvatarMaker\Factory\AvatarFactory::createAvatarMaker('rectangle');

// If you get "Could not find/open font" errors with the "gd" driver, try
// setting this environment variable
#putenv('GDFONTPATH=.');

$avatar->setBackgroundLuminosity('bright');
$avatar->setSize(64);
$avatar->setHues(['red', 'orange']);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Avatar Test</title>
    <style>
        body {
            background-color: #eee;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }
        div {
            float: left;
            padding: 1%;
            margin: 1%;
            width: 20%;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<?php
$greekOmega = "\xCE\xA9";

foreach (['John Doe', 'J. D.', 'William D. Smith', 'Megan Fox', 'Bob', 'Ü1', '#!', $greekOmega] as $name) {
    $img = $avatar->makeAvatar($name)->toBase64();
    printf('<div><h2>%s</h2><img alt="Avatar" src="%s"/></div>', $name, $img);
}
?>
</body>
</html>
