# AvatarMaker

This class creates an GMail-like avatar image by given string (e.g. username).

## Installation
```sh
$ composer require shiftedwork/avatarmaker
```

## Usage
```php
$avatar = AvatarFactory::createAvatarMaker('circle', 64); // choose 'circle' or 'column', 'diamond', 'random', 'rectangle' or 'rhomb' for avatar shape

$avatar->setHues(['red', 'orange']);

// direct output
printf('<img alt="Avatar" src="%s"/>', $avatar->makeAvatar('John Doe')->toBase64());

```

## Advanced Usage
```php

$size = 128;
$manager = new ImageManager(['driver' => 'imagick']);           
$shape = new Shift\AvatarMaker\Shape\Rhomb($manager, $size);    // create shape and define avatar size
$avatar = new AvatarMaker($shape);                              
$avatar->setBackgroundLuminosity('bright');                     // choose 'bright', 'light' or 'dark'
$avatar->setHues(['red', 'orange', 'yellow']);                  // set one or more hues
$avatar->setSeparator('@');                                     // define separator character(s) for name splitting
$avatar->setFontFile('path/to/font.ttf');
$avatar->setCharLength(3);                                      // default: 2 characters

// save to file
$avatarMaker->makeAvatar('hello.world@exampl.net')->save('path/to/user.png');


```