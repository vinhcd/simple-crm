<?php

namespace App\Module\Acl\Api;

use App\Module\User\Api\Data\UserInterface;

interface AclCheckerInterface
{
    /**
     * @return $this
     */
    public function reset();

    /**
     * @param UserInterface $user
     * @return $this
     */
    public function setUser($user);

    /**
     * @param string $resource
     * @return $this
     */
    public function addResource($resource);

    /**
     * @param array $resources
     * @return $this
     */
    public function setResources($resources);

    /**
     * @return bool
     */
    public function canRead();

    /**
     * @return bool
     */
    public function canWrite();
}
