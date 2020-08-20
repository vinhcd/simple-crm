<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Models\Data\User;
use App\Module\User\Models\UserRepository;
use Illuminate\Support\Facades\Request;

class GroupEdit extends AbstractBlock
{
    /**
     * @var GroupInterface
     */
    private $group;

    /**
     * @var array
     */
    private $usersData;

    /**
     * GroupEdit constructor.
     * @param GroupInterface $group
     */
    public function __construct($group)
    {
        $this->group = $group;
    }

    /**
     * @return GroupInterface
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return void
     */
    public function updateGroup()
    {
        $posts = Request::post();

        $group = $this->group;
        $group->setName($posts['name']);
        $group->setDisplayName($posts['display_name']);
        if ($posts['priority']) $group->setPriority($posts['priority']);
        if ($posts['description']) $group->setDescription($posts['description']);
    }

    /**
     * @return array
     */
    public function getUsersData()
    {
        if (!$this->usersData) {
            $userRepository = new UserRepository();
            /* @var User[] $users */
            $users = $userRepository->getBuilder()
                ->with('groups')
                ->where('deleted', 0)
                ->get(['id', 'name', 'first_name', 'last_name']);
            foreach ($users as $user) {
                $this->usersData[$user->getId()] = [
                    'id' => $user->getId(),
                    'name' => $user->getFullName(),
                ];
                if (in_array($this->group->getId(), array_map(function ($group) {
                    return $group['id'];
                }, $user->groups->toArray()))) {
                    $this->usersData[$user->getId()]['ingroup'] = true;
                } else {
                    $this->usersData[$user->getId()]['ingroup'] = false;
                }
            }
        }
        return $this->usersData;
    }
}
