<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Factory;

class PlgSystemCustomcontactform extends CMSPlugin
{
    public function onContentPrepareForm(Form $form, $data)
    {
        // Ne cibler que le formulaire de contact de base
        if ($form->getName() !== 'com_contact.contact') {
            return;
        }

        JForm::addFormPath(__DIR__ . '/forms');
        $form->loadFile('contact', false);

        // Réorganiser les champs si nécessaire (contact_name, contact_telephone, contact_email)
        $this->reorderFields($form);
    }

    private function reorderFields(Form $form)
    {
        $fields = $form->getFieldset();
        if (!isset($fields['contact_telephone']) || !isset($fields['contact_name']) || !isset($fields['contact_email'])) {
            return;
        }

        // Forcer l’ordre en recréant le fieldset (optionnel, utile surtout en override)
        $fieldset = $form->getFieldset();
        $newOrder = ['contact_name', 'contact_telephone', 'contact_email'];

        $reordered = [];
        foreach ($newOrder as $name) {
            if (isset($fieldset[$name])) {
                $reordered[$name] = $fieldset[$name];
            }
        }

        // Supprimer les autres pour ne pas interférer (facultatif)
        $form->setFieldset('', $reordered);
    }
}
?>
