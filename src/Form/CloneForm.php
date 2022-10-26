<?php

namespace Drupal\denistest\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a denistest form.
 */
class CloneForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'denistest_clone';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, int $nid = null) {

    $form['#title'] = $this->t("Confirm cloning");
    $form['nid'] = [
        '#type' => 'hidden',
        '#value' => $nid
    ];

    $form['clone'] = [
        '#type' => 'submit',
        '#value' => $this->t('Confirm'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (intval($form_state->getValue('nid')) < 1) {
      $form_state->setErrorByName('name', $this->t('Message node can`t be cloned.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $nid = $form_state->getValue('nid');
    $storage = \Drupal::entityTypeManager()->getStorage('node');

    $node = $storage->load($nid);

    $original_values = $node->toArray();

// assign content type as string, the array causes an error when creating a new node
    $original_values['type'] = $node->bundle();

// change title
    $original_values['title'] = 'Clone ' .  $node->label();

// remove nid and uuid, the cloned node is assigned new ones when saved
    unset($original_values['nid']);
    unset($original_values['uuid']);

// remove revision data, the latest revision becomes the only one in the new node
    unset($original_values['vid']);
    unset($original_values['revision_translation_affected']);
    unset($original_values['revision_uid']);
    unset($original_values['revision_log']);
    unset($original_values['revision_timestamp']);

    $node_cloned = $storage->create($original_values);
    $node_cloned->save();
    $this->messenger()->addStatus($this->t('Node has been cloned'));
  }

}
