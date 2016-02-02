<?php
namespace Shift\AvatarMaker;

use Colors\RandomColor;
use Intervention\Image\AbstractFont;
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
     * @var string
     */
    protected $separator;

    /**
     * @var string
     */
    protected $fontFile;

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
     * @param string         $separator
     */
    public function __construct(ShapeInterface $shape, $separator = "\s,.@")
    {

        if (!class_exists('Colors\RandomColor')) {
            throw new \RuntimeException('RandomColor class is required!');
        }

        $this->shape = $shape;
        $this->separator = $separator;
    }

    /**
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * @param string $separator
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
    }

    /**
     * @param string $fontFile
     */
    public function setFontFile($fontFile)
    {
        $this->fontFile = $fontFile;
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

        $pattern = sprintf("/[%s]+/", $this->getSeparator());
        $chars = preg_replace("/[0-9,\",']/", "", $string);
        if ((empty($chars)) || (1 !== preg_match('/[A-z]/', $chars))) {
            // Whoops, we stripped to much. Let the numbers in!
            $chars = $string;
        }


        $words = preg_split($pattern, mb_strtoupper($chars), -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

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

        if (!is_string($name)) {
            throw new \InvalidArgumentException(sprintf("Expected string, given: %s!", gettype($name)));
        }

        $fontFile = !empty($this->fontFile) ? $this->fontFile : 'arial.ttf';
        $fontColor = $this->textColor;
        $initials = $this->getInitials(mb_convert_encoding($name, "LATIN1", "UTF-8"));
        $image = $this->getShape()->getShapedImage($this->getRandomColor());
        $shape = $this->getShape();

        list($textX, $textY) = $this->getShape()->getTextPosition();

        $image->text($initials, $textX, $textY, function (AbstractFont $font) use ($fontColor, $fontFile, $shape) {
            $font->file($fontFile);
            $font->size($shape->getTextSize());
            $font->color($fontColor);
            $font->align('center');
            $font->valign('middle');
            $font->angle($shape->getTextAngle());
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