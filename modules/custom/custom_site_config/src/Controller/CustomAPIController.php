<?php
/**
 * @file
 * Contains \Drupal\custom_site_config\Controller\CustomAPIController.
 */

namespace Drupal\custom_site_config\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Access\AccessResult;
use Drupal\node\Entity\Node;


/**
 * Controller for api routes.
 */
class CustomAPIController extends ControllerBase {

  /**
   * Callback for "page_data.json/{apikey}/{nid}"" API method.
   */
  public function get_page_data(Request $request, $apikey, $nid) {
    try {
      $data = array();
      $response['method'] = 'GET';
      //load the node from the node id passed in the URL
      $node = Node::load($nid);
      if (!empty($node)) {
        //create a json response of the page node data
        $data = array(
          'title' => $node->get('title')->getValue()[0]['value'],
          'body' => $node->get('body')->getValue()[0]['value'],
          'status' => $node->get('status')->getValue()[0]['value'],
        );
        $response['response'] = 200;

      }
      else {
        //create a json response of the page node data
        $data = array(
          'error' => t('Data not found.Please try again!'),
        );
        $response['response'] = 404;

      }
      $response['response_data'] = $data;
      return new JsonResponse($response);
    }
    catch (Exception $e) {
      $data = array(
        'error' => t('Data not found.Please try again!'),
      );
      $response['method'] = 'GET';
      $response['response'] = 404;
      $response['response_data'] = $data;
      return new JsonResponse($response);
    }
  }

  /**
   * Callback for checking the API key permisssion
   */
  public function validate_api_key($apikey, $nid) {
    try {
      //get the api key values from config
      $config = \Drupal::config('custom_site_config.settings');
      //if api key matches then allow the user to access the API
      if ($apikey == $config->get('custom_site_config.siteapikey')) {
        return AccessResult::allowed();
      }
      else {
        return AccessResult::forbidden();
      }
    }
    catch (Exception $ex) {
      return AccessResult::forbidden();

    }
  }
}

?>
