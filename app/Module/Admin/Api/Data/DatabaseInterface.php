<?php

namespace App\Module\Admin\Api\Data;

interface DatabaseInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     * @return $this
     */
    public function getById($id);

    /**
     * @return array
     */
    public function getConnection();

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
    public function getHost();

    /**
     * @param string $host
     * @return $this
     */
    public function setHost($host);

    /**
     * @return integer
     */
    public function getPort();

    /**
     * @param integer $port
     * @return $this
     */
    public function setPort($port);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $text
     * @return $this
     */
    public function setComment($text);

    /**
     * @param array $options
     * @return $this
     */
    public function save(array $options = []);
}
