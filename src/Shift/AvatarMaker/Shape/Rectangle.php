<?php
namespace Shift\AvatarMaker\Shape;


use Intervention\Image\ImageManager;

class Rectangle extends AbstractShape
{

    /**
     * @param int    $size
     * @param string $backgroundColor
     *
     * @return \Intervention\Image\Image
     */
    public function getShapedImage($size, $backgroundColor)
    {
        return $this->getImageManager()->canvas($size, $size, $backgroundColor);
    }


}