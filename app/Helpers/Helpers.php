<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use App\Exceptions\SystemConfigurationError;
use App\Models\ContractTerms;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config as FacadesConfig;

class Helpers
{
    public static function applClasses()
    {
        // default data array
        $DefaultData = [
            'mainLayoutType' => 'vertical',
            'theme' => 'light',
            'sidebarCollapsed' => false,
            'navbarColor' => '',
            'horizontalMenuType' => 'floating',
            'verticalMenuNavbarType' => 'floating',
            'footerType' => 'static', //footer
            'layoutWidth' => 'boxed',
            'showMenu' => true,
            'bodyClass' => '',
            'pageClass' => '',
            'pageHeader' => true,
            'contentLayout' => 'default',
            'blankPage' => false,
            'defaultLanguage' => 'ar',
            'direction' => env('MIX_CONTENT_DIRECTION', 'rtl'),
        ];

        // if any key missing of array from custom.php file it will be merge and set a default value from dataDefault array and store in data variable
        $data = array_merge($DefaultData, config('custom.custom'));

        // All options available in the template
        $allOptions = [
            'mainLayoutType' => array('vertical', 'horizontal'),
            'theme' => array('light' => 'light', 'dark' => 'dark-layout', 'bordered' => 'bordered-layout', 'semi-dark' => 'semi-dark-layout'),
            'sidebarCollapsed' => array(true, false),
            'showMenu' => array(true, false),
            'layoutWidth' => array('full', 'boxed'),
            'navbarColor' => array('bg-primary', 'bg-info', 'bg-warning', 'bg-success', 'bg-danger', 'bg-dark'),
            'horizontalMenuType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky'),
            'horizontalMenuClass' => array('static' => '', 'sticky' => 'fixed-top', 'floating' => 'floating-nav'),
            'verticalMenuNavbarType' => array('floating' => 'navbar-floating', 'static' => 'navbar-static', 'sticky' => 'navbar-sticky', 'hidden' => 'navbar-hidden'),
            'navbarClass' => array('floating' => 'floating-nav', 'static' => 'navbar-static-top', 'sticky' => 'fixed-top', 'hidden' => 'd-none'),
            'footerType' => array('static' => 'footer-static', 'sticky' => 'footer-fixed', 'hidden' => 'footer-hidden'),
            'pageHeader' => array(true, false),
            'contentLayout' => array('default', 'content-left-sidebar', 'content-right-sidebar', 'content-detached-left-sidebar', 'content-detached-right-sidebar'),
            'blankPage' => array(false, true),
            'sidebarPositionClass' => array('content-left-sidebar' => 'sidebar-left', 'content-right-sidebar' => 'sidebar-right', 'content-detached-left-sidebar' => 'sidebar-detached sidebar-left', 'content-detached-right-sidebar' => 'sidebar-detached sidebar-right', 'default' => 'default-sidebar-position'),
            'contentsidebarClass' => array('content-left-sidebar' => 'content-right', 'content-right-sidebar' => 'content-left', 'content-detached-left-sidebar' => 'content-detached content-right', 'content-detached-right-sidebar' => 'content-detached content-left', 'default' => 'default-sidebar'),
            'defaultLanguage' => array('ar' => 'ar', 'en' => 'en', 'fr' => 'fr', 'de' => 'de', 'pt' => 'pt'),
            'direction' => array('ltr', 'rtl'),
        ];

        //if mainLayoutType value empty or not match with default options in custom.php config file then set a default value
        foreach ($allOptions as $key => $value) {
            if (array_key_exists($key, $DefaultData)) {
                if (gettype($DefaultData[$key]) === gettype($data[$key])) {
                    // data key should be string
                    if (is_string($data[$key])) {
                        // data key should not be empty
                        if (isset($data[$key]) && $data[$key] !== null) {
                            // data key should not be exist inside allOptions array's sub array
                            if (!array_key_exists($data[$key], $value)) {
                                // ensure that passed value should be match with any of allOptions array value
                                $result = array_search($data[$key], $value, 'strict');
                                if (empty($result) && $result !== 0) {
                                    $data[$key] = $DefaultData[$key];
                                }
                            }
                        } else {
                            // if data key not set or
                            $data[$key] = $DefaultData[$key];
                        }
                    }
                } else {
                    $data[$key] = $DefaultData[$key];
                }
            }
        }

