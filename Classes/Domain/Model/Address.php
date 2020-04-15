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
     * maplink
     *
     * @var bool
     */
    protected $maplink = false;

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
     * markerImage
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade remove
     */
    protected $markerImage = null;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
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
    public function getAddress()
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
    public function getInfocontent()
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
     * Returns the maplink
     *
     * @return bool $maplink
     */
    public function getMaplink()
    {
        return $this->maplink;
    }

    /**
     * Sets the maplink
     *
     * @param bool $maplink
     * @return void
     */
    public function setMaplink($maplink)
    {
        $this->maplink = $maplink;
    }

    /**
     * Returns the closebyclick
     *
     * @return bool $closebyclick
     */
    public function getClosebyclick()
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
    public function isClosebyclick()
    {
        return $this->closebyclick;
    }

    /**
     * Returns the openbyclick
     *
     * @return bool $openbyclick
     */
    public function getOpenbyclick()
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
    public function isOpenbyclick()
    {
        return $this->openbyclick;
    }

    /**
     * Returns the opened
     *
     * @return string $opened
     */
    public function getOpened()
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
    public function getLatitude()
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
    public function getLongitude()
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
    public function getMap()
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

    /**
     * Returns the markerImage
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference markerImage
     */
    public function getMarkerImage()
    {
        return $this->markerImage;
    }

    /**
     * Sets the markerImage
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $markerImage
     * @return void
     */
    public function setMarkerImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $markerImage)
    {
        $this->markerImage = $markerImage;
    }
}
