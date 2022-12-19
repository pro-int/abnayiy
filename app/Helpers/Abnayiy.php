<?php // Code within app\Helpers\Helper.php

use App\Exceptions\SystemConfigurationError;
use App\Models\AcademicYear;
use App\Models\Bank;
use App\Models\ContractTerms;
use App\Models\Corporate;
use App\Models\Country;
use App\Models\CouponClassification;
use App\Models\Level;
use App\Models\nationality;
use App\Models\PaymentMethod;
use App\Models\PaymentNetwork;
use App\Models\Period;
use App\Models\PermissionCase;
use App\Models\School;
use App\Models\semester;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
// file pathes
const CIONTRACT_FILES = 'contract_files';
const RECEIPTS_FILES = 'receipts';

const DEFAULT_WALLET = 'رصيد نقدي';
const CREDIT_WALLET = 'رصيد ترويجي';
const DEFAULT_WALLET_SLUG = 'balance';
const CREDIT_WALLET_SLUG = 'credit';
const CREDIT_WALLET_DISC = 'غير قابل للسحب';

const WALLET_RECEIPT_PATH = 'receipts/wallet_receipts';
if (! function_exists('upload')) {
    function upload($file, $disk = 's3', $folder = '', $filename = '')
    {
        $type = [
            'jpg' => 'image',
            'jpeg' => 'image',
            'png' => 'image',
            'svg' => 'image',
            'webp' => 'image',
            'gif' => 'image',
            'mp4' => 'video',
            'mpg' => 'video',
            'mpeg' => 'video',
            'webm' => 'video',
            'ogg' => 'video',
            'avi' => 'video',
            'mov' => 'video',
            'flv' => 'video',
            'swf' => 'video',
            'mkv' => 'video',
            'wmv' => 'video',
            'wma' => 'audio',
            'aac' => 'audio',
            'wav' => 'audio',
            'mp3' => 'audio',
            'zip' => 'archive',
            'rar' => 'archive',
            '7z' => 'archive',
            'doc' => 'document',
            'txt' => 'document',
            'docx' => 'document',
            'pdf' => 'document',
            'csv' => 'document',
            'xml' => 'document',
            'ods' => 'document',
            'xlr' => 'document',
            'xls' => 'document',
            'xlsx' => 'document',
            'ppt' => 'document',
            'odt' => 'document',
            'odp' => 'document',
        ];
        if (isset($file)) {
            $extension = strtolower($file->getClientOriginalExtension());
            if (isset($type[$extension])) {
                if ($disk == 's3') {
                    $filePath = '/'.$folder;
                    $spaceImage = Storage::disk($disk)->put($filePath, $file);
//                    $spaceImage = Storage::disk($disk)->url($spaceImage);
                } elseif ($disk == 'public') {
                    $filename = ! empty($filename) ? $filename : rand().'.'. time() . '.' . $file->getClientOriginalExtension();

                    $spaceImage=Storage::disk($disk)->putFileAs(
                        $folder,
                        $file,
                        $filename
                    );
                }
                return $spaceImage;
            }
        }

        return null;
    }
}
if (! function_exists('getSpaceUrl')) {
    function getSpaceUrl($img = null)
    {
        return 'https://'.env('AWS_ROUTE').'/'.$img;
    }
}
if (! function_exists('getFileUrl')) {
    function getFileUrl($fileName, $disk = 's3', $folder = '')
    {
        if ($disk == 's3') {
            return 'https://'.env('AWS_ROUTE').'/'.$fileName;
        }
        return null;
    }
}
/**
 * get currant period based on  acadmimic year.
 * @param App\Models\AcademicYear|int $year
 *
 * @return App\Models\Period $period
 */

function currentPeriod($year, $findOrFail = false)
{
    $year = $year instanceof AcademicYear ? $year->id : $year;

    $period = Period::where('academic_year_id', $year)->whereDate('apply_start', '<=', Carbon::now())->whereDate('apply_end', '>=', Carbon::now())->where('active', 1)->first();

    if ($findOrFail && !$period) {
        throw new SystemConfigurationError('لم يتم العثور علي فترة السداد الحالية .. تأكد من اعدادات فترات السداد بشكل صحيح');
    }

    return $period;
}

