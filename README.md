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

// direct output
printf('<img alt="Avatar" src="%s"/>', $avatar->makeAvatar('John Doe')->toBase64());

// save to file
$avatar->save('path/to/user.png');

```