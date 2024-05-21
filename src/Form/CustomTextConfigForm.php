<?php

namespace Drupal\cache_content\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures module settings.
 *
 * @see \Drupal\Core\Form\ConfigFormBase
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
   * Returns the name of the config file. The values ​​will be 
   * stored in: cache_content.settings.yml.
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
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('cache_content.settings');
    $form['config_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Custom config text'),
      '#default_value' => $config->get('config_text'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * Form submission handler.
   *
   * {@inheritdoc}
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
