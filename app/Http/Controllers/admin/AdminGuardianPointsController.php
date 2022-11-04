<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\GuardianPoints;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminGuardianPointsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:guardians-list|guardians-create|guardians-edit|guardians-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:guardians-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:guardians-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:guardians-delete', ['only' => ['destroy']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($guardian)
    {
        $guardianPoints = GuardianPoints::select('guardian_points.*','academic_years.year_name','periods.period_name')->where('guardian_id', $guardian)
        ->leftJoin('academic_years','academic_years.id','guardian_points.academic_year_id')
        ->leftJoin('periods','periods.id','guardian_points.period_id')
        ->get();

        $user = User::select('users.id', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as guardian_name'))->whereHas('guardian')->findOrFail($guardian);

        return view('admin.users.guardian.points.index', compact('guardianPoints','user'));
    }

}
