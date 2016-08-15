<?php

namespace S2Geometry\DataStructures;

class KeyValuePair {
    /**
     * @var mixed
     */
    private $key;
    
    /**
     * @var mixed
     */
    private $value;
    
    /**
     * @param mixed $key
     * @param mixed $value
     */
    public function __construct($key, $value){
        $this->key = $key;
        $this->value = $value;
    }
    
    /**
     * @return mixed
     */
    public function getKey(){
        return $this->key;
    }
    
    /**
     * @param mixed $key
     */
    public function setKey($key){
        $this->key = $key;
    }
    
    /**
     * @return mixed
     */
    public function getValue(){
        return $this->value;
    }
    
    /**
     * @param mixed $value
     */
    public function setValue($value){
        $this->value = $value;
    }
}