<?php
namespace Shift\AvatarMaker\Shape;

class Rhomb extends AbstractPolygon
{

    /**
     * @return array
     */
    protected function getPolygonPoints()
    {
        $midPoint = $this->size / 2;

        return [
            $midPoint, 0,
            $this->size, $midPoint,
            $midPoint, $this->size,
            0, $midPoint,
        ];
    }


}