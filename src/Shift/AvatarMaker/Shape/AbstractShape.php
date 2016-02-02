<?php
namespace Shift\AvatarMaker\Shape;

use Intervention\Image\ImageManager;

abstract class AbstractShape implements ShapeInterface
{

    /** @var int */
    protected $size;

    /** @var ImageManager */
    private $imageManager;

    /**
     * AbstractShape constructor.
     *
     * @param ImageManager $manager
     * @param int          $size
     */
    public function __construct(ImageManager $manager, $size)
    {
        $this->imageManager = $manager;
        $this->size = $size;
    }

    /**
     * @return ImageManager
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }

    /**
     * @return array
     */
    public function getTextPosition()
    {
        $textX = ($this->size / 2) - ($this->size * .01); // Workaround to fix non-centered text
        $textY = $this->size / 2;

        return [$textX, $textY];
    }

    /**
     * @return float
     */
    public function getTextSize()
    {
        return $this->size / 2;
    }

    /**
     * @return int
     */
    public function getTextAngle()
    {
        return 0;
    }


}