<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Permissions;
use App\Models\PermissionsCategory;
class PermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $permissionsCategory = [
            [
                "id" => 1,
                "category_name" => "ادارة الصلاحيات",
                "active" => 1
            ],
            [
                "id" => 2,
                "category_name" => "ادارة المديرين",
                "active" => 1
            ],
            [
                "id" => 3,
                "category_name" => "ادارة السنوات الدراسية",
                "active" => 1
            ],
            [
                "id" => 4,
                "category_name" => "ادارة  الفصول الدراسية",
                "active" => 1
            ],
            [
                "id" => 5,
                "category_name" => "ادارة المدرسين",
                "active" => 1
            ],
            [
                "id" => 6,
                "category_name" => "ادارة اولياء الامور",
                "active" => 1
            ],
            [
                "id" => 7,
                "category_name" => "ادارة انظمة التعليم",
                "active" => 1
            ],
            [
                "id" => 8,
                "category_name" => "الانواع",
                "active" => 1
            ],
            [
                "id" => 9,
                "category_name" => "ادارة المراحل الدراسية",
                "active" => 1
            ],
            [
                "id" => 10,
                "category_name" => "ادارة الصفوف الدراسية",
                "active" => 1
            ],
            [
                "id" => 11,
                "category_name" => "ادارة الفصول",
                "active" => 1
            ],
            [
                "id" => 12,
                "category_name" => "ادارة الدول",
                "active" => 1
            ],
            [
                "id" => 13,
                "category_name" => "ادارة الجنسيات",
                "active" => 1
            ],
            [
                "id" => 14,
                "category_name" => "ادارة الفئات",
                "active" => 1
            ],
            [
                "id" => 15,
                "category_name" => "ادارة فترات السداد",
                "active" => 1
            ],
            [
                "id" => 16,
                "category_name" => "ادارة الخصومات",
                "active" => 1
            ],
            [
                "id" => 17,
                "category_name" => "ادارة خطط الدفع",
                "active" => 1
            ],
            [
                "id" => 18,
                "category_name" => "ادارة الطلبات",
                "active" => 1
            ],
            [
                "id" => 19,
                "category_name" => "ادارة الطلاب",
                "active" => 1
            ],
            [
                "id" => 20,
                "category_name" => "ادارة مشرفين الغياب",
                "active" => 1
            ],
            [
                "id" => 21,
                "category_name" => "ادارة الاستئذان",
                "active" => 1
            ],
            [
                "id" => 22,
                "category_name" => "ادارة مشرفين الطلبات",
                "active" => 1
            ],
            [
                "id" => 23,
                "category_name" => "تسجيل الغياب",
                "active" => 1
            ],
            [
                "id" => 24,
                "category_name" => "تسجيل المشاركة",
                "active" => 1
            ],
            [
                "id" => 25,
                "category_name" => "الادارة المالية",
                "active" => 1
            ],
            [
                "id" => 26,
                "category_name" => "الادارة الاشعارات",
                "active" => 1
            ],
            [
                "id" => 27,
                "category_name" => "ادارة الأشعارات",
                "active" => 1
            ],
            [
                "id" => 28,
                "category_name" => "خدمة النقل",
                "active" => 1
            ],
            [
                "id" => 29,
                "category_name" => "حسابات نور",
                "active" => 1
            ],
            [
                "id" => 30,
                "category_name" => "ادارة المقابلات",
                "active" => 1
            ],
            [
                "id" => 31,
                "category_name" => "اداةر طلبات النقل",
                "active" => 1
            ],
            [
                "id" => 32,
                "category_name" => "ادارة مستخدمين النظام",
                "active" => 1
            ]
        ];
        $permissions = [
            [
                "id" => 1,
                "display_name" => "مشاهدة",
                "name" => "role-list",
                "guard_name" => "web",
                "permission_category_id" => 1
            ],
            [
                "id" => 2,
                "display_name" => "اضافة",
                "name" => "role-create",
                "guard_name" => "web",
                "permission_category_id" => 1
            ],
            [
                "id" => 3,
                "display_name" => "تعديل",
                "name" => "role-edit",
                "guard_name" => "web",
                "permission_category_id" => 1
            ],
            [
                "id" => 4,
                "display_name" => "حذف",
                "name" => "role-delete",
                "guard_name" => "web",
                "permission_category_id" => 1
            ],
            [
                "id" => 5,
                "display_name" => "مشاهدة",
                "name" => "admin-list",
                "guard_name" => "web",
                "permission_category_id" => 2
            ],
            [
                "id" => 6,
                "display_name" => "اضافة",
                "name" => "admin-create",
                "guard_name" => "web",
                "permission_category_id" => 2
            ],
            [
                "id" => 7,
                "display_name" => "تعديل",
                "name" => "admin-edit",
                "guard_name" => "web",
                "permission_category_id" => 2
            ],
            [
                "id" => 8,
                "display_name" => "حذف",
                "name" => "admin-delete",
                "guard_name" => "web",
                "permission_category_id" => 2
            ],
            [
                "id" => 9,
                "display_name" => "مشاهدة",
                "name" => "years-list",
                "guard_name" => "web",
                "permission_category_id" => 3
            ],
            [
                "id" => 10,
                "display_name" => "اضافة",
                "name" => "years-create",
                "guard_name" => "web",
                "permission_category_id" => 3
            ],
            [
                "id" => 11,
                "display_name" => "تعديل",
                "name" => "years-edit",
                "guard_name" => "web",
                "permission_category_id" => 3
            ],
            [
                "id" => 12,
                "display_name" => "حذف",
                "name" => "years-delete",
                "guard_name" => "web",
                "permission_category_id" => 3
            ],
            [
                "id" => 13,
                "display_name" => "مشاهدة",
                "name" => "semesters-list",
                "guard_name" => "web",
                "permission_category_id" => 4
            ],
            [
                "id" => 14,
                "display_name" => "اضافة",
                "name" => "semesters-create",
                "guard_name" => "web",
                "permission_category_id" => 4
            ],
            [
                "id" => 15,
                "display_name" => "تعديل",
                "name" => "semesters-edit",
                "guard_name" => "web",
                "permission_category_id" => 4
            ],
            [
                "id" => 16,
                "display_name" => "حذف",
                "name" => "semesters-delete",
                "guard_name" => "web",
                "permission_category_id" => 4
            ],
            [
                "id" => 17,
                "display_name" => "مشاهدة",
                "name" => "teachers-list",
                "guard_name" => "web",
                "permission_category_id" => 5
            ],
            [
                "id" => 18,
                "display_name" => "اضافة",
                "name" => "teachers-create",
                "guard_name" => "web",
                "permission_category_id" => 5
            ],
            [
                "id" => 19,
                "display_name" => "تعديل",
                "name" => "teachers-edit",
                "guard_name" => "web",
                "permission_category_id" => 5
            ],
            [
                "id" => 20,
                "display_name" => "حذف",
                "name" => "teachers-delete",
                "guard_name" => "web",
                "permission_category_id" => 5
            ],
            [
                "id" => 21,
                "display_name" => "مشاهدة",
                "name" => "guardians-list",
                "guard_name" => "web",
                "permission_category_id" => 6
            ],
            [
                "id" => 22,
                "display_name" => "اضافة",
                "name" => "guardians-create",
                "guard_name" => "web",
                "permission_category_id" => 6
            ],
            [
                "id" => 23,
                "display_name" => "تعديل",
                "name" => "guardians-edit",
                "guard_name" => "web",
                "permission_category_id" => 6
            ],
            [
                "id" => 24,
                "display_name" => "حذف",
                "name" => "guardians-delete",
                "guard_name" => "web",
                "permission_category_id" => 6
            ],
            [
                "id" => 25,
                "display_name" => "مشاهدة",
                "name" => "types-list",
                "guard_name" => "web",
                "permission_category_id" => 7
            ],
            [
                "id" => 26,
                "display_name" => "اضافة",
                "name" => "types-create",
                "guard_name" => "web",
                "permission_category_id" => 7
            ],
            [
                "id" => 27,
                "display_name" => "تعديل",
                "name" => "types-edit",
                "guard_name" => "web",
                "permission_category_id" => 7
            ],
            [
                "id" => 28,
                "display_name" => "حذف",
                "name" => "types-delete",
                "guard_name" => "web",
                "permission_category_id" => 7
            ],
            [
                "id" => 29,
                "display_name" => "مشاهدة",
                "name" => "genders-list",
                "guard_name" => "web",
                "permission_category_id" => 8
            ],
            [
                "id" => 30,
                "display_name" => "اضافة",
                "name" => "genders-create",
                "guard_name" => "web",
                "permission_category_id" => 8
            ],
            [
                "id" => 31,
                "display_name" => "تعديل",
                "name" => "genders-edit",
                "guard_name" => "web",
                "permission_category_id" => 8
            ],
            [
                "id" => 32,
                "display_name" => "حذف",
                "name" => "genders-delete",
                "guard_name" => "web",
                "permission_category_id" => 8
            ],
            [
                "id" => 33,
                "display_name" => "مشاهدة",
                "name" => "grades-list",
                "guard_name" => "web",
                "permission_category_id" => 9
            ],
            [
                "id" => 34,
                "display_name" => "اضافة",
                "name" => "grades-create",
                "guard_name" => "web",
                "permission_category_id" => 9
            ],
            [
                "id" => 35,
                "display_name" => "تعديل",
                "name" => "grades-edit",
                "guard_name" => "web",
                "permission_category_id" => 9
            ],
            [
                "id" => 36,
                "display_name" => "حذف",
                "name" => "grades-delete",
                "guard_name" => "web",
                "permission_category_id" => 9
            ],
            [
                "id" => 37,
                "display_name" => "مشاهدة",
                "name" => "levels-list",
                "guard_name" => "web",
                "permission_category_id" => 10
            ],
            [
                "id" => 38,
                "display_name" => "اضافة",
                "name" => "levels-create",
                "guard_name" => "web",
                "permission_category_id" => 10
            ],
            [
                "id" => 39,
                "display_name" => "تعديل",
                "name" => "levels-edit",
                "guard_name" => "web",
                "permission_category_id" => 10
            ],
            [
                "id" => 40,
                "display_name" => "حذف",
                "name" => "levels-delete",
                "guard_name" => "web",
                "permission_category_id" => 10
            ],
            [
                "id" => 41,
                "display_name" => "مشاهدة",
                "name" => "classes-list",
                "guard_name" => "web",
                "permission_category_id" => 11
            ],
            [
                "id" => 42,
                "display_name" => "اضافة",
                "name" => "classes-create",
                "guard_name" => "web",
                "permission_category_id" => 11
            ],
            [
                "id" => 43,
                "display_name" => "تعديل",
                "name" => "classes-edit",
                "guard_name" => "web",
                "permission_category_id" => 11
            ],
            [
                "id" => 44,
                "display_name" => "حذف",
                "name" => "classes-delete",
                "guard_name" => "web",
                "permission_category_id" => 11
            ],
            [
                "id" => 45,
                "display_name" => "مشاهدة",
                "name" => "countries-list",
                "guard_name" => "web",
                "permission_category_id" => 12
            ],
            [
                "id" => 46,
                "display_name" => "اضافة",
                "name" => "countries-create",
                "guard_name" => "web",
                "permission_category_id" => 12
            ],
            [
                "id" => 47,
                "display_name" => "تعديل",
                "name" => "countries-edit",
                "guard_name" => "web",
                "permission_category_id" => 12
            ],
            [
                "id" => 48,
                "display_name" => "حذف",
                "name" => "countries-delete",
                "guard_name" => "web",
                "permission_category_id" => 12
            ],
            [
                "id" => 49,
                "display_name" => "مشاهدة",
                "name" => "nationalities-list",
                "guard_name" => "web",
                "permission_category_id" => 13
            ],
            [
                "id" => 50,
                "display_name" => "اضافة",
                "name" => "nationalities-create",
                "guard_name" => "web",
                "permission_category_id" => 13
            ],
            [
                "id" => 51,
                "display_name" => "تعديل",
                "name" => "nationalities-edit",
                "guard_name" => "web",
                "permission_category_id" => 13
            ],
            [
                "id" => 52,
                "display_name" => "حذف",
                "name" => "nationalities-delete",
                "guard_name" => "web",
                "permission_category_id" => 13
            ],
            [
                "id" => 53,
                "display_name" => "مشاهدة",
                "name" => "categories-list",
                "guard_name" => "web",
                "permission_category_id" => 14
            ],
            [
                "id" => 54,
                "display_name" => "اضافة",
                "name" => "categories-create",
                "guard_name" => "web",
                "permission_category_id" => 14
            ],
            [
                "id" => 55,
                "display_name" => "تعديل",
                "name" => "categories-edit",
                "guard_name" => "web",
                "permission_category_id" => 14
            ],
            [
                "id" => 56,
                "display_name" => "حذف",
                "name" => "categories-delete",
                "guard_name" => "web",
                "permission_category_id" => 14
            ],
            [
                "id" => 57,
                "display_name" => "مشاهدة",
                "name" => "periods-list",
                "guard_name" => "web",
                "permission_category_id" => 15
            ],
            [
                "id" => 58,
                "display_name" => "اضافة",
                "name" => "periods-create",
                "guard_name" => "web",
                "permission_category_id" => 15
            ],
            [
                "id" => 59,
                "display_name" => "تعديل",
                "name" => "periods-edit",
                "guard_name" => "web",
                "permission_category_id" => 15
            ],
            [
                "id" => 60,
                "display_name" => "حذف",
                "name" => "periods-delete",
                "guard_name" => "web",
                "permission_category_id" => 15
            ],
            [
                "id" => 61,
                "display_name" => "مشاهدة",
                "name" => "discounts-list",
                "guard_name" => "web",
                "permission_category_id" => 16
            ],
            [
                "id" => 62,
                "display_name" => "اضافة",
                "name" => "discounts-create",
                "guard_name" => "web",
                "permission_category_id" => 16
            ],
            [
                "id" => 63,
                "display_name" => "تعديل",
                "name" => "discounts-edit",
                "guard_name" => "web",
                "permission_category_id" => 16
            ],
            [
                "id" => 64,
                "display_name" => "حذف",
                "name" => "discounts-delete",
                "guard_name" => "web",
                "permission_category_id" => 16
            ],
            [
                "id" => 65,
                "display_name" => "مشاهدة",
                "name" => "plans-list",
                "guard_name" => "web",
                "permission_category_id" => 17
            ],
            [
                "id" => 66,
                "display_name" => "اضافة",
                "name" => "plans-create",
                "guard_name" => "web",
                "permission_category_id" => 17
            ],
            [
                "id" => 67,
                "display_name" => "تعديل",
                "name" => "plans-edit",
                "guard_name" => "web",
                "permission_category_id" => 17
            ],
            [
                "id" => 68,
                "display_name" => "حذف",
                "name" => "plans-delete",
                "guard_name" => "web",
                "permission_category_id" => 17
            ],
            [
                "id" => 69,
                "display_name" => "مشاهدة",
                "name" => "applications-list",
                "guard_name" => "web",
                "permission_category_id" => 18
            ],
            [
                "id" => 70,
                "display_name" => "تعديل",
                "name" => "applications-edit",
                "guard_name" => "web",
                "permission_category_id" => 18
            ],
            [
                "id" => 71,
                "display_name" => "تسجيل الطلبات",
                "name" => "applications-create",
                "guard_name" => "web",
                "permission_category_id" => 18
            ],
            [
                "id" => 72,
                "display_name" => "حذف",
                "name" => "applications-delete",
                "guard_name" => "web",
                "permission_category_id" => 18
            ],
            [
                "id" => 73,
                "display_name" => "مشاهدة",
                "name" => "students-list",
                "guard_name" => "web",
                "permission_category_id" => 19
            ],
            [
                "id" => 74,
                "display_name" => "اضافة",
                "name" => "students-create",
                "guard_name" => "web",
                "permission_category_id" => 19
            ],
            [
                "id" => 75,
                "display_name" => "تعديل",
                "name" => "students-edit",
                "guard_name" => "web",
                "permission_category_id" => 19
            ],
            [
                "id" => 76,
                "display_name" => "حذف",
                "name" => "students-delete",
                "guard_name" => "web",
                "permission_category_id" => 19
            ],
            [
                "id" => 77,
                "display_name" => "مشاهدة",
                "name" => "AttendanceManagers-list",
                "guard_name" => "web",
                "permission_category_id" => 20
            ],
            [
                "id" => 78,
                "display_name" => "اضافة",
                "name" => "AttendanceManagers-create",
                "guard_name" => "web",
                "permission_category_id" => 20
            ],
            [
                "id" => 79,
                "display_name" => "تعديل",
                "name" => "AttendanceManagers-edit",
                "guard_name" => "web",
                "permission_category_id" => 20
            ],
            [
                "id" => 80,
                "display_name" => "حذف",
                "name" => "AttendanceManagers-delete",
                "guard_name" => "web",
                "permission_category_id" => 20
            ],
            [
                "id" => 81,
                "display_name" => "مشاهدة",
                "name" => "StudentPermissions-list",
                "guard_name" => "web",
                "permission_category_id" => 21
            ],
            [
                "id" => 82,
                "display_name" => "اضافة",
                "name" => "StudentPermissions-create",
                "guard_name" => "web",
                "permission_category_id" => 21
            ],
            [
                "id" => 83,
                "display_name" => "تعديل",
                "name" => "StudentPermissions-edit",
                "guard_name" => "web",
                "permission_category_id" => 21
            ],
            [
                "id" => 84,
                "display_name" => "حذف",
                "name" => "StudentPermissions-delete",
                "guard_name" => "web",
                "permission_category_id" => 21
            ],
            [
                "id" => 85,
                "display_name" => "مشاهدة",
                "name" => "ApplicationManagers-list",
                "guard_name" => "web",
                "permission_category_id" => 22
            ],
            [
                "id" => 86,
                "display_name" => "اضافة",
                "name" => "ApplicationManagers-create",
                "guard_name" => "web",
                "permission_category_id" => 22
            ],
            [
                "id" => 87,
                "display_name" => "تعديل",
                "name" => "ApplicationManagers-edit",
                "guard_name" => "web",
                "permission_category_id" => 22
            ],
            [
                "id" => 88,
                "display_name" => "حذف",
                "name" => "ApplicationManagers-delete",
                "guard_name" => "web",
                "permission_category_id" => 22
            ],
            [
                "id" => 93,
                "display_name" => "مشاهدة",
                "name" => "StudentAttendances-list",
                "guard_name" => "web",
                "permission_category_id" => 23
            ],
            [
                "id" => 94,
                "display_name" => "تسجيل",
                "name" => "StudentAttendances-create",
                "guard_name" => "web",
                "permission_category_id" => 23
            ],
            [
                "id" => 95,
                "display_name" => "تعديل",
                "name" => "StudentAttendances-edit",
                "guard_name" => "web",
                "permission_category_id" => 23
            ],
            [
                "id" => 96,
                "display_name" => "حذف",
                "name" => "StudentAttendances-delete",
                "guard_name" => "web",
                "permission_category_id" => 23
            ],
            [
                "id" => 97,
                "display_name" => "مشاهدة التقرير",
                "name" => "StudentParticipations-list",
                "guard_name" => "web",
                "permission_category_id" => 24
            ],
            [
                "id" => 98,
                "display_name" => "تتسجيل المشاركة",
                "name" => "StudentParticipations-create",
                "guard_name" => "web",
                "permission_category_id" => 24
            ],
            [
                "id" => 99,
                "display_name" => "نعديل المشاركةة",
                "name" => "StudentParticipations-edit",
                "guard_name" => "web",
                "permission_category_id" => 24
            ],
            [
                "id" => 100,
                "display_name" => "حذف المشاركة",
                "name" => "StudentParticipations-delete",
                "guard_name" => "web",
                "permission_category_id" => 24
            ],
            [
                "id" => 105,
                "display_name" => "مشاهدة الدفعات",
                "name" => "accuonts-list",
                "guard_name" => "web",
                "permission_category_id" => 25
            ],
            [
                "id" => 106,
                "display_name" => "تتسجيل الدفعات",
                "name" => "accuonts-create",
                "guard_name" => "web",
                "permission_category_id" => 25
            ],
            [
                "id" => 107,
                "display_name" => "نعديل الدفعات",
                "name" => "accuonts-edit",
                "guard_name" => "web",
                "permission_category_id" => 25
            ],
            [
                "id" => 108,
                "display_name" => "حذف الدفعات",
                "name" => "accuonts-delete",
                "guard_name" => "web",
                "permission_category_id" => 25
            ],
            [
                "id" => 109,
                "display_name" => "مشاهدة",
                "name" => "contents-list",
                "guard_name" => "web",
                "permission_category_id" => 26
            ],
            [
                "id" => 110,
                "display_name" => "اضافة",
                "name" => "contents-create",
                "guard_name" => "web",
                "permission_category_id" => 26
            ],
            [
                "id" => 111,
                "display_name" => "تعديل",
                "name" => "contents-edit",
                "guard_name" => "web",
                "permission_category_id" => 26
            ],
            [
                "id" => 112,
                "display_name" => "حذف",
                "name" => "contents-delete",
                "guard_name" => "web",
                "permission_category_id" => 26
            ],
            [
                "id" => 113,
                "display_name" => "مشاهدة",
                "name" => "notifications-list",
                "guard_name" => "web",
                "permission_category_id" => 27
            ],
            [
                "id" => 114,
                "display_name" => "اضافة",
                "name" => "notifications-create",
                "guard_name" => "web",
                "permission_category_id" => 27
            ],
            [
                "id" => 115,
                "display_name" => "تعديل",
                "name" => "notifications-edit",
                "guard_name" => "web",
                "permission_category_id" => 27
            ],
            [
                "id" => 116,
                "display_name" => "حذف",
                "name" => "notifications-delete",
                "guard_name" => "web",
                "permission_category_id" => 27
            ],
            [
                "id" => 117,
                "display_name" => "مشاهدة",
                "name" => "transportations-list",
                "guard_name" => "web",
                "permission_category_id" => 28
            ],
            [
                "id" => 118,
                "display_name" => "اضافة",
                "name" => "transportations-create",
                "guard_name" => "web",
                "permission_category_id" => 28
            ],
            [
                "id" => 119,
                "display_name" => "تعديل",
                "name" => "transportations-edit",
                "guard_name" => "web",
                "permission_category_id" => 28
            ],
            [
                "id" => 120,
                "display_name" => "حذف",
                "name" => "transportations-delete",
                "guard_name" => "web",
                "permission_category_id" => 28
            ],
            [
                "id" => 121,
                "display_name" => "مشاهدة",
                "name" => "noorAccounts-list",
                "guard_name" => "web",
                "permission_category_id" => 29
            ],
            [
                "id" => 122,
                "display_name" => "اضافة",
                "name" => "noorAccounts-create",
                "guard_name" => "web",
                "permission_category_id" => 29
            ],
            [
                "id" => 123,
                "display_name" => "تعديل",
                "name" => "noorAccounts-edit",
                "guard_name" => "web",
                "permission_category_id" => 29
            ],
            [
                "id" => 124,
                "display_name" => "حذف",
                "name" => "noorAccounts-delete",
                "guard_name" => "web",
                "permission_category_id" => 29
            ],
            [
                "id" => 125,
                "display_name" => "مشاهدة",
                "name" => "appointments-list",
                "guard_name" => "web",
                "permission_category_id" => 30
            ],
            [
                "id" => 126,
                "display_name" => "اضافة",
                "name" => "appointments-create",
                "guard_name" => "web",
                "permission_category_id" => 30
            ],
            [
                "id" => 127,
                "display_name" => "تعديل",
                "name" => "appointments-edit",
                "guard_name" => "web",
                "permission_category_id" => 30
            ],
            [
                "id" => 128,
                "display_name" => "حذف",
                "name" => "appointments-delete",
                "guard_name" => "web",
                "permission_category_id" => 30
            ],
            [
                "id" => 129,
                "display_name" => "مشاهدة",
                "name" => "transfers-list",
                "guard_name" => "web",
                "permission_category_id" => 31
            ],
            [
                "id" => 130,
                "display_name" => "اضافة",
                "name" => "transfers-create",
                "guard_name" => "web",
                "permission_category_id" => 31
            ],
            [
                "id" => 131,
                "display_name" => "تعديل",
                "name" => "transfers-edit",
                "guard_name" => "web",
                "permission_category_id" => 31
            ],
            [
                "id" => 132,
                "display_name" => "حذف",
                "name" => "transfers-delete",
                "guard_name" => "web",
                "permission_category_id" => 31
            ],
            [
                "id" => 133,
                "display_name" => "مشاهدة",
                "name" => "users-list",
                "guard_name" => "web",
                "permission_category_id" => 32
            ],
            [
                "id" => 134,
                "display_name" => "اضافة",
                "name" => "users-create",
                "guard_name" => "web",
                "permission_category_id" => 32
            ],
            [
                "id" => 135,
                "display_name" => "تعديل",
                "name" => "users-edit",
                "guard_name" => "web",
                "permission_category_id" => 32
            ],
            [
                "id" => 136,
                "display_name" => "حذف",
                "name" => "users-delete",
                "guard_name" => "web",
                "permission_category_id" => 32
            ]
        ];

        $roles=[
            [
                "id"=> 1,
                "display_name"=> "الأدارة",
                "name"=> "Admin",
                "color"=> "primary",
                "guard_name"=> "web"
            ],
            [
                "id"=> 3,
                "display_name"=> "محرر",
                "name"=> "editor",
                "color"=> "primary",
                "guard_name"=> "web"
            ],
            [
                "id"=> 13,
                "display_name"=> "مراقب",
                "name"=> "Supervisor",
                "color"=> "primary",
                "guard_name"=> "web"
            ],
            [
                "id"=> 14,
                "display_name"=> "مالي",
                "name"=> "mali",
                "color"=> "primary",
                "guard_name"=> "web"
            ],
            [
                "id"=> 15,
                "display_name"=> "مدير مدرسة",
                "name"=> "modir",
                "color"=> "primary",
                "guard_name"=> "web"
            ],
            [
                "id"=> 16,
                "display_name"=> "معلم",
                "name"=> "teacher",
                "color"=> "light text-dark",
                "guard_name"=> "web"
            ],
            [
                "id"=> 17,
                "display_name"=> "المقابلات",
                "name"=> "meet",
                "color"=> "success",
                "guard_name"=> "web"
            ],
            [
                "id"=> 18,
                "display_name"=> "اطلاع",
                "name"=> "view",
                "color"=> "info text-dark",
                "guard_name"=> "web"
            ],
            [
                "id"=> 19,
                "display_name"=> "ادارة الصلاحيات",
                "name"=> "roles",
                "color"=> "danger",
                "guard_name"=> "web"
            ],
            [
                "id"=> 20,
                "display_name"=> "مدير النظام",
                "name"=> "SuperAdmin",
                "color"=> "success",
                "guard_name"=> "web"
            ]
        ];
        $role_has_permissions = [
            [
                "permission_id"=> 1,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 1,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 1,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 1,
                "role_id"=> 19
            ],
            [
                "permission_id"=> 1,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 2,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 2,
                "role_id"=> 19
            ],
            [
                "permission_id"=> 2,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 3,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 3,
                "role_id"=> 19
            ],
            [
                "permission_id"=> 3,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 4,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 4,
                "role_id"=> 19
            ],
            [
                "permission_id"=> 4,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 5,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 5,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 5,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 5,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 6,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 6,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 7,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 7,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 8,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 8,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 9,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 9,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 9,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 9,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 9,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 9,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 10,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 10,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 11,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 11,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 12,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 12,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 13,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 13,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 13,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 13,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 13,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 13,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 14,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 14,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 14,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 15,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 15,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 15,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 16,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 16,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 17,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 17,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 17,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 17,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 17,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 17,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 17,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 18,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 18,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 18,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 18,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 18,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 19,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 19,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 19,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 20,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 20,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 21,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 22,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 22,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 22,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 22,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 23,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 23,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 23,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 24,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 24,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 25,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 25,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 25,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 25,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 25,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 25,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 26,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 26,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 27,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 27,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 28,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 28,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 29,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 29,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 29,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 29,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 29,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 29,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 30,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 30,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 31,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 31,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 32,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 32,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 33,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 33,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 33,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 33,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 33,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 33,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 34,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 34,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 35,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 35,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 36,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 36,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 37,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 37,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 37,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 37,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 37,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 37,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 38,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 38,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 39,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 39,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 40,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 40,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 41,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 41,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 41,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 41,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 41,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 41,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 42,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 42,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 43,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 43,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 44,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 44,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 45,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 45,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 45,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 45,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 45,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 45,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 46,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 46,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 46,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 47,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 47,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 48,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 48,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 49,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 49,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 49,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 49,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 49,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 49,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 50,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 50,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 50,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 51,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 51,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 51,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 51,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 52,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 52,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 53,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 53,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 53,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 53,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 53,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 53,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 54,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 54,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 55,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 55,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 56,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 56,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 57,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 57,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 57,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 57,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 57,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 57,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 57,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 58,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 58,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 59,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 59,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 59,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 60,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 60,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 61,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 61,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 61,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 61,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 61,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 61,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 61,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 62,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 62,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 63,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 63,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 64,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 64,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 65,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 65,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 65,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 65,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 65,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 65,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 66,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 66,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 67,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 67,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 68,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 68,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 69,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 69,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 69,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 69,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 69,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 69,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 69,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 70,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 70,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 70,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 70,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 70,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 71,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 71,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 71,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 71,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 71,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 72,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 73,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 73,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 73,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 73,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 73,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 73,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 73,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 74,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 74,
                "role_id"=> 13
            ],
            [
                "permission_id"=> 74,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 74,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 74,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 74,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 75,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 75,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 75,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 75,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 76,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 77,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 77,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 77,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 77,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 77,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 77,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 77,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 78,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 78,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 78,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 78,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 79,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 79,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 79,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 79,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 80,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 80,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 81,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 81,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 81,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 81,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 81,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 81,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 82,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 82,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 82,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 82,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 83,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 83,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 83,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 83,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 84,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 84,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 85,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 85,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 85,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 85,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 85,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 85,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 85,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 86,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 86,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 86,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 86,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 86,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 87,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 87,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 87,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 87,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 88,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 93,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 93,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 93,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 93,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 93,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 93,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 94,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 94,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 94,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 94,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 95,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 95,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 95,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 95,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 96,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 96,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 97,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 97,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 97,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 97,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 97,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 97,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 98,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 98,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 98,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 98,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 99,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 99,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 99,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 99,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 100,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 100,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 105,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 105,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 105,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 105,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 105,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 105,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 105,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 106,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 106,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 106,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 107,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 107,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 107,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 108,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 108,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 109,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 109,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 109,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 109,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 109,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 110,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 110,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 111,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 111,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 112,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 112,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 113,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 113,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 113,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 113,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 113,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 113,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 114,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 114,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 115,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 115,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 116,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 116,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 117,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 117,
                "role_id"=> 3
            ],
            [
                "permission_id"=> 117,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 117,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 117,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 117,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 118,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 118,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 118,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 119,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 119,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 119,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 120,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 120,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 121,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 121,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 121,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 121,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 121,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 122,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 122,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 123,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 123,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 124,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 124,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 125,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 125,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 125,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 125,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 125,
                "role_id"=> 17
            ],
            [
                "permission_id"=> 125,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 125,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 126,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 126,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 126,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 126,
                "role_id"=> 17
            ],
            [
                "permission_id"=> 126,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 127,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 127,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 127,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 127,
                "role_id"=> 17
            ],
            [
                "permission_id"=> 127,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 128,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 128,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 129,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 129,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 129,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 129,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 129,
                "role_id"=> 18
            ],
            [
                "permission_id"=> 129,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 130,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 130,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 130,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 130,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 130,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 131,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 131,
                "role_id"=> 14
            ],
            [
                "permission_id"=> 131,
                "role_id"=> 15
            ],
            [
                "permission_id"=> 131,
                "role_id"=> 16
            ],
            [
                "permission_id"=> 131,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 132,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 133,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 133,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 134,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 134,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 135,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 135,
                "role_id"=> 20
            ],
            [
                "permission_id"=> 136,
                "role_id"=> 1
            ],
            [
                "permission_id"=> 136,
                "role_id"=> 20
            ]
        ];
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permissions_categories')->truncate();
        DB::table('roles')->insert($roles);
        DB::table('role_has_permissions')->insert($role_has_permissions);
        DB::table('permissions_categories')->insert($permissionsCategory);
        DB::table('permissions')->insert($permissions);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        return Command::SUCCESS;
    }
}
