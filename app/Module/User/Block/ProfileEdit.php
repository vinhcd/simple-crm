<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Models\Data\User;
use App\Module\User\Models\UserRepository;
use App\Module\User\Support\PasswordGenerator;
use Illuminate\Support\Facades\Auth;

class ProfileEdit extends AbstractBlock
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserEdit constructor.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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
        $userData['sex'] = $info->getSex();
        $userData['personal_email'] = $info->getPersonalEmail();
        $userData['contact_phone'] = $info->getContactPhone();
        $userData['contact_email'] = $info->getContactEmail();
        $userData['address1'] = $info->getAddress1();
        $userData['address2'] = $info->getAddress2();
        $userData['description'] = $info->getDescription();

        return $userData;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function updateUser()
    {
        /* @var \Illuminate\Http\Request $request */
        $request = request();

        $user = $this->user;
        $user->setFirstName($request->post('first_name') ?: '');
        $user->setLastName($request->post('last_name') ?: '');

        $info = $user->getInfo();
        $info->setPhone($request->post('phone') ?: '');
        $info->setSex($request->post('sex') ?: '');
        $info->setPersonalEmail($request->post('personal_email') ?: '');
        $info->setContactPhone($request->post('contact_phone') ?: '');
        $info->setContactEmail($request->post('contact_email') ?: '');
        $info->setAddress1($request->post('address1') ?: '');
        $info->setAddress2($request->post('address2') ?: '');
        $info->setDescription($request->post('description') ?: '');

        $repository = new UserRepository();
        $repository->save($user);
    }
}
