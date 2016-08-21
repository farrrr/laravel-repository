<?php
namespace Farrrr\Repository\Contracts;

/**
 * Interface PresenterInterface
 * @package Farrrr\Repository\Contracts
 */
interface PresenterInterface
{
    /**
     * Prepare data to present
     *
     * @param $data
     *
     * @return mixed
     */
    public function present($data);
}