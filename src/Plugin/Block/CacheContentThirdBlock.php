<?php

/**
 * @file
 * Contains \Drupal\cache_content\Plugin\Block\CacheContentThirdBlock.
 */

namespace Drupal\cache_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a block which displays different nodes based on a loading time (if minute is even or odd).
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
   * Instantiates a new instance of this class.
   *
   * @param ContainerInterface $container
   * @param array $configuration
   * @param [type] $plugin_id
   * @param [type] $plugin_definition
   * @return object
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

    // Retrieve nodes from entity storage.
    $nodes = $this->nodeStorage->loadMultiple([5, 5]);

    $viewMode = 'teaser';
    $viewBuilder = $this->entityTypeManager->getViewBuilder('node');

    if (empty($nodes)) {
      return [];
    }

    // Display content based on a minute when a block is loaded.
    $node = ($isEvenMinute === true) ? $nodes[5] : $nodes[6];

    return $viewBuilder->view($node, $viewMode);
  }

  /**
   * The cache contexts.
   *
   * @return array
   */
  public function getCacheContexts(): array {
    return Cache::mergeContexts(
        parent::getCacheContexts(),
        ['odd_even_minute']
    );
  }

  /**
   * The cache tags.
   *
   * @return array
   */
  public function getCacheTags(): array {
    return parent::getCacheTags();
  }

}

