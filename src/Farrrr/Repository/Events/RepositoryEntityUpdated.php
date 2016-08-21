<?php
namespace Farrrr\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 * @package Farrrr\Repository\Events
 */
class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'updated';
}