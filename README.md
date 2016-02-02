# AvatarMaker

This class creates an GMail-like avatar image by given string (e.g. username).

## Installation
```sh
$ composer require shiftedwork/avatarmaker
```

## Usage
```php
$avatar = AvatarFactory::createAvatarMaker('rectangle'); // choose 'rectangle' or 'circle' for avatar shape
$avatar->setBackgroundLuminosity('bright'); 
$avatar->setSize(64);
$avatar->setHues(['red', 'orange']);

// direct output
printf('<img alt="Avatar" src="%s"/>', $avatar->makeAvatar('John Doe')->toBase64());

// save to file
$avatar->save('path/to/user.png');

```