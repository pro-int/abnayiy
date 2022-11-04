<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LevelController extends Controller
{
    public function changepassword($id,$password)
    {
        $user = User::find($id);
        if ($user) {
            $user->password = $password;
            $user->save();
            return 'ok';
        } else {
        info($password);

            return $id;
        }
    }
}
