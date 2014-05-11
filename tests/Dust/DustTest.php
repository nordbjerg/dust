<?php
class DustTest extends PHPUnit_Framework_TestCase
{

	private $dust;

	public function setUp()
	{
		$this->dust = new Dust\Dust;
		$this->dust->register('/^get(\w+)$/', 'get');
	}

	public function testRegister()
	{
		$this->assertEquals(1, count($this->dust->getAllPaths()));
		$this->assertEquals(['/^get(\w+)$/' => 'get'], $this->dust->getAllPaths());
	}

	public function testGetMethod()
	{
		$this->assertEquals('get', $this->dust->getMethod('getCookies'));
	}

	public function testGetPattern()
	{
		$this->assertEquals('/^get(\w+)$/', $this->dust->getPattern('getCookies'));
	}

	public function testGetArguments()
	{
		$this->assertEquals(['cookies'], $this->dust->getArguments('getCookies'));
	}

	public function testHandle()
	{
		$this->assertEquals('getting cookies from jar', $this->dust->handle(new Dummy, 'getCookies', ['jar']));
	}

}

class Dummy
{
	public function get($name, $container)
	{
		return "getting {$name} from {$container}";
	}
}