/**
 * @return AcademicYear $year
 */
function GetAcademicYear()
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
function GetAdmissionAcademicYear()
{
    $year = AcademicYear::where('is_open_for_admission', 1)->first();

    if (!$year) {
        throw new SystemConfigurationError('لم يتم العثور علي عام دراسي متاح للتقديم .. تأكد من اعدادات السنوات الدراسية بشكل صحيح');
    }
    return $year;
}


/**
 * get banks from database
 * @return bank $banks
 */
function GetBanks($bank = null, $returnArray = true,)
{
    $banks = Bank::where('active', 1);
    if (null !== $bank) {
        $banks = $banks->where('bank', $bank);
    }

    if ($returnArray) {
        return $banks->select(
            DB::raw('CONCAT(banks.bank_name, " (" ,banks.account_number, ")") as bank_name'),
            'id'
        )->pluck('bank_name', 'id')->toArray();
    }

    return  $banks->select(
        'bank_name',
        'account_name',
        'account_number',
        'account_iban',
        'id'
    )->get();
}

/**
 * get banks from database
 * @return \App\Models\PaymentNetwork $networks
 */
function GetNetworks($network = null, $returnArray = true,)
{
    $networks = PaymentNetwork::where('active', 1);
    if (null !== $network) {
        $networks = $networks->where('network', $network);
    }

    if ($returnArray) {
        return $networks->select(
            DB::raw('CONCAT(payment_networks.network_name, " (" ,payment_networks.account_number, ")") as network_name'),
            'id'
        )->pluck('network_name', 'id')->toArray();
    }

    return  $networks->select(
        'network_name',
        'account_number',
        'active',
        'add_by'
    )->get();
}


/**
 * get PaymentMethod from database
 * @return PaymentMethod $banks
 */
function paymentMethods($returnArray = true, $payment_method_id = null)
{
    $paymentMethods = PaymentMethod::where('active', 1)->orderBy('id');

    if (null !== $payment_method_id) {
        if (is_array($payment_method_id)) {
            $paymentMethods = $paymentMethods->whereIn('id', $payment_method_id);
        } else {
            $paymentMethods = $paymentMethods->where('id', $payment_method_id);
        }
    }

    if ($returnArray) {
        return $paymentMethods->pluck('method_name', 'id')->toArray();
    }

    return PaymentMethod::select('method_name', 'id')->get();
}

/**
 * return tuition fees based on semesters
 *
 * @param  \App\Models\Level|int  $year
 * @param  \App\Models\semester $semesters
 * @return float  $fees
 */

function semesters_tuition_fees($level, $semesters): float
{
    $level = $level instanceof  Level ? $level : Level::findOrFail($level);

    $persent = $semesters->sum('semester_in_fees');

    return round($level->tuition_fees * ($persent / 100), 2);
}


/**
 * return matched semesters based on date $fromDate
 *
 * @param  \App\Models\AcademicYear  $year
 * @param  \Carbon  $fromDate
 * @return  \App\Models\semester $semesters
 */
function match_semesters(AcademicYear $year, $fromDate): Collection
{
    $semesters = semester::Where('year_id', $year->id)->whereDate('semester_end', '>', $fromDate)->get();
    if (!$semesters) {
        throw new SystemConfigurationError("لم يتم العثور علي فصول دراسية متاحة للتسجيل بها خلال الوقت الحالي في العام الدراسي  $year->year_name  تأكد من اعدادات الفصول الدراسية  بشكل صحيح");
    }
    return $semesters;
}


/**
 * return matched semesters based on date $fromDate
 *
 * @param  \App\Models\nationality|int  $nationality_id
 * @param  float  $tuition_fees
 * @return  array
 */
function CalculateVat($nationality_id, $tuition_fees)
{
    $vat = 0;
    $nationality = nationality::find($nationality_id);

    if ($nationality && $nationality->vat_rate > 0) {
        $vat = $tuition_fees * ($nationality->vat_rate / 100);
    }
    return [
        'vat_rate' => $nationality->vat_rate ?? 0,
        'vat_amount' => $vat
    ];
}

/**
 * return matched semesters based on date $fromDate
 *
 * @param  \App\Models\nationality|int  $nationality_id
 * @param  float  $tuition_fees
 * @return  \App\Models\ContractTerms
 */
