<?php

namespace Shift\AvatarMaker\Shape;


use Intervention\Image\Image;
use Intervention\Image\ImageManager;

interface ShapeInterface
{

    /**
     * ShapeInterface constructor.
     *
     * @param ImageManager $manager ImageManager instance
     * @param int          $size    Canvas size
     */
    public function __construct(ImageManager $manager, $size);

    /**
     * @param string $backgroundColor
     *
     * @return Image
     */
    public function getShapedImage($backgroundColor);

    /**
     * Returns shape-defined text-positions as array ([x,y])
     *
     * @return array
     */
    public function getTextPosition();

    /**
     * @return float
     */
    public function getTextSize();

    /**
     * @return int
     */
    public function getTextAngle();

}