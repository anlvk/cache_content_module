<?php

/**
 * @file
 * Contains \Drupal\cache_content\Plugin\Block\CacheContentSecondBlock.
 */

namespace Drupal\cache_content\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block which displays data from cache_content confiuration settings.
 *
 * @Block(
 *   id = "cache_content_second_block",
 *   admin_label = @Translation("Cache content: second block"),
 * )
 */
class CacheContentSecondBlock extends BlockBase implements ContainerFactoryPluginInterface {
    /**
     * Defines the interface for a configuration object factory.
     * 
     * @var $configFactory \Drupal\Core\Config\ConfigFactoryInterface
     */
    protected $configFactory;

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
        $instance->configFactory = $container->get('config.factory');

        return $instance;
    }

  /**
   * Builds the content block.
   *
   * @return array
   *   A render array.
   */
  public function build(): array {
    $config_factory = $this->configFactory->get('cache_content.settings');

    // Display content based on a minute when a block is loaded.
    $message = $config_factory->get('config_text');

    return [
      '#type' => 'markup',
      '#markup' => $message,
    ];
  }

}
