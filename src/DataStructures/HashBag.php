<?php

namespace S2Geometry\DataStructures;

class HashBag {
    
    /**
     * @var int
     */
    private $size;
    
    /**
     * @var array
     */
    private $dict;
    
    public function __construct(){
        $this->size = 0;
        $this->dict = [];
    }
    
    /**
     * @param mixed $item
     */
    public function add($item){
        if (isset($this->dict[$item])){
            $this->dict[$item]++;
        } else {
            $this->dict[$item] = 1;
        }
        $this->size++;
    }
    
    public function clear(){
        $this->size = 0;
        $this->dict = [];
    }
    
    /**
     * @param mixed $item
     * @return boolean
     */
    public function contains($item){
        return isset($this->dict[$item]);
    }
    
    /**
     * @param array $arr
     * @param int $idx
     * @throws InvalidArgumentException
     */
    public function copyTo(array &$arr, $idx){
        if ($idx < 0) throw new InvalidArgumentException();
        foreach ($this->dict as $key => $val){
            for ($i = 0; $i < $val; $i++){
                $arr[$idx++] = $key;
            }
        }
    }
    
    /**
     * @param mixed $item
     * @return boolean
     */
    public function remove($item){
        if (!isset($this->dict[$item])) return false;
        $this->size--;
        if (--$this->dict[$item] <= 0){
            unset($this->dict[$item]);
        }
        return true;
    }
    
    /**
     * @return int
     */
    public function getSize(){
        return $this->size;
    }
    
}