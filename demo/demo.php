<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(-1);
//require_once 'vendor/autoload.php';

$manager = new \Intervention\Image\ImageManager(['driver' => 'gd']);
$avatar = new \Shift\AvatarMaker\AvatarMaker($manager);
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
        }
    </style>
</head>
<body>
<?php
foreach (['John Doe', 'J. D.', 'William D. Smith', 'Megan Fox'] as $name) {
    $img = $avatar->makeAvatar($name)->toBase64();
    printf('<h2>%s</h2><img alt="Avatar" src="%s"/><hr />', $name, $img);
}
?>
</body>
</html>

