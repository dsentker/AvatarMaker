<?php
namespace Shift\AvatarMaker\Factory;


use Shift\AvatarMaker\AvatarMaker;

class AvatarFactory
{

    /**
     * @param string $shape
     * @param string $driver
     *
     * @return AvatarMaker
     */
    public static function createAvatarMaker($shape = 'circle', $driver = 'gd')
    {
        $shapeClass = sprintf('Shift\AvatarMaker\Shape\%s', ucfirst($shape));
        if(!class_exists($shapeClass)) {
            throw new \InvalidArgumentException(sprintf('Shape class "%s" not found!', $shapeClass));
        }

        $manager = new \Intervention\Image\ImageManager(['driver' => $driver]);
        $shape = new $shapeClass($manager);
        $avatarMaker = new AvatarMaker($shape);
        return $avatarMaker;


    }

}