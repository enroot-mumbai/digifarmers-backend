<?php

namespace App\Common\Liform\Transformer;

use Limenius\Liform\Transformer\AbstractTransformer;
use Symfony\Component\Form\FormInterface;

class FileTransformer extends AbstractTransformer
{
    /**
     * {@inheritdoc}
     */
    public function transform(FormInterface $form, array $extensions = [], $widget = null)
    {
        $schema = ['type' => 'file'];
        $schema = $this->addCommonSpecs($form, $schema, $extensions, $widget);

        return $schema;
    }

    /**
     * @param FormInterface $form
     * @param array         $schema
     *
     * @return array
     */
    protected function addMaxLength(FormInterface $form, array $schema)
    {
        if ($attr = $form->getConfig()->getOption('attr')) {
            if (isset($attr['maxlength'])) {
                $schema['maxLength'] = $attr['maxlength'];
            }
        }

        return $schema;
    }
}