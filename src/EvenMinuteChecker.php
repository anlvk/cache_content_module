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
     * {@inheritdoc}
     */
    public function __construct() {
        $this->currentMinute = date('i');
    }

    public function isEven() {
        $minute = intval($this->currentMinute);
        /**
         * true - even
         * false - odd
         */
        return $minute % 2 === 0 ? true : false ;
    }
}
