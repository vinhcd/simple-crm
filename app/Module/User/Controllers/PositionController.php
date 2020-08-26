<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\PositionRepositoryInterface;
use App\Module\User\Block\PositionEdit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PositionController extends Controller
{
    /**
     * @var PositionRepositoryInterface
     */
    private $repository;

    /**
     * PositionController constructor.
     * @param PositionRepositoryInterface $repository
     */
    public function __construct(PositionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list()
    {
        $positions = $this->repository->getAll();

        return view('user::position_list', ['positions' => $positions]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $position = $id ? $this->repository->getById($id) : $this->repository->create();

        $positionEditBlock = new PositionEdit($position);

        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
            ]);
            try {
                $positionEditBlock->update();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('Position :position has been updated!', ['position' => $position->getName()]));

            return redirect()->route('user_position_create_update', ['id' => $position->getId()]);
        }
        return view('user::position_create', ['positionEditBlock' => $positionEditBlock]);
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $position = $this->repository->getById($id);
        try {
            $this->repository->delete($position);
        } catch (\Exception $e) {
            return redirect()->route('user_position_list')->withErrors($e->getMessage());
        }
        session()->flash('success', __('Position :position has been removed!', ['position' => $position->getName()]));

        return redirect()->route('user_position_list');
    }
}
