<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Models\Data\User;
use App\Module\User\Models\Data\UserDepartment;
use App\Module\User\Models\DepartmentRepository;
use App\Module\User\Models\UserRepository;
use App\Module\User\Support\PasswordGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserEdit extends AbstractBlock
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserEdit constructor.
     * @param User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $userData['birthday'] = $info->getBirthday();
        $userData['sex'] = $info->getSex();
        $userData['personal_email'] = $info->getPersonalEmail();
        $userData['address'] = $info->getAddress();
        $userData['description'] = $info->getDescription();

        $userData['departments'] = [];
        $userDepartments = $user->getDepartments();
        foreach ($userDepartments as $userDepartment) {
            $userData['departments'][] = $userDepartment->getId();
        }
        return $userData;
    }

    /**
     * @return array
     */
    public function getDepartments()
    {
        $allDeparts = [];

        $departRepo = new DepartmentRepository();
        $departs = $departRepo->getAll();
        foreach ($departs as $depart) {
            $allDeparts[$depart->getId()]['id'] = $depart->getId();
            $allDeparts[$depart->getId()]['name'] = $depart->getDisplayName();
        }
        return $allDeparts;
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
        $user->setEmail($posts['email']);
        $user->setFirstName($posts['first_name'] ?: '');
        $user->setLastName($posts['last_name'] ?: '');
        if (empty($user->getId())) {
            $user->setPassword(PasswordGenerator::generate());
        }
        $info = $user->getInfo();
        $info->setPhone($posts['phone'] ?: '');
        $info->setBirthday($posts['birthday'] ?: '');
        $info->setSex($posts['sex'] ?: '');
        $info->setPersonalEmail($posts['personal_email'] ?: '');
        $info->setAddress($posts['address'] ?: '');
        $info->setDescription($posts['description'] ?: '');

        DB::beginTransaction();
        if (!isset($posts['departments'])) {
            UserDepartment::where('user_id', $user->getId())->delete();
        } elseif (is_array($posts['departments'])) {
            foreach ($posts['departments'] as $department) {
                $userDepartment = new UserDepartment();
                $userDepartment->setDepartmentId($department);
                $userDepartment->setUserId($user->getId());
                $userDepartment->save();
            }
        }
        DB::commit();

        $this->checkDuplicate();
        $repository = new UserRepository();
        $repository->save($user);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function checkDuplicate()
    {
        $repository = new UserRepository();

        $user = $this->user;
        /* @var User $exist */
        $exist = $repository->getBuilder()
            ->where('name', $user->getName())
            ->orWhere('email', $user->getEmail())
            ->get()->first();
        if ($exist && ($exist->getId() != $user->getId())) throw new \Exception(__('User already exist'));
    }
}
