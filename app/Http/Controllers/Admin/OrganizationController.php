<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Module\Admin\Api\OrganizationRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * @var OrganizationRepositoryInterface
     */
    protected $repository;

    /**
     * OrganizationController constructor.
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(OrganizationRepositoryInterface $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * @return View
     */
    public function index()
    {
        $organizations = $this->repository->getAll();

        return view('admin.organization_list', ['organizations' => $organizations]);
    }

    /**
     * @return RedirectResponse|View
     */
    public function create(Request $request)
    {
        if ($posts = $request->post()) {
            \StaticLogger::log($posts);
            $org = $this->repository->create();
            $org->name = $posts['name'];
            $org->phone_number = $posts['phone_number'];
            $org->tax_number = $posts['tax_number'];
            $org->address = $posts['address'];
            $org->register_date = Date::createFromFormat('Y-m-d', $posts['register_date'])->toDateString();
            $org->plan_id = $posts['plan_id'];
            $org->comment = $posts['comment'];

            $this->repository->save($org);

            return redirect()->route('admin_organization_list');
        }
        return view('admin.organization_create');
    }
}
