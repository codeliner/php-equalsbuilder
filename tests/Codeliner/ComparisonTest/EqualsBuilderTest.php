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
use Codeliner\ComparisonTest\Mock\Address;

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
            EqualsBuilder::create()
                ->append('equals', 'equals')
                ->equals()
            , "String comparison failed"
        );
        
        $this->assertTrue(
            EqualsBuilder::create()
                ->append(1, '1')
                ->equals()
            , "String cast to Integer comparison failed"
        );
        
        $this->assertTrue(
            EqualsBuilder::create()
                ->append('equals', 'equals')
                ->append(1, 1)
                ->equals()
            , "Multi append comparison failed"
        );
        
        $this->assertFalse(
            EqualsBuilder::create()
                ->append('equals', 'other value')
                ->equals()
            , "Different value comparison failed"
        );
        
        $this->assertFalse(
            EqualsBuilder::create()
                ->append('equals', 'equals')
                ->append(1, 2)
                ->equals()
            , "Multi append with diffrent value comparison failed"
        );
    }
    
    public function testStrict()
    {
        $this->assertFalse(
            EqualsBuilder::create()
                ->append(1, '1')
                ->strict()
                ->equals()
            , "Strict comparison failed"
        );        
    }

    public function testItUsesTrueAsSecondParameterIfOnlyOneIsGiven()
    {
        $address = new Address('Hauptstrasse', '1', '10115', 'Berlin');
        $sameAddress = clone $address;
        $otherAddress = new Address('Postweg', '2', '12345', 'Testhausen');

        $this->assertTrue(
            EqualsBuilder::create()
                ->append($address->sameValueAs($sameAddress))
                ->equals()
        );

        $this->assertFalse(
            EqualsBuilder::create()
                ->append($address->sameValueAs($otherAddress))
                ->equals()
        );
    }

    public function testItUsesCallbackToCompareGivenValues()
    {
        $address = new Address('Hauptstrasse', '1', '10115', 'Berlin');
        $equalAddress = new Address('Hauptstrasse', '1', '10115', 'Berlin');

        $this->assertFalse(
            EqualsBuilder::create()
                ->append($address, $equalAddress)
                ->strict()
                ->equals()
        );

        $this->assertTrue(
            EqualsBuilder::create()
                ->append($address, $equalAddress, function (Address $a, Address $b) {
                    return $a->sameValueAs($b);
                })
                ->strict()
                ->equals()
        );
    }

    public function testItUsesCallbackToCompareLists()
    {
        $address = new Address('Hauptstrasse', '1', '10115', 'Berlin');

        $aList = array(
            new Address('Hauptstrasse', '1', '10115', 'Berlin'),
            new Address('Postweg', '2', '12345', 'Testhausen')
        );

        $bList = array(
            new Address('Hauptstrasse', '1', '10115', 'Berlin'),
            new Address('Postweg', '2', '12345', 'Testhausen')
        );

        $this->assertTrue(
            EqualsBuilder::create()
                ->append($aList, $bList, function(Address $a, Address $b) {
                    return $a->sameValueAs($b);
                })
                ->equals()
        );
    }

    public function testItComparesItemCountOfTheGivenListsBeforeUsingCallback()
    {
        $callbackUsed = false;

        $aList = array(
            new Address('Hauptstrasse', '1', '10115', 'Berlin'),
            new Address('Postweg', '2', '12345', 'Testhausen')
        );

        $bList = array(
            new Address('Hauptstrasse', '1', '10115', 'Berlin'),
            new Address('Postweg', '2', '12345', 'Testhausen'),
            new Address('Postweg', '2', '12345', 'Testhausen')
        );

        $this->assertFalse(
            EqualsBuilder::create()
                ->append($aList, $bList, function(Address $a, Address $b) use (&$callbackUsed) {
                    $callbackUsed = true;
                    return $a->sameValueAs($b);
                })
                ->equals()
        );

        $this->assertFalse($callbackUsed);
    }

}
