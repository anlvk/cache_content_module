<?php

namespace Drupal\cache_content;

/**
 * Class EvenMinuteChecker
 *
 * @package Drupal\cache_content
 */
class EvenMinuteChecker {

    private $currentMinute;

    /**
     * Undocumented function
     */
    public function __construct() {
        $this->currentMinute = date('i');
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isEven() {
        $minute = intval($this->currentMinute);
        // true - even, false - odd
        return $minute % 2 === 0 ? true : false ;
    }
}

