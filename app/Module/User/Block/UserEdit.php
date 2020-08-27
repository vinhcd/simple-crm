<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Models\Data\User;
use App\Module\User\Models\Data\UserDepartment;
use App\Module\User\Models\Data\UserGroup;
use App\Module\User\Models\Data\UserPosition;
use App\Module\User\Models\DepartmentRepository;
use App\Module\User\Models\GroupRepository;
use App\Module\User\Models\PositionRepository;
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
        $userData['uuid'] = $info->getUuid();
        $userData['phone'] = $info->getPhone();
        $userData['birthday'] = $info->getBirthday();
        $userData['sex'] = $info->getSex();
        $userData['personal_email'] = $info->getPersonalEmail();
        $userData['contact_phone'] = $info->getContactPhone();
        $userData['contact_email'] = $info->getContactEmail();
        $userData['address1'] = $info->getAddress1();
        $userData['address2'] = $info->getAddress2();
        $userData['description'] = $info->getDescription();

        $userData['departments'] = [];
        foreach ($user->getDepartments() as $department) {
            $userData['departments'][] = $department->getId();
        }

        $userData['groups'] = [];
        foreach ($user->getGroups() as $group) {
            $userData['groups'][] = $group->getId();
        }

        $userData['positions'] = [];
        foreach ($user->getPositions() as $position) {
            $userData['positions'][] = $position->getId();
        }

        return $userData;
    }

    /**
     * @return array
     */
    public function getGroups()
    {
        $allGroups = [];

        $groupRepo = new GroupRepository();
        $groups = $groupRepo->getAll();
        foreach ($groups as $group) {
            $allGroups[$group->getId()]['id'] = $group->getId();
            $allGroups[$group->getId()]['name'] = $group->getDisplayName();
        }
        return $allGroups;
    }

    /**
     * @return array
     */
    public function getPositions()
    {
        $allPositions = [];

        $repo = new PositionRepository();
        $positions = $repo->getAll();
        foreach ($positions as $position) {
            $allPositions[$position->getId()]['id'] = $position->getId();
            $allPositions[$position->getId()]['name'] = $position->getName();
        }
        return $allPositions;
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
        /* @var \Illuminate\Http\Request $request */
        $request = request();

        $user = $this->user;
        $user->setName($request->post('name'));
        $user->setEmail($request->post('email'));
        $user->setFirstName($request->post('first_name') ?: '');
        $user->setLastName($request->post('last_name') ?: '');
        if (empty($user->getId())) {
            $user->setPassword(PasswordGenerator::generate());
        }
        $info = $user->getInfo();
        $info->setUuid($request->post('uuid') ?: '');
        $info->setPhone($request->post('phone') ?: '');
        $info->setBirthday($request->post('birthday') ?: '');
        $info->setSex($request->post('sex') ?: '');
        $info->setPersonalEmail($request->post('personal_email') ?: '');
        $info->setContactPhone($request->post('contact_phone') ?: '');
        $info->setContactEmail($request->post('contact_email') ?: '');
        $info->setAddress1($request->post('address1') ?: '');
        $info->setAddress2($request->post('address2') ?: '');
        $info->setDescription($request->post('description') ?: '');

        $this->checkDuplicate();
        $repository = new UserRepository();
        $repository->save($user);

        $this->updateGroups();
        $this->updatePositions();
        $this->updateDepartments();
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updatePositions()
    {
        $posts = Request::post();

        DB::beginTransaction();
        UserPosition::where('user_id', $this->user->getId())->delete();
        if (isset($posts['positions'])) {
            foreach ($posts['positions'] as $id) {
                $userPosition = new UserPosition();
                $userPosition->setPositionId($id);
                $userPosition->setUserId($this->user->getId());
                $userPosition->save();
            }
        }
        DB::commit();
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updateGroups()
    {
        $posts = Request::post();

        DB::beginTransaction();
        UserGroup::where('user_id', $this->user->getId())->delete();
        if (isset($posts['groups'])) {
            foreach ($posts['groups'] as $id) {
                $userGroup = new UserGroup();
                $userGroup->setGroupId($id);
                $userGroup->setUserId($this->user->getId());
                $userGroup->save();
            }
        }
        DB::commit();
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updateDepartments()
    {
        $posts = Request::post();

        DB::beginTransaction();
        UserDepartment::where('user_id', $this->user->getId())->delete();
        if (isset($posts['departments'])) {
            foreach ($posts['departments'] as $department) {
                $userDepartment = new UserDepartment();
                $userDepartment->setDepartmentId($department);
                $userDepartment->setUserId($this->user->getId());
                $userDepartment->save();
            }
        }
        DB::commit();
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
