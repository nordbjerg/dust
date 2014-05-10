<?php
class DustTest extends PHPUnit_Framework_TestCase
{

	public function testRegister()
	{
		$dust = new Dust();

		$dust->register('/^get(\w+)$/', 'get');

		$this->assertEquals(1, count($dust->getAllPaths()));
		$this->assertEquals(['/^get(\w+)$/' => 'get'], $dust->getAllPaths());
	}

	public function testGetMethod()
	{
		$dust = new Dust();

		$dust->register('/^get(\w+)$/', 'get');

		$this->assertEquals('get', $dust->getMethod('getCookies'));
	}

	public function testGetPattern()
	{
		$dust = new Dust();

		$dust->register('/^get(\w+)$/', 'get');

		$this->assertEquals('/^get(\w+)$/', $dust->getPattern('getCookies'));
	}

	public function testGetArguments()
	{
		$dust = new Dust();

		$dust->register('/^get(\w+)$/', 'get');

		$this->assertEquals(['cookies'], $dust->getArguments('getCookies'));
	}

	public function testHandle()
	{
		$dust = new Dust();

		$dust->register('/^get(\w+)$/', 'get');

		$this->assertEquals('getting cookies from jar', $dust->handle(new Dummy, 'getCookies', ['jar']));
	}

}

class Dummy
{
	public function get($name, $container)
	{
		return "getting {$name} from {$container}";
	}
}