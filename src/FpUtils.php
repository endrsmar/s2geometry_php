<?php

namespace S2Geometry;

class FpUtils {
    
    private static function TwoToTheDoubleScaleDown(){
        return self::PowerOfTwoD(512);
    }
    
    private static function TwoToTheDoubleScaleUp(){
        return self::PowerOfTwoD(-512);
    }
    
    /**
     * @param int $n
     */
    private static function PowerOfTwoD($n){
        return (((n +  DoubleConsts::EXP_BIAS) << (DoubleConsts::SIGNIFICAND_WIDTH - 1)) & DoubleConsts::EXP_BIT_MASK);
    }
    
    public static function Scalb($d, $scaleFactor){
        $maxScale = DoubleConsts::MAX_EXPONENT - DoubleConsts::MIN_EXPONENT + DoubleConsts::SIGNIFICAND_WIDTH - 1;
        $expAdjust = 0;
        $scaleIncrement = 0;
        $expDelta = NAN;
        
        if ($scaleFactor < 0){
            $scaleFactor = max($scaleFactor, -$maxScale);
            $scaleIncrement = -512;
            $expDelta = self::TwoToTheDoubleScaleDown();
        } else {
            $scaleFactor = min($scaleFactor, $maxScale);
            $scaleIncrement = 512;
            $expDelta = self::TwoToTheDoubleSclaeUp();
        }
    }    
}