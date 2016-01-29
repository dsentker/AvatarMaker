# AvatarMaker

This class creates an GMail-like avatar image by given string (e.g. username).

## Installation
```sh
$ composer require shiftedwork/avatarmaker
```

## Usage
```php
$manager = new \Intervention\Image\ImageManager(['driver' => 'gd']);
$avatar = new \Shift\AvatarMaker\AvatarMaker($manager);
$avatar->setBackgroundLuminosity('bright');
$avatar->setSize(64);
$avatar->setHues(['red', 'orange']);

$name = 'John Doe';
$img = $avatar->makeAvatar($name)->toBase64();
printf('<h2>%s</h2><img alt="Avatar" src="%s"/><hr />', $name, $img);
```