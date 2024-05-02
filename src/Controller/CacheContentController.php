<?php

/**
 * @file
 * Contains \Drupal\cache_content\Controller\CacheContentController.
 */

namespace Drupal\cache_content\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Объявляем наш класс-контроллер.
 */
class CacheContentController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function first_block() {
    $output = [
      '#title' => 'First Block title',
      '#markup' => 'First Block',
    ];

    return $output;
  }

}

