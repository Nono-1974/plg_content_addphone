<?php
defined('_JEXEC') or die;

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Factory;

class PlgContentAddPhone extends CMSPlugin
{
    public function onContentPrepareForm(Form $form, $data)
    {
        $app = Factory::getApplication();

        // On ne cible que le formulaire contact site
        if ($app->isClient('site') && $form->getName() === 'com_contact.contact')
        {
            // Ajouter le path vers le fichier XML dans ce plugin
            JForm::addFormPath(__DIR__ . '/forms');

            // Charger le fichier contact.xml (custom) sans remplacer
            $form->loadFile('contact', false);
        }

        return true;
    }
}
?>
