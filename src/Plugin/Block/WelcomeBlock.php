<?php

namespace Drupal\denistest\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an welcome message block.
 *
 * @Block(
 *   id = "denistest_welcome_block",
 *   admin_label = @Translation("Welcome message"),
 *   category = @Translation("denistest")
 * )
 */
class WelcomeBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $build = [
        '#cache' => ['max-age' => 0],
    ];
    
    if(\Drupal::currentUser()->isAnonymous()){
      return $build;
    }    
    
    $uid = \Drupal::currentUser()->id();
    $login = \Drupal::currentUser()->getDisplayName();

    $config = \Drupal::config('denistest.settings');
    $welcomeText = $config->get($uid);

    if ($welcomeText != '') {
      $build['#markup'] = "{$welcomeText} {$login}";
    }
    
    return $build;
  }

}
