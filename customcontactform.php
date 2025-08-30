<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;

class PlgSystemCustomcontactform extends CMSPlugin
{
    public function onContentPrepareForm(Form $form, $data)
    {
        Log::addLogger(
            ['text_file' => 'plg_system_customcontactform.log.php'],
            Log::ALL,
            ['plg_system_customcontactform']
        );
        
        // Ne cibler que le formulaire de contact de base
        if ($form->getName() !== 'com_contact.contact') {
            Log::add('Formulaire ignoré : ' . $form->getName(), Log::DEBUG, 'plg_system_customcontactform');
            return;
        }

        Log::add('Modification du formulaire com_contact.contact', Log::INFO, 'plg_system_customcontactform');
        
        JForm::addFormPath(__DIR__ . '/forms');
        $form->loadFile('contact', false);

        Log::add('Champ Xml injecté dans com_contact.contact', Log::INFO, 'plg_system_customcontactform');
        
        // Réorganiser les champs si nécessaire (contact_name, contact_telephone, contact_email)
        $this->reorderFields($form);

        Log::add('Reordonancement du formulaire com_contact.contact terminé', Log::INFO, 'plg_system_customcontactform');
    }

    private function reorderFields(Form $form)
    {
        $fields = $form->getFieldset();
        if (!isset($fields['contact_telephone']) || !isset($fields['contact_name']) || !isset($fields['contact_email'])) {
            Log::add('Certains champs manquent, réorganisation annulée', Log::WARNING, 'plg_system_customcontactform');
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

        Log::add('Champs réorganisés : ' . implode(', ', array_keys($reordered)), Log::DEBUG, 'plg_system_customcontactform');
    }
}
?>
