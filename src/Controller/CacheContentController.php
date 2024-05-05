<?php

/**
 * @file
 * Contains \Drupal\cache_content\Controller\CacheContentController.
 */

namespace Drupal\cache_content\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * @todo: add documentation.
 */
class CacheContentController extends ControllerBase {

  /**
   * @todo: add documentation.
   *
   * @return void
   */
  public function first_block(): array {
    return [
      '#title' => 'First Block title',
      '#markup' => 'First Block',
    ];
  }

}

