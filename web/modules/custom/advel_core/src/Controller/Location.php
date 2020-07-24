<?php
/**
* @file
* Contains \Drupal\advel_core\Location.
*/
 
namespace Drupal\advel_core\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides route responses for the hello world page example.
 */
class Location extends ControllerBase {
  
	public function update($id, Request $request = null) {
    
    $conn = Database::getConnection();
    $location = '';

    if ($request) {
        $data = json_decode($request->getContent());
        foreach ($data->coordinates as $loc) {
          $result = $conn->insert('tracking')
            ->fields([
              'lat' => floatval($loc->latitude),
              'lon' => floatval($loc->longitude),
              'uid' => $id,
              'timestamp' => $loc->timestamp
            ])
            ->execute(); 
        }
    }


    return new JsonResponse(['id' => $id, 'location' => $data]);
  }
}