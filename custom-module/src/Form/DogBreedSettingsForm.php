<?php

namespace Drupal\dogbreed\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DogBreedSettingsForm that allows the config of the module dogbreed.
 *
 * @package Drupal\dogbreed\Form
 */
class DogBreedSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dogbreed.settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'dogbreed.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $config = $this->config('dogbreed.settings');

    $form['standard_dog_breed'] = [
      '#type' => 'textfield',
      '#title' => 'Standard dog breed',
      '#default_value' => $config->get('standard_dog_breed'),
      '#required' => TRUE,
      '#description' => $this->t('Sets the default dog breed to display in the custom tile'),
    ];

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('dogbreed.settings')
      ->set('standard_dog_breed', $form_state->getValue('standard_dog_breed'))
      ->save();
  }

}
