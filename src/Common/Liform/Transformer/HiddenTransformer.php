<?php

namespace App\Common\Liform\Transformer;

use Limenius\Liform\Transformer\AbstractTransformer;
use Symfony\Component\Form\FormInterface;

class HiddenTransformer extends AbstractTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $schema = ['type' => 'hidden'];
        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);

        return $schema;
    }
}