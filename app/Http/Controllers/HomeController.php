<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\guardian;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Aabadawy\LaravelOdooIntegration\OdooConnection;
use App\Helpers\FeesCalculatorClass;
use App\Models\AcademicYear;
use App\Models\Contract;
use App\Models\Plan;
use App\Models\semester;
use App\Models\TransferRequest;
use App\Services\ContractPaymentstServices;
use App\Services\ContractServices;
use App\Services\NewContractServices;
use App\Services\RenewContractServices;
use App\Services\StudentContractServices;
use Illuminate\Support\Facades\DB;
use Ripcord\Providers\Laravel\Ripcord;
use Ripcord\Ripcord as RipcordRipcord;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test_Cache(Request $request)
    {
        // return $request->test[0];
        if ($request->has('test')) {
            # code...
            $user = User::find(2);
            Cache::put('user', $user, 600);
        } else {
            return cache::get('user');
        }
    }
}
