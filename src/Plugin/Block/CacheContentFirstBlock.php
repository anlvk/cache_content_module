<?php

namespace Drupal\cache_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block to display text depending on odd/even minute.
 *
 * @Block(
 *   id = "cache_content_first_block",
 *   admin_label = @Translation("Cache content: first block"),
 * )
 */
class CacheContentFirstBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Odd/even minute service.
   *
   * @var \Drupal\cache_content\EvenMinuteChecker
   */
  protected $minuteChecker;

  /**
   * Instantiates a new instance of this class.
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): object {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->minuteChecker = $container->get('cache_content.odd_even_minute_check');

    return $instance;
  }

  /**
   * Builds the content block.
   *
   * @return array
   *   A render array.
   */
  public function build(): array {
    $isEvenMinute = $this->minuteChecker->isCurrentMinuteEven();

    // Retrieve block configuration.
    $config = $this->getConfiguration();

    // Display content based on a minute when a block is loaded.
    // Random number is needed to demonstrate that cache context works.
    $randomNumber = rand(1, 100);
    $message = ($isEvenMinute === TRUE) ? $config['even_text'] : $config['odd_text'];
    $message = "$message $randomNumber";

    // The block is rendered with custom twig template.
    return [
      '#theme' => 'block--first-block',
      '#block_text' => $message,
    ];
  }

  /**
   * Form constructor.
   *
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state): array {
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
   * Form submission handler.
   *
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // Save custom settings when the form is submitted.
    $this->setConfigurationValue('even_text', $form_state->getValue('even_text'));
    $this->setConfigurationValue('odd_text', $form_state->getValue('odd_text'));
  }

  /**
   * The cache contexts.
   */
  public function getCacheContexts(): array {
    return Cache::mergeContexts(
        parent::getCacheContexts(),
        ['odd_even_minute']
    );
  }

}
