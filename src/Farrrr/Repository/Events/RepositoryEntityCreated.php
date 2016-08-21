<?php
namespace Farrrr\Repository\Events;

/**
 * Class RepositoryEntityCreated
 * @package Farrrr\Repository\Events
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'created';
}