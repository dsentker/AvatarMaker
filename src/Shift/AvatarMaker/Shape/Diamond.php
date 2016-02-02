<?php
namespace Shift\AvatarMaker\Shape;

class Diamond extends AbstractPolygon
{

    /**
     * @return array
     */
    protected function getPolygonPoints()
    {
        return [
            $this->size / 2, 0,
            $this->size, $this->size,
            0, $this->size,
        ];
    }

    /**
     * @return array
     */
    public function getTextPosition()
    {
        $textX = ($this->size / 2) - ($this->size * .01); // Workaround to fix non-centered text
        $textY = $this->size * .7;

        return [$textX, $textY];

    }

    /**
     * @return float
     */
    public function getTextSize()
    {
        return $this->size * .4;
    }


}