<?php
/*
 * This file is part of the Invoice-maker package.
 * (c) Samuel A <samuelizuchi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class InvoiceMakerTestCase extends  \PHPUnit_Framework_TestCase
{

    public function expects($expected, $actual){
        if(is_string($actual)){
            if($expected !== $actual){
                throw new UnexpectedValueException("Expected ".$expected." to equal ".$actual);
            }
        }elseif(is_object($actual)){
            if(!($expected instanceof $actual)){
                throw new UnexpectedValueException("Expected ".get_class($expected)." to be instanceOf ".get_class($actual));
            }
        }else{
            if($expected != $actual){
                throw new UnexpectedValueException("Expected ".$expected." to equal ".$actual);
            }
        }
    }
}