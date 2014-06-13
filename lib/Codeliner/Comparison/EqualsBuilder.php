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
     * @param bool $flag
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
     * @param mixed|true $b                     If you just provide $a it is compared with a boolean TRUE
     * @param null|callable $comparatorCallback If you pass in an optional callback, this callback is used to compare $a and $b.
     *                                          The callback should return TRUE if $a and $b are equals or FALSE if not.
     *                                          If $a and $b are arrays with a numeric index aka. lists, the callback is
     *                                          called for every item in list $a and the item of list $b with the same index.
     *
     * @return EqualsBuilder
     *
     * @example
     *
     * <code>
     * echo EqualsBuilder::create()
     *      ->append(1, 1)
     *      ->append('equals', 'equals')
     *      ->append($aArray, $bArray)
     *      ->append($vo->sameValueAs($otherVo))
     *      ->append($aVo, $bVo, function ($aVo, $bVo) { return $aVo->sameValueAs($bVo); })
     *      ->append($aList, $bList, function ($aItem, $bItem) { return $aItem->sameValueAs($bItem); })
     *      ->equals();
     * </code>
     */
    public function append($a, $b = true, $comparatorCallback = null)
    {
        $this->comparisonList[] = array($a, $b, $comparatorCallback);
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
            $callback = $valuePair[2];

            if (! is_null($callback)) {

                if (! is_callable($callback)) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Provided callback of type %s is not callable!',
                            is_object($callback)? get_class($callback) : gettype($callback)
                        )
                    );
                }

                if (is_array($a) && is_array($b) && $this->isList($a) && $this->isList($b)) {
                    $result = $this->compareListsWithCallback($a, $b, $callback);
                } else {
                    $result = call_user_func($callback, $a, $b);
                }

                if (! is_bool($result)) {
                    throw new \RuntimeException(
                        sprintf(
                            'Provided callback of type %s does not return a boolean value!',
                            is_object($callback)? get_class($callback) : gettype($callback)
                        )
                    );
                }

                return $result;
            }
            
            if (! (($this->strict)? $a === $b : $a == $b) ) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * @param array $value
     * @return bool
     */
    protected function isList(array $value)
    {
        return (array_values($value) === $value);
    }

    /**
     * @param array $aList
     * @param array $bList
     * @param callable $callback
     *
     * @throws \InvalidArgumentException
     * @return bool
     */
    protected function compareListsWithCallback(array $aList, array $bList, $callback)
    {
        if (count($aList) != count($bList)) {
            return false;
        }

        foreach ($aList as $index => $value) {
            if (! call_user_func($callback, $value, $bList[$index])) {
                return false;
            }
        }

        return true;
    }
}
