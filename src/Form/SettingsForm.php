<?php

namespace Drupal\denistest\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Configure denistest settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'denistest_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['denistest.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $uid = \Drupal::currentUser()->id();
    $form['wtext'] = [
      '#type' => 'textfield',
      '#title' => $this->t('My Welcome Text'),
      '#default_value' => $this->config('denistest.settings')->get($uid),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('wtext') == '') {
      $form_state->setErrorByName('wtext', $this->t('The value is not correct.'));
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $uid = \Drupal::currentUser()->id();
    $this->config('denistest.settings')
      ->set($uid, $form_state->getValue('wtext'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
