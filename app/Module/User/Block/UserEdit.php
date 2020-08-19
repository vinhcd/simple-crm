<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Models\Data\User;
use App\Module\User\Models\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class UserEdit extends AbstractBlock
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserEdit constructor.
     * @param UserInterface $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function getUserData()
    {
        $user = $this->user;
        $userData['id'] = $user->getId();
        $userData['name'] = $user->getName();
        $userData['email'] = $user->getEmail();
        $userData['first_name'] = $user->getFirstName();
        $userData['last_name'] = $user->getLastName();

        $info = $user->getInfo();
        $userData['phone'] = $info->getPhone();
        $userData['birthday'] = $info->getBirthday();
        $userData['address'] = $info->getAddress();
        $userData['description'] = $info->getDescription();

        return $userData;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function updateUser()
    {
        $posts = Request::post();

        $user = $this->user;
        $user->setName($posts['name']);
        $user->setFirstName($posts['first_name']);
        $user->setLastName($posts['last_name']);
        $user->setEmail($posts['email']);
        if (empty($user->getId())) {
            $user->setPassword(
                Hash::make(substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10))
            );
        }
        $info = $user->getInfo();
        $info->setPhone($posts['phone']);
        $info->setBirthday($posts['birthday']);
        $info->setAddress($posts['address']);
        $info->setDescription($posts['description']);

        $userRepository = new UserRepository();
        $userRepository->save($user);
        $info->setUserId($user->getId());
        $info->save();
    }
}
