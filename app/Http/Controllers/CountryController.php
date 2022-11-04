<?php
/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->id == 'all') {
            $data = Country::all();
        } else {
            $data = Country::find($request->id);
        }
        return $this->ApiSuccessResponse($data);
    }
}
