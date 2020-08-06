<?php

namespace App\Module\Admin\Api\Data;

interface OrganizationInterface
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
     * @return string
     */
    public function getUuid();

    /**
     * @param string $uuid
     * @return $this
     */
    public function setUuid($uuid);

    /**
     * @return string
     */
    public function getPhone();

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getTax();

    /**
     * @param string $tax
     * @return $this
     */
    public function setTax($tax);

    /**
     * @return string
     */
    public function getAddress();

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress($address);

    /**
     * @return string
     */
    public function getRegisterDate();

    /**
     * @param string $date
     * @return $this
     */
    public function setRegisterDate($date);

    /**
     * @return integer
     */
    public function getDatabase();

    /**
     * @param integer $db
     * @return $this
     */
    public function setDatabase($db);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $text
     * @return $this
     */
    public function setComment($text);
}
