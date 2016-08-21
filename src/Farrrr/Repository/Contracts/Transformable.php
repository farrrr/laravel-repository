<?php
namespace Farrrr\Repository\Contracts;

/**
 * Interface Transformable
 * @package Farrrr\Repository\Contracts
 */
interface Transformable
{
    /**
     * @return array
     */
    public function transform();
}