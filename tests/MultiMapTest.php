<?php

namespace S2GeometryTests;

use PHPUnit_Framework_TestCase;
use S2Geometry\DataStructures\KeyValuePair;
use S2Geometry\DataStructures\MultiMap;

class MultiMapTest extends PHPUnit_Framework_TestCase {
    
    public function testAdd(){
        $map = new MultiMap();
        $map->add('test', 'val1');
        $this->assertEquals(1, $map->getCount());
        $this->assertEquals(['val1'], $map->getValues());
        $this->assertEquals(['test'], $map->getKeys());
        $map->add('test', ['val2', 'val3']);
        $this->assertEquals(3, $map->getCount());
        $this->assertEquals(['val1', 'val2', 'val3'], $map->getValues());
        $map->add(new KeyValuePair('test2', ['val1', 'val2']));
        $this->assertEquals(5, $map->getCount());
        $this->assertEquals(['test', 'test2'], $map->getKeys());
    }    
    
    public function testRemove(){
        $map = new MultiMap();
        $map->add('test', ['val1', 'val2', 'val3']);
        $map->add('test2', ['val1', 'val2']);
        $map->remove('test', 'val2');
        $this->assertEquals(['val1', 'val3', 'val1', 'val2'], $map->getValues());
        $map->remove('test');
        $this->assertEquals(['test2'], $map->getKeys());
        $this->assertEquals(2, $map->getCount());
    }
    
    public function testArrayAccessor(){
        $map = new MultiMap();
        $map['test'] = 'val1';
        $map['test'] = 'val2';
        $this->assertEquals(['val1', 'val2'], $map->getValues());
        $this->assertEquals(['val1', 'val2'], $map['test']);
        unset($map['test']);
        $this->assertEquals(0, $map->getCount());
    }
    
    public function testIterator(){
        $map = new MultiMap();
        $map->add('test', ['val1', 'val2', 'val3']);
        $map->add('test2', ['val4', 'val5', 'val6']);
        $tmp = [];
        foreach ($map as $val){
            $tmp[] = $val;
        }
        $this->assertEquals(['val1', 'val2', 'val3', 'val4', 'val5', 'val6'], $tmp);
    }
}

