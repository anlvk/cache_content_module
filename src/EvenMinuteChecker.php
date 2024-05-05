<?php

namespace Drupal\cache_content;

use \Drupal\Component\Datetime\TimeInterface;
use \Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class EvenMinuteChecker
 *
 * @package Drupal\cache_content
 */
class EvenMinuteChecker {
    /**
     * The time service.
     *
     * @var \Drupal\Component\Datetime\TimeInterface
     */
    protected TimeInterface $timeService;

    /**
     * The date formatter service.
     *
     * @var \Drupal\Core\Datetime\DateFormatterInterface
     */
    protected DateFormatterInterface $dateFormatter;

    /**
     * Class constructor.
     */
    public function __construct(TimeInterface $timeService, DateFormatterInterface $dateFormatter) {
        $this->timeService = $timeService;
        $this->dateFormatter = $dateFormatter;
    }

    /**
     * Retrieves current timestamp and format this to retrieve a current minute (by custom format).
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

