<?php
namespace Shift\AvatarMaker\Shape;

class Column extends AbstractPolygon
{

    /**
     * @return array
     */
    protected function getPolygonPoints()
    {

        $colBorderLeft = $this->size * .25;
        $colBorderRight = $this->size * .75;

        return [
            $colBorderLeft, 0,
            $colBorderRight, 0,
            $colBorderRight, $this->size,
            $colBorderLeft, $this->size,
        ];
    }

    /**
     * @return int
     */
    public function getTextAngle()
    {
        return 90;
    }


}