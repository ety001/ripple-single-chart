<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ripple
 *
 * @ORM\Table(name="ripple")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RippleRepository")
 */
class Ripple
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="xrp", type="string", length=255)
     */
    private $xrp;

    /**
     * @var string
     *
     * @ORM\Column(name="cny", type="string", length=255)
     */
    private $cny;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=255)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="logtime", type="integer")
     */
    private $logtime;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set xrp
     *
     * @param string $xrp
     *
     * @return Ripple
     */
    public function setXrp($xrp)
    {
        $this->xrp = $xrp;

        return $this;
    }

    /**
     * Get xrp
     *
     * @return string
     */
    public function getXrp()
    {
        return $this->xrp;
    }

    /**
     * Set cny
     *
     * @param string $cny
     *
     * @return Ripple
     */
    public function setCny($cny)
    {
        $this->cny = $cny;

        return $this;
    }

    /**
     * Get cny
     *
     * @return string
     */
    public function getCny()
    {
        return $this->cny;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Ripple
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set logtime
     *
     * @param integer $logtime
     *
     * @return Ripple
     */
    public function setLogtime($logtime)
    {
        $this->logtime = $logtime;

        return $this;
    }

    /**
     * Get logtime
     *
     * @return int
     */
    public function getLogtime()
    {
        return $this->logtime;
    }
}

