<?php

namespace Drupal\cache_content\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a block with a simple text.
 *
 * @Block(
 *   id = "cache_content_first_block",
 *   admin_label = @Translation("Cache content: first block"),
 * )
 */
class CacheContentFirstBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $isEvenMinute = \Drupal::service('cache_content.even_minute_check')->isEven();

    $config = $this->getConfiguration();

    if ($isEvenMinute === true) {
      $message = $config['even_text'];
    } else {
      $message = $config['odd_text'];
    }

    $block = [
      '#type' => 'markup',
      '#markup' => $message,
    ];
  
    return $block;
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    // Retrieve existing configuration for this block.
    $config = $this->getConfiguration();

    // Add form fields to the existing block configuration form.
    $form['even_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Even text'),
      '#default_value' => isset($config['even_text']) ? $config['even_text'] : '',
    ];

    $form['odd_text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Odd text'),
      '#default_value' => isset($config['odd_text']) ? $config['odd_text'] : '',
    ];
    
    return $form;
  }

   /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save our custom settings when the form is submitted.
    $this->setConfigurationValue('even_text', $form_state->getValue('even_text'));
    $this->setConfigurationValue('odd_text', $form_state->getValue('odd_text'));
    //$this->configuration['even_text'] = $form_state->getValue('even_text');
    //$this->configuration['odd_text'] = $form_state->getValue('odd_text');
  }

}
