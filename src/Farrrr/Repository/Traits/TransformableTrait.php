<?php
namespace Farrrr\Repository\Traits;

/**
 * Class TransformableTrait
 * @package Farrrr\Repository\Traits
 */
trait TransformableTrait
{
    /**
     * @return array
     */
    public function transform()
    {
        return $this->toArray();
    }
}
