<?php

namespace App\Module\Admin\Api\Data;

interface PlanInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return float
     */
    public function getPrice();

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price);

    /**
     * @return integer
     */
    public function getMaxStaff();

    /**
     * @param integer $maxStaff
     * @return $this
     */
    public function setMaxStaff($maxStaff);

    /**
     * @return integer
     */
    public function getDaysOfTrial();

    /**
     * @param integer $trialDays
     * @return $this
     */
    public function setDaysOfTrial($trialDays);
}
