<?php

namespace Shift\AvatarMaker\Shape;


use Intervention\Image\Image;
use Intervention\Image\ImageManager;

interface ShapeInterface
{

    /**
     * ShapeInterface constructor.
     *
     * @param ImageManager $manager
     */
    public function __construct(ImageManager $manager);

    /**
     * @param int    $size
     * @param string $backgroundColor
     *
     * @return Image
     */
    public function getShapedImage($size, $backgroundColor);
}