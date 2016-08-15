<?php

namespace S2Geometry\DataStructures;

use ArrayAccess;
use Iterator;

interface IMultiMap extends ArrayAccess, Iterator{
    /**
     * @param mixed $key
     * @param mixed $val
     */
    public function add($key, $val = NULL);
    /**
     * @param mixed $key
     * @param mixed $val
     */
    public function remove($key, $val = NULL);
    public function clear();
    /**
     * @param mixed $key
     */
    public function containsKey($key);
    /**
     * @param type $key
     * @param type $val
     */
    public function contains($key, $val);
    public function getKeys();
    public function getValues();
    /**
     * @param array $array
     * @param integer $idx
     */
    public function copyTo(array &$array, $idx = 0);
    /**
     * @return integer
     */
    public function getCount();
}