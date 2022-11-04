<?php

namespace App\Actions\Fortify;

use App\Models\admin;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        define('MAXLEM', 'max:255');

        if (isset($input['country_id'])) {
            $country_id = $input['country_id'];
        } else {
            $country_id = env('default_country', 1);
        }

        Validator::make($input, [
            'first_name' => ['required', 'string', MAXLEM],
            'last_name' => ['required', 'string', MAXLEM],
            'phone' => ['required', 'string', 'max:12', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'phone' => $this->PreparePhoneNumber($input['phone'], $country_id),
            'country_id' => $country_id,
            'password' => Hash::make($input['password']),
        ]);

        if(User::count() == 1) {
            $role = Role::create(['name' => 'Admin','display_name' => 'مدير','color' => 'info']);
            $permissions = Permission::pluck('id','id')->all();
   
            $role->syncPermissions($permissions);
         
            $user->assignRole([$role->id]);
            admin::create(['admin_id' => $user->id,'']);
        }

        return $user;
    }

    public function PreparePhoneNumber($phone, $country_id = null)
    {

        if ($phone[0] == '0') {
            # remove 0 from reuest...
            $phone = substr($phone, 1);
        }

        if (null !== $country_id) {
            $country = Country::find($country_id);
            
            return $country ? $country->code . $phone : $phone;
        }

        return $phone;
    }
}
