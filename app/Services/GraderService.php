<?php

namespace App\Services;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GraderService
{
    protected Grade $grade;

    protected $allowedFilters = [
        'gender_id',
        'school_id'
    ];

    public function __construct(Grade $grade)
    {
        $this->grade = request('grade') ? $grade->find(request('grade')) : $grade;
    }

    public function all(Request $request)
    {
        $filtters = array_filter($request->only($this->allowedFilters));

        return $this->grade
            ->getFiltered($filtters);
    }

    public function create($request)
    {
        return $this->grade->create($request->only(
            'school_id',
            'grade_name',
            'grade_type',
            'active',
        ));
    }

    public function show()
    {
        return $this->grade;
    }

    public function update($request)
    {
        return $this->grade->update($request->only(
            'school_id',
            'grade_name',
            'grade_type',
            'active',
        ));
    }

    public function delete()
    {
        return $this->grade->delete();
    }
}
