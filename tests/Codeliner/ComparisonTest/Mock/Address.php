<?php
/**
 * This file is part of SxVehicle
 * Date: 6/13/14 - 5:04 PM
 * (c) Sixt GmbH & Co. Autovermietung KG
 */
namespace Codeliner\ComparisonTest\Mock;

/**
 * Class Address
 *
 * @package Codeliner\ComparisonTest\Mock
 * @author Alexander Miertsch <alexander.miertsch.extern@sixt.com>
 * @author Christos Fousekis <christos.fousekis.extern@sixt.com>
 */
class Address 
{
    private $street;

    private $streetNumber;

    private $zip;

    private $city;

    public function __construct($street, $streetNumber, $zip, $city)
    {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->zip = $zip;
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getStreetNumber()
    {
        return $this->streetNumber;
    }

    /**
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param Address $other
     * @return bool
     */
    public function sameValueAs(Address $other)
    {
        return $this->getStreet() == $other->getStreet()
            && $this->getStreetNumber() == $other->getStreetNumber()
            && $this->getZip() == $other->getZip()
            && $this->getCity() == $other->getCity();
    }
} 