<?php
namespace Shift\AvatarMaker\Shape;


use Intervention\Image\ImageManager;

class Rectangle extends AbstractShape
{

    /**
     * @param string $backgroundColor
     *
     * @return \Intervention\Image\Image
     */
    public function getShapedImage($backgroundColor)
    {
        return $this->getImageManager()->canvas($this->size, $this->size, $backgroundColor);
    }


}