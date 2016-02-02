<?php
namespace Shift\AvatarMaker;

use Colors\RandomColor;
use Intervention\Image\ImageManager;
use Shift\AvatarMaker\Shape\ShapeInterface;

class AvatarMaker
{
    /**
     * @var ShapeInterface
     */
    protected $shape;

    /**
     * @var null|\Intervention\Image\Image
     */
    protected $image = null;

    /**
     * @var int
     */
    protected $size = 100;

    /**
     * @var array
     */
    protected $hues = []; // random

    /**
     * @var string
     */
    protected $backgroundLuminosity = 'dark';

    /**
     * @var string
     */
    protected $textColor = '#f2f2f2';

    /**
     * @var int
     */
    protected $textSize = 30;

    /**
     * @var int
     */
    protected $charLength = 2;

    /**
     * AvatarMaker constructor.
     *
     * @param ShapeInterface $shape
     */
    public function __construct(ShapeInterface $shape)
    {

        if (!class_exists('Colors\RandomColor')) {
            throw new \RuntimeException('RandomColor class is required!');
        }

        $this->shape = $shape;
    }

    /**
     * @return string
     */
    protected function getRandomColor()
    {
        return RandomColor::one([
            'luminosity' => $this->backgroundLuminosity,
            'hue'        => $this->hues,
            'format'     => 'hex',
        ]);
    }

    /**
     * @param $string
     *
     * @return string
     */
    protected function getInitials($string)
    {

        $initials = '';

        // thanks to http://php.net/manual/de/function.preg-split.php#92632
        $words = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[\s,]+/", $string, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < $this->charLength; $i++) {
            if (!empty($words[$i])) {
                $initials .= substr($words[$i], 0, 1);
            }
        }

        $initialsLength = strlen($initials);

        if ($initialsLength < $this->charLength) {
            $missingChars = $this->charLength - $initialsLength;
            $lastWord = end($words);
            $lastWordCharacters = str_split($lastWord);
            for ($i = 1; $i <= $missingChars; $i++) {
                if (empty($lastWordCharacters[$i])) {
                    break;
                }
                $initials .= $lastWordCharacters[$i];
            }

        }

        return $initials;


    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function makeAvatar($name)
    {

        $fontSize = $this->textSize;
        $fontColor = $this->textColor;
        $initials = $this->getInitials(mb_convert_encoding($name, "LATIN1", "UTF-8"));
        $backgroundColor = $this->getRandomColor();

        $image = $this->getShape()->getShapedImage($this->size, $backgroundColor);


        $textX = ($this->size / 2) - ($this->size * .01); // Workaround to fix non-centered text

        $image->text($initials, $textX, $this->size / 2, function (\Intervention\Image\AbstractFont $font) use ($fontSize, $fontColor) {
            $font->file('arial.ttf'); /* @todo let the developer choose font */
            $font->size($fontSize);
            $font->color($fontColor);
            $font->align('center');
            $font->valign('middle');
            $font->angle(0);
        });

        $this->image = $image;

        return $this;
    }

    /**
     * @return string
     */
    public function toBase64()
    {
        if (!$this->image) {
            throw new \LogicException(sprintf('You must call %s::makeAvatar() first!', __CLASS__));
        }

        return $this->image->encode('data-url', 100)->encoded;

    }


    /**
     * @param string $path
     * @param null   $quality
     *
     * @return $this
     */
    public function save($path, $quality = null)
    {
        if (!$this->image) {
            throw new \LogicException(sprintf('You must call %s::makeAvatar() first!', __CLASS__));
        }

        $this->image->save($path, $quality);

        return $this;
    }

    /**
     * @param string $backgroundLuminosity
     */
    public function setBackgroundLuminosity($backgroundLuminosity)
    {

        if (!in_array($backgroundLuminosity, ['dark', 'bright', 'light'])) {
            throw new \InvalidArgumentException(sprintf('Unknown luminosity key: %s', $backgroundLuminosity));
        }

        $this->backgroundLuminosity = $backgroundLuminosity;
    }

    /**
     * @param array $hues
     *
     * @return $this
     */
    public function setHues(array $hues)
    {

        $this->hues = [];
        foreach ($hues as $hue) {
            $this->addHue($hue);
        }

        return $this;

    }

    /**
     * @return array
     */
    public function getHues()
    {
        return $this->hues;
    }

    /**
     * @param string $hue
     *
     * @return $this
     */
    public function addHue($hue)
    {

        if (!in_array($hue, array_keys(RandomColor::$dictionary))) {
            throw new \InvalidArgumentException(sprintf('Unknown hue "%s"!', $hue));
        }

        $this->hues[] = $hue;

        return $this;
    }

    /**
     * @param int $charLength
     */
    public function setCharLength($charLength)
    {
        $this->charLength = $charLength;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
        $this->textSize = $size / 2;
    }

    /**
     * @return ShapeInterface
     */
    public function getShape()
    {
        return $this->shape;
    }

    /**
     * @return \Intervention\Image\Image|null
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getTextColor()
    {
        return $this->textColor;
    }

    /**
     * @param string $textColor
     */
    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;
    }

    /**
     * @return int
     */
    public function getTextSize()
    {
        return $this->textSize;
    }

    /**
     * @param int $textSize
     */
    public function setTextSize($textSize)
    {
        $this->textSize = $textSize;
    }
}