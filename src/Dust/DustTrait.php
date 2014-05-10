<?php namespace Dust;

trait DustTrait {

	/**
	 * Instance of Dust.
	 *
	 * @var Dust
	 */
	protected $dust;

	/**
	 * Get the instance of Dust.
	 *
	 * @return Dust
	 */
	public function getDustInstance()
	{
		if(!$this->dust instanceof Dust) {
			$this->dust = new Dust;
		}

		return $this->dust;
	}

	/**
	 * Set the Dust instance.
	 *
	 * @param Dust $dust
	 * @return void
	 */
	public function setDustInstance(Dust $dust)
	{
		$this->dust = $dust;
	}

	/**
	 * Handle calls to magic methods.
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($method, array $arguments)
	{
		return $this->getDustInstance()->handle($this, $method, $arguments);
	}

}