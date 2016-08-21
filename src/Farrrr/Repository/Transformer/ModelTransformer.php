<?php
namespace Farrrr\Repository\Transformer;

use Farrrr\Repository\Contracts\Transformable;
use League\Fractal\TransformerAbstract;

/**
 * Class ModelTransformer
 * @package Farrrr\Repository\Transformer
 */
class ModelTransformer extends TransformerAbstract
{
    public function transform(Transformable $model)
    {
        return $model->transform();
    }
}