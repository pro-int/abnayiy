<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Exceptions\SystemConfigurationError;
use App\Models\AcademicYear;
use App\Models\Bank;
use App\Models\Country;
use App\Models\Gender;
use App\Models\Grade;
use App\Models\Level;
use App\Models\nationality;
use App\Models\Plan;
use App\Models\semester;
use App\Models\Transportation;
use App\Models\School;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function noor()
    {
        info(request());
        return 'ok';
    }
    public function data()
    {
        $plans              = Plan::where('active', 1)->select('plan_name', 'id', 'transaction_methods', 'contract_methods')->get();
        $schools              = School::where('active', 1)->select('school_name', 'id')->get();
        $genders            = Gender::where('active', 1)->select('school_id', 'gender_name', 'id')->get();
        $grades             = Grade::where('active', 1)->select('gender_id', 'grade_name', 'id')->get();
        $levels             = Level::where('active', 1)->select('grade_id', 'level_name', 'id')->get();
        $countries_code     = Country::where('active', 1)->select('country_name', 'country_code', 'id')->get();
        $countries_id       = Country::where('active', 1)->select('country_name', 'id')->get();
        $nationalities      = nationality::where('active', 1)->select('nationality_name', 'id')->get();
        $transportations    = Transportation::select('id', 'transportation_type', DB::raw('ROUND(annual_fees * 1.15) as annual_fees'), DB::raw('ROUND(semester_fees * 1.15) as semester_fees'), DB::raw('ROUND(monthly_fees * 1.15) as monthly_fees'))->where('active', 1)->get();
        $banks              = Bank::select('id', 'bank_name', 'account_name', 'account_number', 'account_iban')->where('active', 1)->get();
        $AcademicYears      = AcademicYear::select('id', 'year_numeric', 'year_name', 'current_academic_year', 'is_open_for_admission')->get();

        $semesters = [];
        $AcademicYear = $this->GetAdmissionAcademicYear();
        if ($AcademicYear) {
            $semesters = semester::where('year_id', $AcademicYear->id)->pluck('semester_name', 'id')->toArray();
        }

        $data = [
            'plans' => $plans,
            'schools' => $schools,
            'genders' => $genders,
            'grades' => $grades,
            'levels' => $levels,
            'countries_id' => $countries_id,
            'countries_code' => $countries_code,
            'nationalities' => $nationalities,
            'transportations' => $transportations,
            'semesters' => $semesters,
            'banks' => $banks,
            'academic_years' => $AcademicYears
        ];

        return $this->ApiSuccessResponse($data);
    }

    /**
     * @param array $data
     * @param String $message
     * @param bool $isDone
     * @param bool $isSuccess
     * @param integer $code
     * @return json
     */
    public function ApiSuccessResponse($data, $message = null, $isDone = true, $isSuccess = true, $code = 200)
    {
        // Api Success Response
        return response()->json([
            'done' => $isDone,
            'message' => $message,
            'success' => $isSuccess,
            'data' => $data
        ], $code);
    }
    public function ApiErrorResponse($message = null, $code = 500, $errors = null, $isDone = true, $isSuccess = false)
    {
        // Api Error Response
        return response()->json([
            'done' => $isDone,
            'success' => $isSuccess,
            'message' => $message,
            'errors' => $errors,
        ], $code);
    }

    public function PreparePhoneNumber($phone, $country_id = null)
    {

        if ($phone[0] == '0') {
            # remove 0 from reuest...
            $phone = substr($phone, 1);
        }

        if (null !== $country_id) {
            $country = Country::findorfail($country_id)->first();
            return $country->code . $phone;
        }

        return $phone;
    }

    /**
     * @return AcademicYear $year
     */
    public function GetAcademicYear()
    {
        $year =  AcademicYear::where('current_academic_year', 1)->first();
        if (!$year) {
            throw new SystemConfigurationError('لم يتم العثور علي العام الدراسي الحالي .. تأكد من اعدادات السنوات الدراسية بشكل صحيح');
        }
        return $year;
    }

    /**
     * Get the current Admission Academic Year - where is_open_for_admission = 1.
     * @return AcademicYear $year
     */
    public function GetAdmissionAcademicYear()
    {
        $year = AcademicYear::where('is_open_for_admission', 1)->first();

        if (!$year) {
            throw new SystemConfigurationError('لم يتم العثور علي عام دراسي متاح للتقديم .. تأكد من اعدادات السنوات الدراسية بشكل صحيح');
        }
        return $year;
    }

    // public function get_pdf($content, $file_name ='', $orientation = 'L')
    // {
    //     $mpdf = new \Mpdf\Mpdf([
    //         'orientation' => $orientation,
    //     ]);

    //     $mpdf->SetCreator(env('APP_NAME'));
    //     $mpdf->SetDisplayMode('fullwidth');
    //     $content_array = str_split($content,900000);
    //     foreach ($content_array as $part) {
    //         $mpdf->WriteHTML($part);
    //     }
    //     return $mpdf->Output($file_name, 'I');

    // }


    // public function get_pdf($content, $orientation = 'L')
    // {
    //     $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    //     $fontDirs = $defaultConfig['fontDir'];

    //     $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    //     $fontData = $defaultFontConfig['fontdata'];

    //     $mpdf = new Mpdf([
    //         'margin_left' => 10,
    //         'margin_right' => 10,
    //         'margin_top' => 10,
    //         'margin_bottom' => 15,

    //         'fontDir' => array_merge($fontDirs, [
    //             resource_path() . '/fonts/mpdf',
    //         ]),
    //         'fontdata' => $fontData + [
    //             "cairo" => [
    //                 'R' => "Cairo-Regular.ttf",
    //                 'B' => "Cairo-Bold.ttf",
    //                 'useOTL' => 0xFF,
    //                 'useKashida' => 75,
    //             ],
    //             "notokufi" => [
    //                 'R' => "NotoKufiArabic-Regular.ttf",
    //                 'B' => "NotoKufiArabic-Bold.ttf",
    //                 'useOTL' => 0xFF,
    //                 'useKashida' => 75,
    //             ]
    //         ],
    //         'orientation' => $orientation
    //     ]);

    //     $mpdf->SetCreator(env('APP_NAME'));
    //     $mpdf->SetDisplayMode('fullpage');
    //     $content_array = str_split($content,900000);

    //     foreach ($content_array as $part) {
    //         $mpdf->WriteHTML($part);
    //     }

    //     return $this->mpdf;
    // }

    // public function setWaterMark(string $img)
    // {
    //     $this->mpdf->SetWatermarkImage($img, 0.15, 'D');
    //     $this->mpdf->showWatermarkImage = true;

    //     return $this->mpdf;
    // }

}
