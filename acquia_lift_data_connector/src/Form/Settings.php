<?php

/**
 * @file
 * Contains \Drupal\acquia_lift_manager\Form\Settings.
 */

namespace Drupal\acquia_lift_data_connector\Form;

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
  public function getFormID() {
    return 'acquia_lift_data_connector_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'acquia_lift_data_connector.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL) {
    $config = $this->config('acquia_lift_data_connector.settings');

    $form['account_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Account Name'),
      '#default_value' => $config->get('account_name'),
      '#required' => TRUE,
    );
    $form['site_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Customer Site'),
      '#default_value' => $config->get('site_name'),
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
      '#required' => TRUE,
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $config = $this->config('acquia_lift_data_connector.settings');

    $config->set('account_name', $values['account_name'])
      ->set('site_name', $values['site_name'])
      ->set('api_url', $values['api_url'])
      ->set('access_key', $values['access_key'])
      ->set('secret_key', $values['secret_key'])
      ->save();

    parent::submitForm($form, $form_state);
  }
}
