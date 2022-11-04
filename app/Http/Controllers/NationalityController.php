<?php
/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\nationality;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    public function index(Request $request)
    {
        if ($request->id == 'all') {
            $data = nationality::all();
        } else {
            $data = nationality::find($request->id);
        }
        return $this->ApiSuccessResponse($data);

    }
}
