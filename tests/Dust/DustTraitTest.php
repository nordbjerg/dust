<?php
class DustTraitTest extends PHPUnit_Framework_TestCase
{
    use DustTrait;

    public function testDustInstanceIsInstanceOfDust()
    {
        $this->assertInstanceOf('Dust/Dust', $this->getDustInstance());
    }

    public function testSetDustInstance()
    {
        $d = new Dust\Dust;
        $this->setDustInstance($d);

        $this->assertEquals($d, $this->getDustInstance());
    }

    public function testCallsUnknownMethod()
    {
        $this->getDustInstance()->register('/^get(\w+)$/', 'get');
        $this->assertEquals('getting cookies from jar', $this->getCookies('jar'));
    }

    public function get($what, $container)
    {
        return "getting {$what} from {$container}";
    }

}
