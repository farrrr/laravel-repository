<?php
namespace Farrrr\Repository\Presenter;

use Farrrr\Repository\Transformer\ModelTransformer;
use League\Fractal\TransformerAbstract;

/**
 * Class ModelFractalPresenter
 * @package Farrrr\Repository\Presenter
 */
class ModelFractalPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return new ModelTransformer();
    }
}