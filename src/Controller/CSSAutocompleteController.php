<?php

namespace Drupal\bricks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Component\Utility\Tags;
use Drupal\Component\Utility\Unicode;

/**
 * Returns autocomplete responses for tokens.
 */
class CSSAutocompleteController extends ControllerBase {

  /**
   * Retrieves suggestions for block category autocompletion.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   * @param string $brick_type
   *   The brick type.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   A JSON response containing autocomplete suggestions.
   */
  public function handleAutocomplete(Request $request, $brick_type) {
    $results = [];


    $config = $this->config('bricks.settings');
    $css_classes = $config->get('css_classes');

    // Get the typed string from the URL, if it exists.
    if ($input = $request->query->get('q')) {
      foreach($css_classes as $value => $label) {
        if(strpos($value, $input) !== false || strpos($label, $input) !== false ) 
          $results[] = [
            'value' => $value,
            'label' => $label,
            ];
      }
    }

    return new JsonResponse($results);
  }

}
