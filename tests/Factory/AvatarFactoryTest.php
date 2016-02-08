<?php

namespace Shift\AvatarMaker\Test\Factory;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Shift\AvatarMaker\AvatarMaker;
use Shift\AvatarMaker\Factory\AvatarFactory;

class AvatarFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testCanInstantiateAvatarMaker()
    {
        $am = AvatarFactory::createAvatarMaker();
        $this->assertEquals(true, $am instanceof AvatarMaker);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCannotInstantiateAvatarMakerWithInvalidShape()
    {
        AvatarFactory::createAvatarMaker('bogus');
    }
}
