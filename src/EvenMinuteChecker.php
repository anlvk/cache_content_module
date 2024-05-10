<?php

/**
 * @file
 * Contains \Drupal\cache_content\EvenMinuteChecker.
 */

namespace Drupal\cache_content;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class EvenMinuteChecker.
 */
class EvenMinuteChecker {
  /**
   * Class constructor.
   *
   * @param TimeInterface $timeService
   * @param DateFormatterInterface $dateFormatter
   */
  public function __construct(
    protected TimeInterface $timeService,
    protected DateFormatterInterface $dateFormatter
  ) {
    $this->timeService = $timeService;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * Retrieves a current minute (by custom format).
   *
   * @return boolean
   */
  public function isCurrentMinuteEven(): bool {
    // Retrieve current timestamp.
    $currentTime = $this->timeService->getCurrentTime();
    // Retrieve custom format: minute - from current timestamp.
    $minute = $this->dateFormatter->format($currentTime, 'custom', 'i');
    // True - even, false - odd.
    return intval($minute) % 2 === 0 ? true : false ;
  }
}