function current_contract_term(): ContractTerms
{
    $terms = ContractTerms::where('is_default', true)->first() ?? ContractTerms::last();
    if (!$terms) {
        throw new SystemConfigurationError('لم يتم العثور علي شروط التعاقد .. تأكد من اعدادات شروط التعاقد بشكل صحيح');
    }
    return $terms;
}


/**
 * @param bool $reurnArray
 * @param int $id
 * @return \App\Models\PermissionCase|array
 */
function getPermissionsCases($reurnArray = true, $id = null)
{
    if (null !== $id) {
        if (is_array($id)) {
            return PermissionCase::whereIn('id', $id)->pluck('case_name')->toArray();
        }
        return PermissionCase::select('case_name')->find($id);
    }
    if ($reurnArray) {
        return PermissionCase::where('active', 1)->pluck('case_name', 'id')->toArray();
    }
    return PermissionCase::select('id', 'case_name', 'case_color')->where('active', 1)->get();
}

/**
 * @param bool $value if true return success
 * @param bool $reurnArray if true return array instade of span
 * @return html|array
 */
function isActive($value, $returnArray = false, $trueClass = 'success', $falseClass = 'danger')
{
    if ($value) {
        $data['icon'] = 'check-circle';
        $data['class'] = $trueClass;
    } else {
        $data['icon'] = 'x-circle';
        $data['class'] = $falseClass;
    }

    return $returnArray ? $data : sprintf('<em class="text-%s"data-feather="%s"></em>', $data['class'], $data['icon']);
}

/**
 * @return array
 */
function getCouponClassification($year_id = null, $id = 'id')
{
    $CouponClassification = CouponClassification::select(DB::raw('CONCAT(classification_name, " - ",classification_prefix) as classification_name'), $id)
        ->where('active', true);

    if (!is_null($year_id)) {
        # select by year
        $CouponClassification  = $CouponClassification->where('academic_year_id', $year_id);
    }

    return  $CouponClassification->pluck('classification_name', $id)->toArray();
}

/**
 * @param array $data
 * @return span
 */
function getBadge($data)
{
    return sprintf('<span class="badge bg-%s">%s</span>', $data[0], $data[1]);
}

/**
 * @param \Bavix\Wallet\Models\Transaction $transaction
 * @return String|null
 */
function getWalletMeta($item, $key)
{
    return isset($item[$key]) ? $item[$key] : null;
}

/**
 * @return  array
 */
function getFileTypes()
{
    return ['installment' =>  'سند امر', 'general' => 'مرفقات عامة'];
}

/**
 *
 */
function getStudentStatus($key = null)
{
    $values = [
        'new' => 'جديد',
        'old' => 'قديم ',
        'graduated' => 'متخرج'
    ];

    if ($key) {
        return isset($values[$key]) ? $values[$key] : '';
    }
    return $values;
}

/**
 *
 */

function getRenewStatus()
{
    return [
        'done' => 'تم تجديد التعاقد',
        'underProcess' => 'في اجراءات التجديد ',
        'noAction' => 'لم يجدد'
    ];
}


/**
 *
 * @return \App\Models\Country
 */
function getCountries()
{
    return Country::where('active', 1)->pluck('country_name', 'id')->toArray();
}
/**
 * @return Spatie\Permission\Models\Role
 */
function getRoles()
{
    return Role::pluck('display_name', 'name')->toArray();
}


/**
 * @return Spatie\Permission\Models\Corporate
 */
function corporates($returnArray = false)
{
    $corporates = Corporate::Active();

    if ($returnArray) {
        return $corporates->pluck('corporate_name', 'id')->toArray();
    }

    return $corporates->select('corporate_name', 'id')->get();
}


# code...
/**
 * @return Spatie\Permission\Models\Corporate
 */
if (!function_exists('schools')) {
    function schools($corporate_id = null, $returnArray = false)
    {
        $schools = School::Active()->selectedCorporate()->select('id', 'school_name', 'corporate_id');

        if ($corporate_id) {
            $schools = $schools->where('corporate_id', $corporate_id);
        }

        if (!$returnArray) {
            return $schools->pluck('school_name', 'id')->toArray();
        }

        return $schools->get();
    }
}
