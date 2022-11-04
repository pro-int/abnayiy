<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function get_semesters()
    {
        $semesters = [];
        $AcademicYear = $this->GetAdmissionAcademicYear();
        if ($AcademicYear) {
            $semesters = semester::select('semester_name','semester_start','semester_end')->where('year_id', $AcademicYear->id)->get();
        }
        return $this->ApiSuccessResponse($semesters);
    }
}
