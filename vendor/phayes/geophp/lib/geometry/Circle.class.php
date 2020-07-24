<?php

/**
 * You know what a circle is, right? 
 * 
 */
class Circle extends Geometry
{
  protected $geom_type = 'Circle';
  public $components = array();

  public function __construct($components = array()) {
    if (!is_array($components)) {
      throw new Exception("Component geometries must be passed as an array");
    }
    foreach ($components as $component) {
        $this->components[] = $component;
    }
  }

    public function isEmpty() {
        if (!count($this->components)) {
          return TRUE;
        }
        else {
          foreach ($this->components as $component) {
            if ($component instanceOf Geometry) {
              if (!$component->isEmpty()) return FALSE;
            }
            else {
              if (!isset($component)) return FALSE;
            }
          }
          return TRUE;
        }
    }

    public function getComponents() {
        return $this->components;
    }

    public function getType() {
        return $this->$geom_type;
    }

    public function getCenter() {
      return $this->components[0];
    }

    public function centroid() {
      $center = $this->getCenter();
      return new Point($center[0], $center[1]);
    }

    public function getRadius() {
      return $this->components[1];
    }

    public function asArray() {
      $array = array();
      foreach ($this->components as $component) {
        $array[] = $component;
      }
      return $array;
    }

    public function getBBox() {

      $center = $this->getCenter();
      $radius = round($this->getRadius()/111139, 6);
      $upper_left = [ $center[0] - $radius, $radius - $center[1] ];
      $upper_right = [ $center[0] + $radius, $radius - $center[1] ];
      $lower_right = [ $center[0] + $radius, 0 - $center[1] - $radius ];
      $lower_left = [ $radius - $center[0], 0 - $center[1] - $radius ];

      return array (
      'maxy' => $upper_left[1],
      'miny' => $lower_left[1],
      'maxx' => $upper_right[0],
      'minx' => $upper_left[0],
      ); 
    }

    // Chilling for now
    public function area()  {error_log('area'); return NULL; }
    public function boundary()  {error_log('boundary'); return NULL; }
    public function length() {error_log('length'); return NULL; }
    public function y() {error_log('y'); return NULL; }
    public function x() {error_log('x'); return NULL; }
    public function numGeometries() {error_log('numgeometries'); return NULL; }
    public function geometryN($n) {error_log('geometryn'); return NULL; }
    public function startPoint() {error_log('startpoint'); return NULL; }
    public function endPoint() {error_log('endpoint'); return NULL; }
    public function isRing()    {error_log('isring'); return NULL; }          
    public function isClosed()  {error_log('isclosed'); return NULL; }       
    public function numPoints() {error_log('area'); return NULL; }
    public function pointN($n)  {error_log('pointn'); return NULL; }
    public function exteriorRing()  {error_log('exteriorring'); return NULL; }
    public function numInteriorRings()  {error_log('numinteriorrings'); return NULL; }
    public function interiorRingN($n)   {error_log('interiorringn'); return NULL; }
    public function dimension() {error_log('dimension'); return NULL; }
    public function equals($geom)   {error_log('equals'); return NULL; }
    public function isSimple()  {error_log('issimple'); return NULL; }
    public function getPoints() {error_log('getpoints'); return NULL; }
    public function explode()   {error_log('explode'); return NULL; }
    public function greatCircleLength() {error_log('greatcirclelength'); return NULL; }
    public function haversineLength()   {error_log('haversinelength'); return NULL; }
}

