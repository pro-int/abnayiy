<?php

namespace App\Services;

use App\Models\Corporate;
use Illuminate\Support\Facades\DB;

class CorporateService
{
    protected Corporate $corporate;

    public function __construct(Corporate $corporate)
    {
        $this->corporate = request('corporate') ? $corporate->find(request('corporate')) : $corporate;
    }

    public function all()
    {
        return $this->corporate
        ->CreatorName()->UpdaterName()
            ->select(
                'corporates.*',
                DB::raw('CONCAT(createAdmin.first_name, " " , createAdmin.last_name) as createdAdminName'),
                DB::raw('CONCAT(updateAdmin.first_name, " " , updateAdmin.last_name) as UpdatedAdmimName')
            )
            ->get();
    }

    public function create($request)
    {
        return $this->corporate->create($request->only(
            'corporate_name',
            'created_by',
            'active'
        ));
    }

    public function show()
    {
        return $this->corporate;
    }
    
    public function update($request)
    {
        return $this->corporate->update($request->only(
            'corporate_name',
            'updated_by',
            'active'
        ));
    }

    public function delete()
    {
        return $this->corporate->delete();
    }
}
