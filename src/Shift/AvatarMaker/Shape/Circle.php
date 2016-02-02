<?php
namespace Shift\AvatarMaker\Shape;


use Intervention\Image\ImageManager;

class Circle extends AbstractShape
{

    /**
     * @param int    $size
     * @param string $backgroundColor
     *
     * @return \Intervention\Image\Image
     */
    public function getShapedImage($size, $backgroundColor)
    {
        $image = $this->getImageManager()->canvas($size, $size, [0, 0, 0, 0]);
        $image->circle($size - 1, $size / 2, $size / 2, function ($draw) use ($backgroundColor) {
            $draw->background($backgroundColor);
        });

        return $image;
    }


}