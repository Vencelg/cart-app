<?php

namespace CartApp\User\Mapper;

/**
 * UserMapper
 */
class UserMapper extends \CartApp\Core\Mapper\AbstractMapper
{
	use \CartApp\Core\Mapper\CudLogMapperTrait;

	/** @var bool $includeApiKey */
	protected bool $includeApiKey = false;

	/**
	 * @inheritDoc
	 * @param \CartApp\User\Model\User $source
	 */
	public function map($source, int $depth = 0): array
	{
		$output = [];

		$output['id'] = $source->getId();
		$output['name'] = $source->getName();
		$output['surname'] = $source->getSurname();
		$output['email'] = $source->getEmail();

		if ($this->includeApiKey) {
			$output['apiKey'] = $source->getApiKey();
		}

		// Prevent from infinite looping
		if ($depth <= $this->maxDepth) {
			$output = array_merge($output, $this->mapCudLog($source, ++$depth));
		}

		return $output;
	}

	/**
	 * @param bool $includeApiKey
	 * @return self
	 */
	public function setIncludeApiKey(bool $includeApiKey): self
	{
		$this->includeApiKey = $includeApiKey;
		return $this;
	}
}