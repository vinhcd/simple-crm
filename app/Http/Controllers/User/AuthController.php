<?php

namespace App\Http\Controllers\User;

use App\Module\Admin\Api\OrganizationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends \App\Http\Controllers\Controller
{
    /**
     * @var OrganizationRepositoryInterface
     */
    private $organizationRepository;

    /**
     * AuthController constructor.
     * @param OrganizationRepositoryInterface $organizationRepository
     */
    public function __construct(OrganizationRepositoryInterface $organizationRepository)
    {
        $this->organizationRepository = $organizationRepository;
    }

    public function login(Request $request)
    {
        if ($post = $request->post()) {
            try {
                $organization = $this->organizationRepository->getByUuid($post['organization_uuid']);
                $db = $organization->getDatabase();
                Config::set('database.connections.organization', $db->getOrganizationDBConnection());
                DB::setDefaultConnection('organization');
                DB::purge('mysql');
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    Session::put('database', $db->dbname);
                    return redirect()->intended('/');
                }
            } catch (\Exception $e) {
                return redirect()->intended('/login');
            }
        }
        return view('user.login');
    }
}
