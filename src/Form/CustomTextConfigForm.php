<?php

/**
 * @file
 * Contains \Drupal\cache_content\Form\CustomTextConfigForm.
 */

 namespace Drupal\cache_content\Form;

 use Drupal\Core\Form\ConfigFormBase;
 use Drupal\Core\Form\FormStateInterface;
 
 /**
  * Defines a form that configures module settings.
  */
 class CustomTextConfigForm extends ConfigFormBase {
 
   /**
    * Returns form id.
    *
    * {@inheritdoc}
    */
   public function getFormId() {
     return 'cache_content_settings';
   }
 
   /**
    * Returns the name of the config file.
    * Values will be stored in this file: cache_content.settings.yml.
    *
    * {@inheritdoc}
    */
   protected function getEditableConfigNames() {
     return [
       'cache_content.settings',
     ];
   }

    /**
     * Form constructor.
     *
     * @param array $form
     * @param FormStateInterface $form_state
     * @return void
     */
   public function buildForm(array $form, FormStateInterface $form_state): array {
     $config = $this->config('cache_content.settings');
     $form['config_text'] = array(
       '#type' => 'textfield',
       '#title' => $this->t('Custom config text'),
       '#default_value' => $config->get('config_text'),
     );
     return parent::buildForm($form, $form_state);
   }

    /**
     * Form submission handler.
     *
     * @param array $form
     * @param FormStateInterface $form_state
     * @return void
     */
   public function submitForm(array &$form, FormStateInterface $form_state) {
     $values = $form_state->getValues();
     $this->config('cache_content.settings')
       ->set('config_text', $values['config_text'])
       ->save();

    $this->messenger()->addMessage($this->t('The form has been submitted. Config text: "@config_text"', [
      '@config_text' => $values['config_text'],
    ]));
   }
 }