<?php

/**
 * @file
 * Contains \Drupal\acquia_lift\Form\Settings.
 */

namespace Drupal\acquia_lift\Form;

use Drupal\Core\Config\Config;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Defines a form that configures devel settings.
 */
class Settings extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'acquia_lift_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'acquia_lift.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('acquia_lift.settings');
    $form['credential'] = $this->buildCredentialForm($config);

    return parent::buildForm($form, $form_state);
  }

  /**
   * Build credential form.
   *
   * @param \Drupal\Core\Config\Config $config
   *   Acquia Lift Config.
   *
   * @return array
   *   Credential form.
   */
  private function buildCredentialForm(Config $config) {
    $form = array(
      '#title' => t('Credential'),
      '#type' => 'fieldset',
      '#tree' => TRUE,
    );
    $form['account_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Account Name'),
      '#default_value' => $config->get('account_name'),
      '#required' => TRUE,
    );
    $form['customer_site'] = array(
      '#type' => 'textfield',
      '#title' => t('Customer Site'),
      '#default_value' => $config->get('customer_site'),
    );
    $form['api_url'] = array(
      '#type' => 'textfield',
      '#title' => t('API URL'),
      '#field_prefix' => 'http(s)://',
      '#default_value' => $config->get('api_url'),
      '#required' => TRUE,
    );
    $form['access_key'] = array(
      '#type' => 'textfield',
      '#title' => t('API Access Key'),
      '#default_value' => $config->get('access_key'),
      '#required' => TRUE,
    );
    $form['secret_key'] = array(
      '#type' => 'password',
      '#title' => t('API Secret Key'),
      '#default_value' => $config->get('secret_key'),
      '#required' => empty($config->get('secret_key')),
      '#description' => !empty($config->get('secret_key')) ? t('Only necessary if updating') : '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('acquia_lift.settings');
    $values = $form_state->getValues();

    $this->setCredentialValues($config, $values['credential']);

    $config->save();

    parent::submitForm($form, $form_state);
  }

  /**
   * Set credential values.
   *
   * @param \Drupal\Core\Config\Config $config
   *   Acquia Lift Config.
   * @param array $values
   *   Credential values.
   */
  private function setCredentialValues(Config $config, $values) {
    if (!empty($values['secret_key'])) {
      $config->set('secret_key', $values['secret_key']);
    }
    $config->set('account_name', $values['account_name'])
      ->set('customer_site', $values['customer_site'])
      ->set('api_url', $values['api_url'])
      ->set('access_key', $values['access_key']);
  }
}