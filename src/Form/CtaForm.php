<?php

namespace Drupal\denistest\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\denistest\Event\UserSubscribeEvent;

/**
 * Provides a CtaForm form.
 */
class CtaForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'denistest_cta';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Subscribe'),
      '#cache' => ['max-age' => 0],
    ];

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $dispatcher = \Drupal::service('event_dispatcher');
    $user = \Drupal::currentUser();  
    $event = new UserSubscribeEvent(['user' => $user]);   
    $dispatcher->dispatch(UserSubscribeEvent::DENISTEST_USER_SUBSCRIBE, $event);
    
  }

}
