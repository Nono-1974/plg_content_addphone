<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Factory;
use Joomla\CMS\Log\Log;
use Joomla\CMS\Form\Form as JForm;

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
            return;
        }

        Log::add('Modification du formulaire com_contact.contact', Log::INFO, 'plg_system_customcontactform');
        
        JForm::addFormPath(__DIR__ . '/forms');
        $form->loadFile('contact', false);
		
		Log::add('Champs additionnels du formulaire chargés com_contact.contact', Log::INFO, 'plg_system_customcontactform');

    }
}
?>
