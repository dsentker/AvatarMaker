<?php
namespace Shift\AvatarMaker\Shape;

class Random extends AbstractPolygon
{

    /**
     * @return array
     */
    protected function getPolygonPoints()
    {

        $midPoint = rand($this->size / 3, $this->size * .9);

        return [
            $midPoint, 0,
            $this->size, $midPoint,
            $midPoint, $this->size,
            0, $midPoint,
        ];
    }

    /**
     * @return float
     */
    public function getTextSize()
    {
        return $this->size * .33;
    }

    /**
     * @return int
     */
    public function getTextAngle()
    {
        return rand(-50, 50);
    }


}