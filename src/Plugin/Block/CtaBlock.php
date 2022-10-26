<?php

namespace Drupal\denistest\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "cta_subscribe",
 *   admin_label = @Translation("CTA subscribe block"),
 *   category = @Translation("denistest")
 * )
 */
class CtaBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\denistest\Form\CtaForm');    
    return $form;
  }

}
