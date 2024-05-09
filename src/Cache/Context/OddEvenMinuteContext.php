<?php

/**
 * @file
 * Contains \Drupal\cache_content\Cache\Context\OddEvenMinuteContext.
 */

namespace Drupal\cache_content\Cache\Context;

use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Cache\CacheableMetadata;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\cache_content\EvenMinuteChecker;

class OddEvenMinuteContext implements CacheContextInterface {
    /**
     * Odd/even minute service.
     *
     * @var \Drupal\cache_content\EvenMinuteChecker
     */
    protected $minuteChecker;

    /**
     * Class constructor.
     *
     * @param EvenMinuteChecker $minuteChecker
     */
	public function __construct(EvenMinuteChecker $minuteChecker) {
		$this->minuteChecker = $minuteChecker;
	}

    /**
     * Instantiates a new instance of this class.
     *
     * @param ContainerInterface $container
     * @return object
     */
    public static function create(ContainerInterface $container): object {
        return new static(
            $container->get('cache_content.odd_even_minute_check')
        );
    }

    /**
     * Returns the label of the cache context.
     *
     * @return string
     */
	public static function getLabel(): string {
		return t('Odd/even minute context');
	}

    /**
     * Returns the string representation of the cache context.
     *
     * @return string
     */
	public function getContext(): string {
        $isEvenMinute = $this->minuteChecker->isCurrentMinuteEven();
        $result = ($isEvenMinute === true) ? 'even' : 'odd';

        return $result;
    }

    /**
     * Returns the cacheability metadata for this response.
     *
     * @return object
     */
    public function getCacheableMetadata(): object {
        return new CacheableMetadata();
    }

}
