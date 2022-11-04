<?php

namespace App\Services;

use App\Models\School;
use Illuminate\Support\Facades\DB;

class SchoolService
{
    protected School $school;

    public function __construct(School $school)
    {
        $this->school = request('school') ? $school->find(request('school')) : $school;
    }


    public function all()
    {
        return $this->school
            ->CreatorName()->UpdaterName()->CorporateName()
            ->select(
                'schools.*',
                DB::raw('CONCAT(createAdmin.first_name, " " , createAdmin.last_name) as createdAdminName'),
                DB::raw('CONCAT(updateAdmin.first_name, " " , updateAdmin.last_name) as UpdatedAdmimName'),
                'corporates.corporate_name'
            )
            ->filtered()->get();
    }


    public function create($request)
    {
        return $this->school->create($request->only(
            'school_name',
            'corporate_id',
            'created_by',
            'active'
        ));
    }

    public function show()
    {
        return $this->school;
    }

    public function update($request)
    {
        return $this->school->update($request->only(
            'school_name',
            'corporate_id',
            'updated_by',
            'active'
        ));
    }

    public function delete()
    {
        return $this->school->delete();
    }
}