        //layout classes
        $layoutClasses = [
            'theme' => $data['theme'],
            'layoutTheme' => $allOptions['theme'][$data['theme']],
            'sidebarCollapsed' => $data['sidebarCollapsed'],
            'showMenu' => $data['showMenu'],
            'layoutWidth' => $data['layoutWidth'],
            'verticalMenuNavbarType' => $allOptions['verticalMenuNavbarType'][$data['verticalMenuNavbarType']],
            'navbarClass' => $allOptions['navbarClass'][$data['verticalMenuNavbarType']],
            'navbarColor' => $data['navbarColor'],
            'horizontalMenuType' => $allOptions['horizontalMenuType'][$data['horizontalMenuType']],
            'horizontalMenuClass' => $allOptions['horizontalMenuClass'][$data['horizontalMenuType']],
            'footerType' => $allOptions['footerType'][$data['footerType']],
            'sidebarClass' => '',
            'bodyClass' => $data['bodyClass'],
            'pageClass' => $data['pageClass'],
            'pageHeader' => $data['pageHeader'],
            'blankPage' => $data['blankPage'],
            'blankPageClass' => '',
            'contentLayout' => $data['contentLayout'],
            'sidebarPositionClass' => $allOptions['sidebarPositionClass'][$data['contentLayout']],
            'contentsidebarClass' => $allOptions['contentsidebarClass'][$data['contentLayout']],
            'mainLayoutType' => $data['mainLayoutType'],
            'defaultLanguage' => $allOptions['defaultLanguage'][$data['defaultLanguage']],
            'direction' => $data['direction'],
        ];
        // set default language if session hasn't locale value the set default language
        if (!session()->has('locale')) {
            app()->setLocale($layoutClasses['defaultLanguage']);
        }

        // sidebar Collapsed
        if ($layoutClasses['sidebarCollapsed'] == 'true') {
            $layoutClasses['sidebarClass'] = "menu-collapsed";
        }

        // blank page class
        if ($layoutClasses['blankPage'] == 'true') {
            $layoutClasses['blankPageClass'] = "blank-page";
        }

        return $layoutClasses;
    }

    public static function updatePageConfig($pageConfigs)
    {
        $demo = 'custom';
        if (isset($pageConfigs) && count($pageConfigs) > 0) {
            foreach ($pageConfigs as $config => $val) {
                FacadesConfig::set('custom.' . $demo . '.' . $config, $val);
            }
        }
    }

    public static function Colors()
    {
        return [
            ['class' => 'primary', 'text' => 'ازرق'],
            ['class' => 'secondary', 'text' => 'رمادي'],
            ['class' => 'success', 'text' => 'اخضر'],
            ['class' => 'danger', 'text' => 'احمر'],
            ['class' => 'warning text-dark', 'text' => 'اصفر'],
            ['class' => 'info text-dark', 'text' => 'ازرق فاتح'],
            ['class' => 'light text-dark', 'text' => 'ارمادي فاتح'],
            ['class' => 'dark', 'text' => 'اسود']
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

    public static function payment_plans($value = null)
    {
        $payment_plans = [
            1 => 'سنوي',
            2 => 'فصل دراسي',
            3 => 'شهري',
        ];

        return null !== $value ? $payment_plans[$value] : $payment_plans;
    }

    public static function daysArray($day = null)
    {

        $days = [
            '0' => 'الاحد',
            '1' => 'الاثنين',
            '2' => 'الثلاثاء',
            '3' => 'الاربعاء',
            '4' => 'الخميس',
            '5' => 'الجمعه',
            '6' => 'السبت',
        ];

        return null !== $day && array_key_exists($day, $days) ? $days[$day] : $days;
    }
}
