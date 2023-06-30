<?php

namespace App\Controller\Trait;

trait PaginationTrait
{
	public static function getLastPage(int $count, int $itemPerPage): int
	{
		return $count / $itemPerPage < 1 ? 1 : ceil($count / $itemPerPage);
	}
}