<?php

namespace App\Common\Liform\Extension;

use Limenius\Liform\Transformer\ExtensionInterface;
use Symfony\Component\Form\FormInterface;

class FormExtension implements ExtensionInterface
{
    /**
     * @param FormInterface $form
     * @param array $schema
     *
     * @return array
     */
    public function apply(FormInterface $form, array $schema)
    {
        if ($form->isRoot()) {
            if ($form->getConfig()->hasOption('action')) {
                $schema['submit_url']    = $form->getConfig()->getOption('action');
                $schema['submit_method'] = $form->getConfig()->getOption('method');
            }
        } else {

            // Liform does not handle translation_domain option for form labels correctly.
            // Setting the translation domain to false on a compound form, should disable the translation of
            // all field labels that don't have a translation_domain defined, which is not the case.
            // As this application requires none of the labels to be translated, the following statement simply
            // overwrites the translated title attribute with the un-translated form field label.
            $schema['title'] = $form->getConfig()->getOption('label');

            // copy 'icon' and 'help' options into the schema
            foreach (['icon', 'help'] as $option) {
                if ($form->getConfig()->hasOption($option)) {
                    $schema[$option] = $form->getConfig()->getOption($option);
                }
            }
        }

        return $schema;
    }
}