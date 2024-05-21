<?php

namespace Drupal\cache_content;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class EvenMinuteChecker.
 *
 * Provides a service to detect if current minute is odd or even.
 */
class EvenMinuteChecker {
  /**
   * Class constructor.
   *
   * @param \Drupal\Component\Datetime\TimeInterface $timeService
   *   Service to retrieve current time.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   Service to format time according to pattern.
   */
  public function __construct(
    protected TimeInterface $timeService,
    protected DateFormatterInterface $dateFormatter,
  ) {
    $this->timeService = $timeService;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * Determines the current minute is odd/even.
   *
   * TRUE means even, FALSE means odd.
   */
  public function isCurrentMinuteEven(): bool {
    // Retrieve current timestamp.
    $currentTime = $this->timeService->getCurrentTime();
    // Retrieve custom format: minute - from current timestamp.
    $minute = $this->dateFormatter->format($currentTime, 'custom', 'i');

    return intval($minute) % 2 === 0 ? TRUE : FALSE;
  }

}
