<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helper extends Model
{
    use HasFactory;

    public static function Colors()
    {
        return [
        ['class'=> 'primary', 'text' =>'ازرق'],
        ['class'=> 'secondary', 'text'=>'رمادي'],
        ['class'=> 'success', 'text'=>'اخضر'],
        ['class'=> 'danger', 'text'=>'احمر'],
        ['class'=> 'warning text-dark', 'text'=>'اصفر'],
        ['class'=> 'info text-dark', 'text'=>'ازرق فاتح'],
        ['class'=> 'light text-dark', 'text'=>'ارمادي فاتح'],
        ['class'=> 'dark', 'text'=>'اسود']
    ];

    }

    public static function arabic_date($date)
    {

        $date = Carbon::parse($date);
        $months = ["01" => "يناير", "02" => "فبراير", "03" => "مارس", "04" => "أبريل", "05" => "مايو", "06" => "يونيو", "07" => "يوليو", "08" => "أغسطس", "09" => "سبتمبر", "10" => "أكتوبر", "11" => "نوفمبر", "12" => "ديسمبر"];
        $dayes = ["0" => "الأحد", "1" => "الاثنين", "2" => "الثلاثاء", "3" => "الأربعاء", "4" => "الخميس", "5" => "الجمعة", "6" => "السبت"];

        $ar_month = $months[$date->format('m')];
        $ar_day = $dayes[$date->dayOfWeek];

        return $ar_day . ' الموافق ' . $date->format('d') . ' ' . $ar_month . ' ' . $date->format('Y');
    }

}

