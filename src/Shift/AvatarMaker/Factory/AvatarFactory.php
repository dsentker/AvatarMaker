<?php
namespace Shift\AvatarMaker\Factory;


use Shift\AvatarMaker\AvatarMaker;
use Shift\AvatarMaker\Shape\ShapeInterface;

class AvatarFactory
{

    /**
     * @param string $shape
     * @param int    $size
     * @param string $driver
     *
     * @return AvatarMaker
     */
    public static function createAvatarMaker($shape = 'circle', $size = 64, $driver = 'gd')
    {
        $shapeClass = sprintf('Shift\AvatarMaker\Shape\%s', ucfirst($shape));
        if(!class_exists($shapeClass)) {
            throw new \InvalidArgumentException(sprintf('Shape class "%s" not found!', $shapeClass));
        }

        $manager = new \Intervention\Image\ImageManager(['driver' => $driver]);
        $shapeReflection = new \ReflectionClass($shapeClass);

        /** @var ShapeInterface $shape */
        $shape = $shapeReflection->newInstanceArgs([$manager, $size]);

        return new AvatarMaker($shape);

    }

}