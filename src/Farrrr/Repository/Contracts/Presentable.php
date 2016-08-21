<?php
namespace Farrrr\Repository\Contracts;

/**
 * Interface Presentable
 * @package Farrrr\Repository\Contracts
 */
interface Presentable
{
    /**
     * @param PresenterInterface $presenter
     *
     * @return mixed
     */
    public function setPresenter(PresenterInterface $presenter);

    /**
     * @return mixed
     */
    public function presenter();
}