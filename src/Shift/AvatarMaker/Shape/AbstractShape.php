<?php
namespace Shift\AvatarMaker\Shape;

use Intervention\Image\ImageManager;

abstract class AbstractShape implements ShapeInterface
{

    /** @var ImageManager */
    private $imageManager;

    public function __construct(ImageManager $manager)
    {
        $this->imageManager = $manager;
    }

    /**
     * @return ImageManager
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }


}