<?php
namespace Nitsan\NsGoogleMap\Domain\Model;

/***
 *
 * This file is part of the "[Nitsan] Google Map" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017
 *
 ***/

/**
 * Address
 */
class Address extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * title
     *
     * @var string
     */
    protected $title = '';

    /**
     * address
     *
     * @var string
     */
    protected $address = '';

    /**
     * infocontent
     *
     * @var string
     */
    protected $infocontent = '';

    /**
     * closebyclick
     *
     * @var bool
     */
    protected $closebyclick = false;

    /**
     * openbyclick
     *
     * @var bool
     */
    protected $openbyclick = false;

    /**
     * opened
     *
     * @var bool
     */
    protected $opened = false;

    /**
     * latitude
     *
     * @var string
     */
    protected $latitude = '';

    /**
     * longitude
     *
     * @var string
     */
    protected $longitude = '';

    /**
     * map
     *
     * @var string
     */
    protected $map = '';

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Returns the address
     *
     * @return string $address
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Sets the address
     *
     * @param string $address
     * @return void
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns the infocontent
     *
     * @return string $infocontent
     */
    public function getInfocontent(): string
    {
        return $this->infocontent;
    }

    /**
     * Sets the infocontent
     *
     * @param string $infocontent
     * @return void
     */
    public function setInfocontent($infocontent)
    {
        $this->infocontent = $infocontent;
    }

    /**
     * Returns the closebyclick
     *
     * @return bool $closebyclick
     */
    public function getClosebyclick(): bool
    {
        return $this->closebyclick;
    }

    /**
     * Sets the closebyclick
     *
     * @param bool $closebyclick
     * @return void
     */
    public function setClosebyclick($closebyclick)
    {
        $this->closebyclick = $closebyclick;
    }

    /**
     * Returns the boolean state of closebyclick
     *
     * @return bool
     */
    public function isClosebyclick(): bool
    {
        return $this->closebyclick;
    }

    /**
     * Returns the openbyclick
     *
     * @return bool $openbyclick
     */
    public function getOpenbyclick(): bool
    {
        return $this->openbyclick;
    }

    /**
     * Sets the openbyclick
     *
     * @param bool $openbyclick
     * @return void
     */
    public function setOpenbyclick($openbyclick)
    {
        $this->openbyclick = $openbyclick;
    }

    /**
     * Returns the boolean state of openbyclick
     *
     * @return bool
     */
    public function isOpenbyclick(): bool
    {
        return $this->openbyclick;
    }

    /**
     * Returns the opened
     *
     * @return string $opened
     */
    public function getOpened(): string
    {
        return $this->opened;
    }

    /**
     * Sets the opened
     *
     * @param string $opened
     * @return void
     */
    public function setOpened($opened)
    {
        $this->opened = $opened;
    }

    /**
     * Returns the latitude
     *
     * @return string $latitude
     */
    public function getLatitude(): string
    {
        return $this->latitude;
    }

    /**
     * Sets the latitude
     *
     * @param string $latitude
     * @return void
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Returns the longitude
     *
     * @return string $longitude
     */
    public function getLongitude(): string
    {
        return $this->longitude;
    }

    /**
     * Sets the longitude
     *
     * @param string $longitude
     * @return void
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Returns the map
     *
     * @return string $map
     */
    public function getMap(): string
    {
        return $this->map;
    }

    /**
     * Sets the map
     *
     * @param string $map
     * @return void
     */
    public function setMap($map)
    {
        $this->map = $map;
    }
}
