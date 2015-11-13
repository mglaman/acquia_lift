<?php

/**
 * @file
 * Contains \Drupal\acquia_lift\Controller\TestController.
 */

namespace Drupal\acquia_lift\Controller;

use Drupal\Core\Controller\ControllerBase;

class TestController extends ControllerBase {
  public function test() {
    $data_api = \Drupal::service('acquia_lift.api.data_api');
    $segments = $data_api->getSegments();
    $build['segments'] = array(
      '#markup' => print_r($segments, TRUE),
    );
    return $build;
  }
} 
