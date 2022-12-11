<?php

namespace App\Services;

use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenderService
{
    protected Gender $gender;

    public function __construct(Gender $gender)
    {
        $this->gender = request('gender') ? $gender->find(request('gender')) : $gender;
    }


    public function all(Request $request)
    {
        return $this->gender
            ->CreatorName()->UpdaterName()->SchoolName()
            ->select(
                'genders.*',
                DB::raw('CONCAT(createAdmin.first_name, " " , createAdmin.last_name) as createdAdminName'),
                DB::raw('CONCAT(updateAdmin.first_name, " " , updateAdmin.last_name) as UpdatedAdmimName'),
                'schools.school_name','appointment_sections.section_name', 'noor_accounts.account_name'
            )
            ->leftjoin('appointment_sections', 'appointment_sections.id', 'genders.appointment_section_id')
            ->leftjoin('noor_accounts', 'noor_accounts.id', 'genders.noor_account_id')
            ->filtered($request)
            ->get();
    }


    public function create($request)
    {
        return $this->gender->create($request->only(
            'school_id',
            'gender_name',
            'gender_type',
            'grade_name_noor',
            'appointment_section_id',
            'noor_account_id',
            'odoo_product_id',
            'active',
        ));
    }

    public function show()
    {
        return $this->gender;
    }

    public function update($request)
    {
        return $this->gender->update($request->only(
            'school_id',
            'gender_name',
            'gender_type',
            'grade_name_noor',
            'appointment_section_id',
            'noor_account_id',
            'odoo_product_id',
            'active',
        ));
    }

    public function delete()
    {
        return $this->gender->delete();
    }
}
