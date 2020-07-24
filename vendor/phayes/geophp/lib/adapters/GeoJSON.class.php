<?php
/**
 * GeoJSON class : a geojson reader/writer.
 *
 * Note that it will always return a GeoJSON geometry. This
 * means that if you pass it a feature, it will return the
 * geometry of that feature strip everything else.
 */
class GeoJSON extends GeoAdapter
{
  /**
   * Given an object or a string, return a Geometry
   *
   * @param mixed $input The GeoJSON string or object
   *
   * @return object Geometry
   */
  public function read($input) {
    if (is_string($input)) {
      $input = json_decode($input);
    }
    if (!is_object($input)) {
      throw new Exception('Invalid JSON');
    }
    if (!is_string($input->type)) {
      throw new Exception('Invalid JSON');
    }

    // Check to see if it's a FeatureCollection
    if ($input->type == 'FeatureCollection') {
      $geoms = array();
      foreach ($input->features as $feature) {
        $geoms[] = $this->read($feature);
      }
      return geoPHP::geometryReduce($geoms);
    }
    // Check to see if it's a Feature
    if ($input->type == 'Feature') {
      return $this->read($input->geometry);
    }

    // It's a geometry - process it
    return $this->objToGeom($input);
  }

  private function objToGeom($obj) {
    $type = $obj->type;

    if ($type == 'GeometryCollection') {
      return $this->objToGeometryCollection($obj);
    }
    if ($type == 'Circle') {
      $obj->coordinates[] = $obj->radius;
    }
    $method = 'arrayTo' . $type;
    if (isset($obj->coordinates)) {
      return $this->$method($obj->coordinates);
    }
    else {
      return $this->$method($obj->components);
    }
  }

  private function arrayToPoint($array) {
    if (!empty($array)) {
      return new Point($array[0], $array[1]);
    }
    else {
      return new Point();
    }
  }

  private function arrayToLineString($array) {
    $points = array();
    foreach ($array as $comp_array) {
      $points[] = $this->arrayToPoint($comp_array);
    }
    return new LineString($points);
  }

  private function arrayToPolygon($array) {
    $lines = array();
    foreach ($array as $comp_array) {
      $lines[] = $this->arrayToLineString($comp_array);
    }
    return new Polygon($lines);
  }

  private function arrayToMultiPoint($array) {
    $points = array();
    foreach ($array as $comp_array) {
      $points[] = $this->arrayToPoint($comp_array);
    }
    return new MultiPoint($points);
  }

  private function arrayToMultiLineString($array) {
    $lines = array();
    foreach ($array as $comp_array) {
      $lines[] = $this->arrayToLineString($comp_array);
    }
    return new MultiLineString($lines);
  }

  private function arrayToMultiPolygon($array) {
    $polys = array();
    foreach ($array as $comp_array) {
      $polys[] = $this->arrayToPolygon($comp_array);
    }
    return new MultiPolygon($polys);
  }

  private function arrayToCircle($array) {
    if (is_array($array)) {
      $center = [$array[0], $array[1]];
      $center = $this->arrayToPoint($center);
      $radius = $array[2];
      $comp_array = [$center, $radius];
      return new Circle($comp_array);
    }
    else {
      $center = [$array->coordinates[0], $array->coordinates[1]];
      $center = $this->arrayToPoint($center);
      $radius = $array->radius;
      $comp_array = [$center, $radius];
      return new Circle($comp_array);
    }
  }

  private function arrayToMultiCircle($array) {
    $circles = array();
    foreach ($array as $comp_array) {
      $circles[] = $this->arrayToCircle($comp_array);
    }
    return new MultiCircle($circles);
  }

  private function objToGeometryCollection($obj) {
    $geoms = array();
    if (empty($obj->geometries)) {
      throw new Exception('Invalid GeoJSON: GeometryCollection with no component geometries');
    }
    foreach ($obj->geometries as $comp_object) {
      $geoms[] = $this->objToGeom($comp_object);
    }
    return new GeometryCollection($geoms);
  }

  /**
   * Serializes an object into a geojson string
   *
   *
   * @param Geometry $obj The object to serialize
   *
   * @return string The GeoJSON string
   */
  public function write(Geometry $geometry, $return_array = FALSE) {
    if ($return_array) {
      return $this->getArray($geometry);
    }
    else {
      return json_encode($this->getArray($geometry));
    }
  }

  public function getArray($geometry) {
    if ($geometry->getGeomType() == 'GeometryCollection') {
      $component_array = array();
      foreach ($geometry->components as $component) {
        if ($component->geometryType() !== 'Circle') {
          $component_array[] = array(
            'type' => $component->geometryType(),
            'coordinates' => $component->asArray(),
          );
        }
        else {
          $component_array[] = array(
            'type' => $component->geometryType(),
            'coordinates' => $component->getCenter(),
            'radius' => $component->getRadius(),
          );
        }
      }
      return array(
        'type'=> 'GeometryCollection',
        'geometries'=> $component_array,
      );
    }
    else if ($geometry->getGeomType() != 'Circle' && $geometry->getGeomType() != 'MultiCircle') { 
      return array(
        'type'=> $geometry->getGeomType(),
        'coordinates'=> $geometry->asArray(),
      );
    }
    else if ($geometry->getGeomType() == 'Circle') {
      return array(
        'type'=> $geometry->getGeomType(),
        'coordinates'=> $geometry->getCenter(),
        'radius' => $geometry->getRadius(),
      );
    }
    else if ($geometry->getGeomType() == 'MultiCircle') {
      $component_array = array();
      foreach ($geometry->components as $component) {
          $component_array[] = array(
            'type' => $component->geometryType(),
            'coordinates' => $component->getCenter(),
            'radius' => $component->getRadius(),
          );
      }
      return array(
        'type'=> 'MultiCircle',
        'components'=> $component_array,
      );
    }
  }
}


