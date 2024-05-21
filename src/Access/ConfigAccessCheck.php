<?php

namespace Drupal\cache_content\Access;

use Drupal\cache_content\EvenMinuteChecker;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;

/**
 * Checks access for displaying configuration form page (module settings).
 */
class ConfigAccessCheck implements AccessInterface {

  public function __construct(
    private EvenMinuteChecker $minuteChecker,
  ) {
    $this->minuteChecker = $minuteChecker;
  }

  /**
   * A custom access check.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access() {
    return ($this->isConfigMinute()) ? AccessResult::allowed() : AccessResult::forbidden();
  }

  /**
   * Allows configuration availability if current minute is even.
   */
  public function isConfigMinute(): bool {
    return $this->minuteChecker->isCurrentMinuteEven() === TRUE;
  }

}
