<?php
/*
 * This file is part of the codeliner/php-equalsbuilder package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Codeliner\Comparison;

/**
 * Class EqualsBuilder
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class EqualsBuilder
{
    protected $strict = false;
    
    protected $comparisonList = array();


    /**
     * @return EqualsBuilder
     */
    static public function create()
    {
        return new static();
    }
    
    /**
     * Enable or disable strict comparison
     * 
     * @return EqualsBuilder
     */
    public function strict($flag = true)
    {
        $this->strict = $flag;
        return $this;
    }
    
    /**
     * Add a new value pair to comparison list
     * 
     * @param mixed $a
     * @param mixed $b
     * @return EqualsBuilder
     */
    public function append($a, $b)
    {
        $this->comparisonList[] = array($a, $b);
        return $this;
    }
    
    /**
     * Compare all previous set value pairs
     * 
     * @return boolean
     */
    public function equals()
    {
        foreach ($this->comparisonList as $valuePair) {
            $a = $valuePair[0];
            $b = $valuePair[1];
            
            if (! (($this->strict)? $a === $b : $a == $b) ) {
                return false;
            }
        }
        
        return true;
    }
}
