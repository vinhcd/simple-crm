<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Models\Data\Position;
use App\Module\User\Models\Data\User;
use App\Module\User\Models\Data\UserPosition;
use App\Module\User\Models\PositionRepository;
use App\Module\User\Models\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PositionEdit extends AbstractBlock
{
    /**
     * @var Position
     */
    private $position;

    /**
     * @var array
     */
    private $usersData;

    /**
     * GroupEdit constructor.
     * @param Position $position
     */
    public function __construct($position)
    {
        $this->position = $position;
    }

    /**
     * @return Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $position = $this->position;
        $position->setName($posts['name']);
        $position->setDescription($posts['description'] ?: '');

        $this->checkDuplicate();
        $repository = new PositionRepository();
        $repository->save($position);

        $this->updateUsers();
    }

    /**
     * @return Position[]
     */
    public function getAllPositions()
    {
        $positionRepo = new PositionRepository();

        return $positionRepo->getAll()->except($this->getPosition()->getId());
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
                ->with('positions')
                ->where('deleted', 0)
                ->get(['id', 'name', 'first_name', 'last_name']);
            foreach ($users as $user) {
                $this->usersData[$user->getId()] = [
                    'id' => $user->getId(),
                    'name' => $user->getFullName() ? $user->getFullName() : $user->getName(),
                ];
                if (in_array($this->position->getId(), array_map(function ($position) {
                    return $position['id'];
                }, $user->positions->toArray()))) {
                    $this->usersData[$user->getId()]['in_position'] = true;
                } else {
                    $this->usersData[$user->getId()]['in_position'] = false;
                }
            }
        }
        return $this->usersData;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updateUsers()
    {
        $posts = Request::post();

        DB::beginTransaction();
        $position = $this->getPosition();
        UserPosition::where('position_id', $position->getId())->delete();
        if (isset($posts['users'])) {
            foreach ($posts['users'] as $userId) {
                $userPosition = new UserPosition();
                $userPosition->setPositionId($position->getId());
                $userPosition->setUserId($userId);
                $userPosition->save();
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
        $repository = new PositionRepository();

        /* @var Position $exist */
        $exist = $repository->getBuilder()->where('name', $this->position->getName())->get()->first();
        if ($exist && ($exist->getId() != $this->position->getId())) throw new \Exception(__('Position already exist'));
    }
}
