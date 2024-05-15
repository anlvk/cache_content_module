<?php

namespace Drupal\cache_content\Cache\Context;

use Drupal\cache_content\EvenMinuteChecker;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Implements custom cache context.
 *
 * @see \Drupal\Core\Form\ConfigFormBase
 */
class OddEvenMinuteContext implements CacheContextInterface {
  /**
   * Class constructor.
   *
   * @param \Drupal\cache_content\EvenMinuteChecker $minuteChecker
   *   The odd/even minute check service.
   */
  public function __construct(
    protected EvenMinuteChecker $minuteChecker,
  ) {
    $this->minuteChecker = $minuteChecker;
  }

  /**
   * Instantiates a new instance of this class.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   Provides Drupal service container.
   */
  public static function create(ContainerInterface $container): object {
    return new static(
      $container->get('cache_content.odd_even_minute_check')
    );
  }

  /**
   * Returns the label of the cache context.
   */
  public static function getLabel(): string {
    return t('Odd/even minute context');
  }

  /**
   * Returns the string representation of the cache context.
   */
  public function getContext(): string {
    $isEvenMinute = $this->minuteChecker->isCurrentMinuteEven();
    $result = ($isEvenMinute === TRUE) ? 'even' : 'odd';

    return $result;
  }

  /**
   * Returns the cacheability metadata for this response.
   */
  public function getCacheableMetadata(): object {
    return new CacheableMetadata();
  }

}
