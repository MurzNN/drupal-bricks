<?php
/**
 * @file
 * Contains Drupal\bricks\Form\SettingsForm.
 */
namespace Drupal\bricks\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\options\Plugin\Field\FieldType;

/**
 * Class SettingsForm.
 *
 * @package Drupal\bricks\Form
 */
class SettingsForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'bricks.settings',
    ];
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('bricks.settings');

    $form['css_classes'] = array(
      '#type' => 'textarea',
      '#title' => 'CSS classes for autocomplete',
      '#default_value' => static::allowedValuesString($config->get('css_classes')),
      '#element_validate' => [[get_class($this), 'validateAllowedValues']],
    );
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public static function validateAllowedValues($element, FormStateInterface $form_state) {
    \Drupal\options\Plugin\Field\FieldType\ListStringItem::validateAllowedValues($element, $form_state);
  }

  protected function allowedValuesString($values) {
    $lines = [];
    foreach ($values as $key => $value) {
      $lines[] = "$key|$value";
    }
    return implode("\n", $lines);
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('bricks.settings')
      ->set('css_classes', $form_state->getValue('css_classes'))
      ->save();
  }
}
