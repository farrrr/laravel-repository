<?php
namespace Farrrr\Repository\Contracts;

/**
 * Interface CriteriaInterface
 * @package Farrrr\Repository\Contracts
 */
interface CriteriaInterface
{
    /**
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}