<?php

namespace App\Http\Controllers;

use App\Module\Admin\Models\Data\Database;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        if (Session::has('database')) {
            /* @var Database $db */
            $db = Database::find(Session::get('database'));
            Config::set('database.connections.newconnection', $db->getConnection());
            DB::setDefaultConnection('newconnection');
        }
    }
}
