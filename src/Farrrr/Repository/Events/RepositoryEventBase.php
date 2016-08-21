<?php
namespace Farrrr\Repository\Events;

use Farrrr\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RepositoryEventBase
 * @package Farrrr\Repository\Events
 */
abstract class RepositoryEventBase
{
    /**
     * @var RepositoryInterface
     */
    protected $repository;
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var string
     */
    protected $action;

    /**
     * RepositoryEventBase constructor.
     *
     * @param RepositoryInterface $repository
     * @param Model               $model
     */
    public function __construct(RepositoryInterface $repository, Model $model)
    {
        $this->repository = $repository;
        $this->model = $model;
    }

    /**
     * @return Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }
}