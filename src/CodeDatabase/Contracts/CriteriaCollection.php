<?php

namespace CodePress\CodeDatabase\Contracts;

use CodePress\CodeDatabase\Contracts\CriteriaInterface;

interface CriteriaCollection
{
	
	public function addCriteria(CriteriaInterface $criteria);

	public function getCriteriaCollection();

	public function getByCriteria(CriteriaInterface $criteria);

	public function applyCriteria();

	public function ignoreCriteria($isIgnore = true);

	public function clearCriteria();
}