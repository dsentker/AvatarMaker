<?php
namespace Shift\AvatarMaker\Shape;

use Intervention\Image\ImageManager;

abstract class AbstractPolygon extends AbstractShape
{

    /**
     * @param string $backgroundColor
     *
     * @return \Intervention\Image\Image
     */
    public function getShapedImage($backgroundColor)
    {

        $image = $this->getImageManager()->canvas($this->size, $this->size, [0, 0, 0, 0]);
        $image->polygon($this->getPolygonPoints(), function ($draw) use ($backgroundColor) {
            $draw->background($backgroundColor);
        });

        return $image;
    }

    /**
     * @return array
     */
    abstract protected function getPolygonPoints();


}