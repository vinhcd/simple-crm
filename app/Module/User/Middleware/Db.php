<?php

namespace App\Module\User\Middleware;

use App\Module\Admin\Api\DatabaseRepositoryInterface;
use App\Module\Admin\Models\Data\Database;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class Db
{
    /**
     * @var DatabaseRepositoryInterface
     */
    private $databaseRepository;

    /**
     * Db constructor.
     * @param DatabaseRepositoryInterface $databaseRepository
     */
    public function __construct(DatabaseRepositoryInterface $databaseRepository)
    {
        $this->databaseRepository = $databaseRepository;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('database')) {
            /* @var Database $db */
            try {
                $db = $this->databaseRepository->getByDbName(Session::get('database'));
                Config::set('database.connections.organization', $db->getOrganizationDBConnection());
                \Illuminate\Support\Facades\DB::setDefaultConnection('organization');
                \Illuminate\Support\Facades\DB::purge('mysql');
            } catch (\Exception $e) {
                Session::remove('database');
            }
        }
        return $next($request);
    }
}
