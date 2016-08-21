<?php
namespace Farrrr\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 * @package Farrrr\Repository\Events
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'deleted';
}