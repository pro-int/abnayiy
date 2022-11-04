<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\SotreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\admin;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\guardian;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with(['admin', 'guardian', 'teacher']);

        if ($request->filled('search')) {
            if ($request->search[0] == '=') {
                $users = $users->where('users.id', substr($request->search, 1));
            } else {
                if (is_numeric($request->search)) {
                    # search only numitic values
                    $users = $users->where(function ($query) use ($request) {
                        $query->Where('users.phone', 'LIKE', '%' . $request->search . '%');
                    });
                } else {
                    $users = $users->where(function ($query) use ($request) {
                        $query->Where(DB::raw("CONCAT(users.first_name,' ',users.last_name)"), 'LIKE', "%" . $request->search . "%");
                    });
                }
            }
        }

        $users = $users->paginate(config('view.per_page', 30));

        return view('admin.users.index', compact('users'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.users.create');
    }

    /**
     * @param \App\Http\Requests\admin\SotreUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SotreUserRequest $request)
    {
        $result = DB::transaction(function () use ($request) {
            $user = new User();

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->country_id = $request->country_id;
            $user->password = hash::make($request->password);
            $user->save();

            if ($request->isAdmin) {
                # account is admin
                admin::create(['admin_id' => $user->id, 'job_title' => $request->job_title, 'active' => $request->admin_active]);
                $user->assignRole($request->input('roles'));
            }

            if ($request->isGuardian) {
                # account is guardian
                guardian::create($request->only([
                    'nationality_id',
                    'national_id',
                    'address',
                    'city_name',
                    'category_id'
                ]) + ['guardian_id' => $user->id, 'active' => $request->guardian_active]);
            }

            if ($request->isTeacher) {
                # account is guardian
                teacher::create(['teacher_id' => $user->id, 'active' => $request->teacher_active]);
            }
            return $user;
        });

        if ($result) {
            return redirect()->route('admins.index')
                ->with('alert-success', 'تم اضافة الحساب بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء اضافة الحساب');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $userr
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $user)
    {
        $user = User::with(['roles', 'guardian', 'admin', 'teacher'])->findOrFail($user);
        return view('admin.users.show', compact('user'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $userr
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $user)
    {
        $user = User::with(['roles', 'guardian', 'admin', 'teacher'])->findOrFail($user);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * @param \App\Http\Requests\admin\UpdateUserRequest $request
     * @param \App\Models\User $userr
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country_id = $request->country_id;

        if ($request->change_password) {
            # change password 
            $user->password = Hash::make($request->password);
        }

        $admin =  admin::find($user->id);
        $guardian =  guardian::find($user->id);
        $teacher =  teacher::find($user->id);

        if ($request->isAdmin) {
            # handel admin account
            if (!$admin) {
                # create new admin
                $admin = new admin(['admin_id' => $user->id]);
            }
            $admin->job_title  = $request->job_title;
            $admin->active  = $request->admin_active;
            $admin->save();
            $user->assignRole($request->input('roles'));
        } else if ($admin) {
            $user->roles()->detach();
            $admin->delete();
        }

        if ($request->isGuardian) {
            # handel guardian account
            if (!$guardian) {
                # create new vednor
                $guardian = new guardian(['guardian_id' => $user->id]);
            }


            $guardian->nationality_id = $request->nationality_id;
            $guardian->national_id = $request->national_id;
            $guardian->address = $request->address;
            $guardian->city_name = $request->city_name;
            $guardian->category_id = $request->category_id;
            $guardian->active = $request->guardian_active;
            $guardian->save();
        } else if ($guardian) {
            $guardian->delete();
        }

        if ($request->isTeacher) {
            # handel teacher account
            if (!$teacher) {
                # create new vednor
                $teacher = new Teacher(['teacher_id' => $user->id, 'active' => $request->teacher_active]);
            }

            $teacher->active = $request->teacher_active;
            $teacher->save();
        } else if ($teacher) {
            $teacher->delete();
        }

        if ($user->save()) {
            return redirect()->route('users.index')
                ->with('alert-success', 'تم تعديل الحساب بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل الحساب');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return redirect()->route('users.index')
                ->with('alert-success', 'تم حذف الحساب بنجاح');
        } else {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء حذف الحساب');
        }
    }
}
