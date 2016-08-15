<?php

namespace S2Geometry\DataStructures;

class MultiMap implements IMultiMap{
    /**
     * @var array
     */
    private $internalStorage;
    
    private $currentKeyPos;
    private $currentValPos;
    
    public function __cosntruct($initialData = null){
        $this->internalStorage = [];
        if ($initialData){
            foreach ($initialData as $key => $val){
                $this->add($key, $val);
            }
        }
        $this->currentKeyPos = 0;
        $this->currentValPos = 0;
    }
    
    public function sortByKeys(){
        ksort($this->internalStorage);
    }
    
// <editor-fold defaultstate="collapsed" desc="Methods inherited from IMultiMap">
    /**
     * @param mixed $key
     * @param mixed $val
     * @throws InvalidArgumentException
     */
    public function add($key, $val = NULL) {
        if ($key instanceof KeyValuePair && !$val) {
            $val = $key->getValue();
            $key = $key->getKey();
        }
        if (!$val) {
            throw new InvalidArgumentException();
        }
        if (!isset($this->internalStorage[$key])) {
            $this->internalStorage[$key] = [];
        }
        if (!is_array($val)) {
            $this->internalStorage[$key][] = $val;
        } else {
            foreach ($val as $v) {
                $this->internalStorage[$key][] = $v;
            }
        }
    }


    /**
     * @param mixed $key
     * @param mixed $val
     * @return boolean
     */
    public function remove($key, $val = NULL) {
        if ($key instanceof KeyValuePair) {
            $val = $key->getValue();
            $key = $key->getKey();
        }
        if (!isset($this->internalStorage[$key])) {
            return false;
        }
        if (!$val) {
            unset($this->internalStorage[$key]);
            return true;
        }
        if (($k = array_search($val, $this->internalStorage[$key])) !== false) {
            array_splice($this->internalStorage[$key], $k, 1);
            if (!count($this->internalStorage[$key])) {
                unset($this->internalStorage[$key]);
            }
            return true;
        }
        return false;
    }


    /**
     * @param mixed $key
     * @return boolean
     */
    public function containsKey($key) {
        return isset($this->internalStorage[$key]);
    }


    /**
     * @param mixed $key
     * @param mixed $val
     * @return boolean
     * @throws InvalidArgumentException
     */
    public function contains($key, $val = NULL) {
        if ($key instanceof KeyValuePair) {
            $val = $key->getValue();
            $key = $key->getKey();
        }
        if (!$val) {
            throw new InvalidArgumentException();
        }
        if (!isset($this->internalStorage[$key])) {
            return false;
        }
        return array_search($val, $this->internalStorage[$key]) !== false;
    }


    /**
     * @return int
     */
    public function getCount() {
        $count = 0;
        foreach ($this->internalStorage as $arr) {
            $count += count($arr);
        }
        return $count;
    }


    /**
     * @param integer $limit
     * @return boolean
     */
    public function isCountAtLeast($limit) {
        $count = 0;
        foreach ($this->internalStorage as $arr) {
            $count += count($arr);
            if ($count >= $limit) {
                return true;
            }
        }
        return false;
    }


    public function clear() {
        $this->internalStorage = [];
    }


    /**
     * @param array $array
     * @param integer $offset
     */
    public function copyTo(array &$array, $offset = 0) {
        foreach ($this->internalStorage as $key => $arr) {
            foreach ($arr as $val) {
                $array[$offset++] = new KeyValuePair($key, $val);
            }
        }
    }


    /**
     * @return array
     */
    public function getKeys() {
        return array_keys($this->internalStorage);
    }


    /**
     * @return array
     */
    public function getValues() {
        $retval = [];
        foreach ($this->internalStorage as $arr) {
            $retval = array_merge($retval, $arr);
        }
        return $retval;
    }

// </editor-fold>
    
// <editor-fold defaultstate="collapsed" desc="Methods inherited from ArrayAccess">
    /**
     * @param mixed $offset
     * @param mixed $val
     * @throws InvalidArgumentException
     */
    public function offsetSet($offset, $val) {
        if (is_null($offset)) {
            throw new InvalidArgumentException();
        }
        $this->add($offset, $val);
    }


    /**
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists($offset) {
        return isset($this->internalStorage[$offset]);
    }


    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset) {
        unset($this->internalStorage[$offset]);
    }


    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset) {
        return isset($this->internalStorage[$offset]) ? $this->internalStorage[$offset] : NULL;
    }

// </editor-fold>

// <editor-fold defaultstate="collapsed" desc="Methods inherited from Iterator">
    /**
     * @return mixed
     */
    public function current() {
        $keys = $this->getKeys();
        return $this->internalStorage[$keys[$this->currentKeyPos]][$this->currentValPos];
    }


    /**
     * @return string
     */
    public function key() {
        return $this->getKeys()[$this->currentKeyPos];
    }


    public function next() {
        $keys = $this->getKeys();
        $this->currentValPos++;
        if ($this->currentValPos >= count($this->internalStorage[$keys[$this->currentKeyPos]])) {
            $this->currentValPos = 0;
            $this->currentKeyPos++;
        }
    }


    public function rewind() {
        $this->currentKeyPos = 0;
        $this->currentValPos = 0;
    }


    /**
     * @return boolean
     */
    public function valid() {
        $keys = $this->getKeys();
        if ($this->currentKeyPos >= count($keys)
            || $this->currentValPos >= count($this->internalStorage[$keys[$this->currentKeyPos]])) {
            return false;
        }
        return true;
    }

// </editor-fold>

}