<?php

namespace CartApp\Core\Model;

/**
 * IdTrait
 */
trait IdTrait
{
	/** @var int $id */
	protected $id;


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}
}