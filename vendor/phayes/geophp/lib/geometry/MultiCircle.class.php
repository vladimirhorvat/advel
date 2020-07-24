<?php
/**
 * MultiCircle: A collection of Circles
 */
class MultiCircle extends Geometry
{
  protected $geom_type = 'MultiCircle';
  public $components = array();

  public function __construct($components = array()) {
    if (!is_array($components)) {
      throw new Exception("Component geometries must be passed as an array");
    }
    foreach ($components as $component) {
      if ($component instanceof Geometry) {
        $this->components[] = $component;
      }
      else {
        throw new Exception("Cannot create a collection with non-geometries");
      }
    }
  }

  public function getComponents() {
    return $this->components;
  }

  public function getType() {
    return $this->$geom_type;
}

public function asArray() {
    $array = array();
    foreach ($this->components as $component) {
      $array[] = $component;
    }
    return $array;
}

public function centroid() {
    if ($this->isEmpty()) return NULL;

    if ($this->geos()) {
      $geos_centroid = $this->geos()->centroid();
      if ($geos_centroid->typeName() == 'Point') {
        return geoPHP::geosToGeometry($this->geos()->centroid());
      }
    }

    // As a rough estimate, we say that the centroid of a colletion is the centroid of it's envelope
    // @@TODO: Make this the centroid of the convexHull
    // Note: Outside of polygons, geometryCollections and the trivial case of points, there is no standard on what a "centroid" is
    $centroid = $this->envelope()->centroid();

    return $centroid;
}

public function getBBox() {

    foreach ($this->components as $component) {
        $circle = new Circle($component->components);
        $center = $circle->getCenter();
        $radius = round($circle->getRadius()/111139, 6);
        
        $upper_left = [ $center[0] - $radius, $radius - $center[1] ];
        $x[] = $upper_left[0];
        $y[] = $upper_left[1];

        $upper_right = [ $center[0] + $radius, $radius - $center[1] ];
        $x[] = $upper_right[0];
        $y[] = $upper_right[1];

        $lower_right = [ $center[0] + $radius, 0 - $center[1] - $radius ];
        $x[] = $lower_right[0];
        $y[] = $lower_right[1];

        $lower_left = [ $radius - $center[0], 0 - $center[1] - $radius ];
        $x[] = $lower_left[0];
        $y[] = $lower_left[1];

    }

    $maxx = max($x);
    $minx = min($x);
    $maxy = max($y);
    $miny = min($y);

    return array (
    'maxy' => $maxy,
    'miny' => $miny,
    'maxx' => $maxx,
    'minx' => $minx,
    ); 
}

public function area() { return NULL; }
public function boundary() { return NULL; }
public function length() { return NULL; }
public function y() { return NULL; }
public function x() { return NULL; }
public function numGeometries() { return NULL; }
public function geometryN($n) { return NULL; }
public function startPoint() { return NULL; }
public function endPoint() { return NULL; }
public function isRing() { return NULL; }          
public function isClosed() { return NULL; }      
public function numPoints() { return NULL; }
public function pointN($n) { return NULL; }
public function exteriorRing() { return NULL; }
public function numInteriorRings() { return NULL; }
public function interiorRingN($n) { return NULL; }
public function dimension() { return NULL; }
public function equals($geom) { return NULL; }
public function isEmpty() { return NULL; }
public function isSimple() { return NULL; }

  // Abtract: Non-Standard
  // ---------------------
public function getPoints() { return NULL; }
public function explode(){ return NULL; }
public function greatCircleLength() { return NULL; }
public function haversineLength() { return NULL; }
}