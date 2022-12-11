<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'student_name_en',
        'birth_date',
        'national_id',
        'birth_place',
        'student_care',
        'guardian_id',
        'nationality_id',
        'gender',
        'allow_late_payment',
        'last_noor_sync'
    ];

    protected $dates = [
        'last_noor_sync',
    ];

    private $enableOdooIntegration = true;

    private $odooIntegrationKeys = [];

    public function guardian()
    {
        return $this->belongsTo(guardian::class,'guardian_id','guardian_id');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
    public function getAvatar()
    {
        $words = preg_split("/\s+/", $this->student_name);
        return mb_substr($words[0], 0, 1, 'utf8') . ' ' . mb_substr($words[2], 0, 1, 'utf8');
    }

    public function getOdooKeys()
    {
        $guardian = guardian::select('national_id')->where('guardian_id', $this->guardian_id)->first();

        $applicationInfo = Application::select("plans.odoo_id")
            ->leftjoin("plans", "plans.id", "applications.plan_id")
            ->where("student_name", $this->student_name)->first();
        
        $code = $applicationInfo? $applicationInfo->odoo_id : null;

        $this->odooIntegrationKeys["student_id"] = $this->id;
        $this->odooIntegrationKeys["name"] =  $this->student_name;
        $this->odooIntegrationKeys["student_national_id"] = $this->national_id;
        $this->odooIntegrationKeys["guardian_id"] = $this->guardian_id;
        $this->odooIntegrationKeys["guardian_national_id"] = $guardian->national_id?? $this->national_id;
        $this->odooIntegrationKeys["property_account_receivable_id"] = $code;

        return $this->odooIntegrationKeys;
    }

    public function getEnableOdooIntegration(){
        return $this->enableOdooIntegration;
    }

}
