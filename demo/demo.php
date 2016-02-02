<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(-1);

require_once __DIR__ . '/../vendor/autoload.php';
// require_once '../temp/test-includes.php';

// If you get "Could not find/open font" errors with the "gd" driver, try
// setting this environment variable.
#putenv('GDFONTPATH=.');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Avatar Test</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        div {
            float: left;
            padding: 1%;
            margin: 1%;
            width: 20%;
            border: 1px solid #ddd;
        }

        img {
            float: right;
        }

    </style>
</head>
<body>
<?php
foreach ([
             'circle'    => 'John Doe',
             'diamond'   => 'J. D.',
             'random'    => 'william.16.smith@gmail.com',
             'rectangle' => '"Bob"',
             'column'    => 'John, Alice',
             'rhomb'     => \PHP_VERSION

         ] as $shape => $name) {

    $avatar = \Shift\AvatarMaker\Factory\AvatarFactory::createAvatarMaker($shape, 64);
    $avatar->setBackgroundLuminosity('bright');
    $avatar->setHues(['red', 'orange']);
    $avatar->setFontFile('segoeui.ttf');
    $img = $avatar->makeAvatar($name)->toBase64();
    printf('<div><img alt="Avatar" src="%s"/><p>%s</p></div>', $img, $name);
}
?>
</body>
</html>
