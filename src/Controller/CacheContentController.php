<?php

/**
 * @file
 * Contains \Drupal\cache_content\Controller\CacheContentController.
 */

namespace Drupal\cache_content\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Undocumented class
 */
class CacheContentController extends ControllerBase {

  /**
   * Undocumented function
   *
   * @return void
   */
  public function first_block(): array {
    $output = [
      '#title' => 'First Block title',
      '#markup' => 'First Block',
    ];

    return $output;
  }

}

