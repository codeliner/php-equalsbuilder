<?php
/*
 * This file is part of the codeliner/php-equalsbuilder package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Codeliner\ComparisonTest;

use Codeliner\Comparison\EqualsBuilder;
/**
 * Class EqualsBuilderTest
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class EqualsBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $this->assertTrue(
            EqualsBuilder::getInstance()
                ->append('equals', 'equals')
                ->equals()
            , "String comparison failed"
        );
        
        $this->assertTrue(
            EqualsBuilder::getInstance()
                ->append(1, '1')
                ->equals()
            , "String cast to Integer comparison failed"
        );
        
        $this->assertTrue(
            EqualsBuilder::getInstance()
                ->append('equals', 'equals')
                ->append(1, 1)
                ->equals()
            , "Multi append comparison failed"
        );
        
        $this->assertFalse(
            EqualsBuilder::getInstance()
                ->append('equals', 'other value')
                ->equals()
            , "Different value comparison failed"
        );
        
        $this->assertFalse(
            EqualsBuilder::getInstance()
                ->append('equals', 'equals')
                ->append(1, 2)
                ->equals()
            , "Multi append with diffrent value comparison failed"
        );
    }
    
    public function testStrict()
    {
        $this->assertFalse(
            EqualsBuilder::getInstance()
                ->append(1, '1')
                ->strict()
                ->equals()
            , "Strict comparison failed"
        );
    }
}
