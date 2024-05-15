<?php

namespace Drupal\cache_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block to display text from module configuration settings.
 *
 * @Block(
 *   id = "cache_content_third_block",
 *   admin_label = @Translation("Cache content: third block"),
 * )
 */
class CacheContentThirdBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Odd/even minute service.
   */
  protected $minuteChecker;

  /**
   * Entity type manager service.
   */
  protected $entityTypeManager;

  /**
   * Node storage.
   */
  protected $nodeStorage;

  /**
   * Node ID.
   */
  protected $nodeID;

  /**
   * Instantiates a new instance of this class.
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): object {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->minuteChecker = $container->get('cache_content.odd_even_minute_check');
    $instance->entityTypeManager = $container->get('entity_type.manager');
    $instance->nodeStorage = $instance->entityTypeManager->getStorage('node');

    return $instance;
  }

  /**
   * Builds the content block.
   *
   * @return array
   *   A render array.
   */
  public function build(): array {
    // Check odd/even minute.
    $isEvenMinute = $this->minuteChecker->isCurrentMinuteEven();
    $this->nodeID = ($isEvenMinute === TRUE) ? 5 : 6;

    // Retrieve the node from entity storage.
    $node = $this->nodeStorage->load($this->nodeID);

    if (empty($node)) {
      return [];
    }

    $viewMode = 'teaser';
    $viewBuilder = $this->entityTypeManager->getViewBuilder('node');

    // Display content based on a minute when a block is loaded.
    $nodeView = $viewBuilder->view($node, $viewMode);

    // The block is rendered with custom twig template.
    return [
      '#theme' => 'block--third-block',
      '#node' => $nodeView,
    ];

  }

  /**
   * The cache contexts. Merged with custom cache context.
   */
  public function getCacheContexts(): array {
    return Cache::mergeContexts(
        parent::getCacheContexts(),
        ['odd_even_minute']
    );
  }

  /**
   * The cache tags. Merged with node tags.
   */
  public function getCacheTags() {
    return Cache::mergeTags(
      parent::getCacheTags(),
      ['node:' . $this->nodeID]
    );
  }

}
