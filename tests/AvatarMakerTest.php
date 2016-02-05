<?php

namespace Shift\AvatarMaker\Test;

use LogicException;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Shift\AvatarMaker\Factory\AvatarFactory;

class AvatarMakerTest extends PHPUnit_Framework_TestCase
{
    public function testCanSetCharLength()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->setCharLength(42);
    }

    public function testCanSetBackgroundLuminosity()
    {
        $am = AvatarFactory::createAvatarMaker();

        foreach (array('dark', 'bright', 'light') as $luminosity) {
            $am->setBackgroundLuminosity($luminosity);
        }
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCannotSetInvalidBackgroundLuminosity()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->setBackgroundLuminosity('bogus');
    }

    public function testCanSetAndGetSeparators()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->setSeparator('.');
        $this->assertEquals('.', $am->getSeparator());
    }

    public function testCanSetAndGetTextColor()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->setTextColor('red');
        $this->assertEquals('red', $am->getTextColor());
    }

    public function testCanSetFontFile()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->setFontFile(__DIR__ . '/../demo/arial.ttf');
    }

    public function testCanSetAndGetHues()
    {
        $am = AvatarFactory::createAvatarMaker();

        $am->setHues(array('red', 'yellow'));
        $this->assertEquals(array('red', 'yellow'), $am->getHues());

        $am->addHue('blue');
        $this->assertEquals(array('red', 'yellow', 'blue'), $am->getHues());

        $am->setHues(array());
        $this->assertEquals(array(), $am->getHues());

        $am->addHue('green');
        $this->assertEquals(array('green'), $am->getHues());

        $am->addHue('green');
        $this->assertEquals(array('green', 'green'), $am->getHues());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCannotSetInvalidHues()
    {
        $am = AvatarFactory::createAvatarMaker();

        $am->setHues(array('bogus'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCannotAddInvalidHues()
    {
        $am = AvatarFactory::createAvatarMaker();

        $am->addHue('bogus');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCannotCallMakeAvatarWithWrongType()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->makeAvatar(42);
    }

    public function testCanGetShape()
    {
        $am = AvatarFactory::createAvatarMaker();
        $this->assertEquals(true, $am->getShape() instanceof \Shift\AvatarMaker\Shape\ShapeInterface);
    }

    public function testCanGetImage()
    {
        $am = AvatarFactory::createAvatarMaker();
        $this->assertEquals(null, $am->getImage());

        /** @todo This line shouldn't be needed */
        $am->setFontFile(__DIR__ . '/../demo/arial.ttf');

        $am->makeAvatar('Bob Smith');
        $this->assertEquals(true, $am->getImage() instanceof \Intervention\Image\Image);
    }

    public function testCanExportToBase64()
    {
        $am = AvatarFactory::createAvatarMaker('circle', 16);

        /** @todo This line shouldn't be needed */
        $am->setFontFile(__DIR__ . '/../demo/arial.ttf');

        $base64 = $am->makeAvatar('Bob Smith')->toBase64();

        $this->assertEquals('data:image/png;base64,', substr($base64, 0, 22));
        $res = imagecreatefromstring(base64_decode(substr($base64, 22)));
        $this->assertEquals(16, imagesx($res));
        $this->assertEquals(16, imagesy($res));
    }

    /**
     * @expectedException LogicException
     */
    public function testCannotCallBase64InWrongOrder()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->toBase64();
    }

    /**
     * @expectedException LogicException
     */
    public function testCannotCallSaveInWrongOrder()
    {
        $am = AvatarFactory::createAvatarMaker();
        $am->save('');
    }

    public function testCanInstantiateAndRenderBundledShapes()
    {
        $shapes = array('circle', 'column', 'diamond', 'random', 'rectangle', 'rhomb');

        foreach ($shapes as $shape) {
            $am = AvatarFactory::createAvatarMaker($shape, 16);
            $this->assertEquals(true, $am instanceof \Shift\AvatarMaker\AvatarMaker);

            /** @todo This line shouldn't be needed */
            $am->setFontFile(__DIR__ . '/../demo/arial.ttf');

            $base64 = $am->makeAvatar('Bob Smith')->toBase64();

            $this->assertEquals('data:image/png;base64,', substr($base64, 0, 22));
            $res = imagecreatefromstring(base64_decode(substr($base64, 22)));
            $this->assertEquals(16, imagesx($res));
            $this->assertEquals(16, imagesy($res));
        }
    }
}
