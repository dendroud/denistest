<?php

namespace Drupal\denistest\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event firing on user subscribe.
 */
class UserSubscribeEvent extends Event {

  const DENISTEST_USER_SUBSCRIBE = 'denistest.user.subscribe';

  /**
   * Variables for event.
   */
  protected $variables;

  /**
   * constructor.
   */
  public function __construct($variables) {
    $this->variables = $variables;
  }

  /**
   * Returns variables array.
   */
  public function getVariables() {
    return $this->variables;
  }

}
