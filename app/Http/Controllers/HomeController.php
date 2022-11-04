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

    // public function test(Request $request)
    // {
    //     $admins = [
    //         '326ba5ba-50f2-474f-9b6f-3b4473550f78', '65173c72-8af7-42c0-82b3-d9f297d229c0', '986c91cf-3176-4b34-85db-68228c93309c', 'b1f06101-b0f2-4de4-819f-5eb155953fa3', 'cd34170d-788c-4f25-8367-944ae45e4da7', '16641976-fc3e-445d-86dd-02092be6f7a9', '71d23bbb-b884-443d-90d8-f05308477dab', 'bbcf3b41-d68e-4cb1-bb13-8340f50816c1', '20c9e0b6-7944-471e-96cc-86ca29996a47', '36683102-2781-4841-81d7-bf2448c3c497', 'b63c11b6-b016-4313-8db2-f33a91c9c4a9', '6ce2fe34-23d4-44d9-b184-902802be5874', 'f035696c-be9e-4cb5-8bb0-3bba9cb2fe17', '420a004a-cb8b-4faa-a6cf-f2616ecb55ec', '443caed2-e1cf-419c-8ac0-d0e7cab128ce', '5af01279-81fa-4863-a681-3c9beed20bd6', '5da26e48-0d74-43ea-9bd8-571a326c7996', 'a3ced956-d5ca-4553-b32a-ac1e97ca9260', 'b206f920-cabb-47e6-9b8b-8ef07ad8a789', 'ed98f579-08a6-4ea5-ad19-54fc0af3391f', '047d77c9-0813-4a13-a4e4-16d8ba4eea0f', '119eb316-df48-40db-b7e2-1aad799fd212', '146c75e5-a12d-4e68-a5b3-59d32cb61dac', '1a6cdadb-22e4-4e7b-ae4d-76844c5976d9', '2be25e31-fe32-47ca-8f81-7ad70e048cdc', '312280a4-75b4-4102-8232-d62cafd49372', '3b62dfe7-e5d4-4138-a1cb-7c7138a06b3f', '42a2baf3-a963-44f9-8628-ef016be6127a', '4c6d0047-7cdb-415b-a55c-b5b96d725987', '53abc43b-dc2c-4ff4-b696-1ef226cd603a', '597bc6c0-45e6-4dd4-9831-bef31c146a6e', '6b080e1e-975f-4d25-b7e8-c5a59f5a5957', '755362aa-0e6a-4b02-a759-89a71f95e8fc', '7b1eba71-2631-4939-9ea5-e59040d41c0c', '8f0b0865-7196-4500-95a4-b85444ac9424', 'ae5816d9-82fd-412e-95ad-634fc3f1bba7', 'c06615e1-fedf-4972-beac-4b33d7a6bbf1', 'd1c59a1a-7eb2-4b5c-91cd-08daa2bd53fb', 'fb5b66d1-7072-4c30-94aa-1ec60bbab98b'
    //     ];
    //     $users = DB::table('old_users')->where('done', 0)->whereNotIn('old_users.id', $admins)
    //         ->leftjoin('old_genders', 'old_genders.id', 'old_users.id')
    //         ->limit(200)
    //         ->get();

    //     foreach ($users as $user) {
    //         $names = explode(' ', $user->FullName);
    //         $first_name = 'empty';
    //         $last_name = 'empty';

    //         if (isset($names[0])) {
    //             $first_name = $names[0];
    //         }

    //         if (isset($names[1])) {
    //             $last_name = $names[1];
    //         }

    //         $new_user = User::create([
    //             'first_name' => $first_name,
    //             'last_name' => $last_name,
    //             'email' => $user->Email,
    //             'phone' => str_replace('966', '', $user->PhoneNumber),
    //             'country_id' =>  1,
    //             'password' => Hash::make($user->UserName)
    //         ]);

    //         // users
    //         if ($new_user) {
    //             guardian::create([
    //                 'guardian_id' => $new_user->id,
    //                 'nationality_id' => 1,
    //                 'address' => $user->Address,
    //                 'category_id' => 1,
    //                 'active' => $user->IsEnabled,
    //             ]);
    //         }

    //         DB::table('old_users')->where('id', $user->id)->update([
    //             'done' => 1
    //         ]);

    //         echo $user->id . '<br>';
    //     }
    // }


    public function test_discount(Request $request)
    {

//         // connect to server 
//         $db = config("odoo_configuration")['db'];
//         $username = config("odoo_configuration")['username'];
//         $password = config("odoo_configuration")['password'];
//         $url = config("odoo_configuration")['url'];

//         $plan = Plan::find(2);
//         $year = AcademicYear::find(3);
//         // return currentPeriod($year);
//         $level = 17;
//         $period = 9;
//         $category = 2;
//         $nationality = 2;
//         $req = TransferRequest::find(850);
//         $fees = new FeesCalculatorClass($plan, $level, $period, $category, $nationality, $year);

// return $fees->getContractPayments()->getPayments();
//         // return $this->contractServices($req->contract_id,$req ,$plan, $level, $period, $category, $nationality, $year, $user = null)->getDiscountSchool();


//         return  Carbon::createFromFormat('Y-m-d', sprintf('%s-%s-%s', Carbon::now()->year, Carbon::now()->month, 25))->format('Y-m-d');
        //    $contracts = Contract::whereBetween('id',[3695,40000])->where('academic_year_id',3)->where('total_fees', '<', 5000)->get();
        //     foreach ($contracts as $contract) {
        //         # code...
        //         echo  $contract->id . ' - -' . $contract->student_id . ' - -' . $contract->total_fees;
        //         $contract->update_total_payments();
        //         echo  ' - -' .$contract->total_fees . '<br> ';
        //     }
        //     return;
        //     // $old_users = DB::select('old_users')->whereIn('')
        //     $ids = User::leftjoin('guardians', 'guardians.guardian_id', 'users.id')
        //         ->where(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'LIKE', 'مسعد%')->where('id', '<=', 1804)->pluck('id')->toArray();

        //     $users = guardian::whereIn('guardian_id', $ids)->pluck('old_id')->toArray();

        //  $old_users = DB::table('old_users')->select('old_users.*')->whereIn('id', $users)->get();

        //  foreach ($old_users as $old_user) {
        //     $gur = guardian::where('old_id',$old_user->id)->first();
        //     $new_user = User::find($gur->guardian_id);
        //     $new_user->first_name = explode(' ',$old_user->FullName)[0];
        //     $new_user->save();
        //     echo $new_user->first_name . '  =  old : ' . explode(' ',$old_user->FullName)[0] . '<br/>';
        //  }
        //     // return $users;

        //     return;

        $db = config("odoo_configuration")['db'];
        $username = config("odoo_configuration")['username'];
        $password = config("odoo_configuration")['password'];
        $url = config("odoo_configuration")['url'];


        // $info = RipcordRipcord::client('https://demo.odoo.com/start')->start();
        // list($url, $db, $username, $password) = array($info['host'], $info['database'], $info['user'], $info['password']);

        $common = RipcordRipcord::client("$url/xmlrpc/2/common");
        // get user id
        $uid = $common->authenticate($db, $username, $password, array());
        // select model
        $models = RipcordRipcord::client("$url/xmlrpc/2/object");


       $models->execute_kw($db, $uid, $password, 'res.partner', 'check_access_rights', array('read'), array('raise_exception' => false));

        //    return  $models->execute_kw($db, $uid, $password, 'res.partner', 'search', array(array(array('is_company', '=', true))));
        //    return  $models->execute_kw($db, $uid, $password, 'res.partner', 'search', array(array(array('is_company', '=', true))), array('offset'=>10, 'limit'=>5));

        // return $models->execute_kw($db, $uid, $password, 'res.partner', 'search_read', array(array(array('is_company', '=', false))), array('fields' => array('student_id', 'name', 'student_national_id', 'guardian_id', 'guardian_national_id'), 'limit' => 5));

        // cache::forget('last_id');


        // $last_id = Cache::get('last_id', 0);
        // // return $last_id;
        $users = guardian::where('guardian_id', 3099)->select('guardians.guardian_id', 'users.email', 'users.phone', DB::raw('CONCAT(users.first_name, " " , users.last_name) as full_name'), 'guardians.national_id')
            ->leftjoin('users', 'users.id', 'guardians.guardian_id')
            ->with('students')
            ->orderBy('guardians.guardian_id')
            ->get();

        foreach ($users as $user) {
            $models->execute_kw($db, $uid, $password, 'res.partner', 'create', array(array('guardian_id' => $user->guardian_id, 'name' => $user->full_name, 'guardian_national_id' =>  $user->national_id, 'phone' => $user->phone, 'email' => $user->email, 'is_company' => True)));
            echo '<br>' . $user->guardian_id;
            foreach ($user->students as $student) {
                $models->execute_kw($db, $uid, $password, 'res.partner', 'create', array(array('student_id' => $student->id, 'name' => $student->student_name, 'student_national_id' => $student->national_id, 'guardian_id' => $student->guardian_id)));
                echo '<br> student_id' . $student->id . ' - ' . $student->student_name;
            }
            // Cache::put('last_id', $user->guardian_id);
        }
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
