<?php namespace Dust;

class Dust {

	/**
	 * The pattern-to-method paths.
	 *
	 * @var array
	 */
	protected $paths = [];

	/**
	 * Register $pattern to refer to $method.
	 *
	 * Any method call matching $pattern will execute $method with the given variables.
	 *
	 * @param string $pattern
	 * @param string $method 
	 * @return void
	 */
	public function register($pattern, $method)
	{
		$this->paths[$pattern] = $method;
	}

	/**
	 * Get all registered pattern-to-method paths.
	 *
	 * @return array
	 */
	public function getAllPaths()
	{
		return $this->paths;
	}

	/**
	 * Get the appropriate method for magic method $name.
	 *
	 * @throws BadMethodCallException
	 * @param string $name
	 * @return string
	 */
	public function getMethod($name)
	{
		foreach($this->paths as $pattern => $method)
		{
			if(preg_match_all($pattern, $name))
			{
				return $method;
			}
		}

		throw new BadMethodCallException("Method {$name} not found.");
	}

	/**
	 * Get the appropriate pattern for the magic method $name.
	 *
	 * @throws BadMethodCallException
	 * @param string $name
	 * @return string
	 */
	public function getPattern($name)
	{
		foreach($this->paths as $pattern => $method)
		{
			if(preg_match_all($pattern, $name))
			{
				return $pattern;
			}
		}

		throw new BadMethodCallException("Method {$name} not found.");
	}

	/**
	 * Extract the arguments required by the given method's pattern.
	 *
	 * @param string $method
	 * @return array
	 */
	public function getArguments($method)
	{
		$pattern = $this->getPattern($method);
		$arguments = [];

		preg_match_all($pattern, $method, $arguments);

		return array_map('strtolower', $arguments[1]);
	}

	/**
	 * Handle method call.
	 *
	 * @param mixed $object The object to find the actual method in
	 * @param string $method The magic method name
	 * @param array $arguments The magic method's passed arguments
	 * @return mixed
	 */
	public function handle($object, $method, array $arguments = [])
	{
		$arguments = array_merge($this->getArguments($method), $arguments);
		$method = $this->getMethod($method);

		return call_user_func_array([$object, $method], $arguments);
	}

}