@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4>الاجزاء المنتهية</h4>
        <div class="btn-group pair_group_btn" role="group" aria-label="Basic outlined example">
        </div>
    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">رقم</th>
                <th scope="col">الأجراء</th>
                <th scope="col">يشمل</th>
                <th scope="col">الرابط</th>
            </tr>
        </thead>

        <tbody>
            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>تسجيل مدير جديد</td>
                <td>تسجيل الحساب لاول مرة فقط عندما لا يوجد مستخدمين</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('register') }}">الرابط</a></td>
            </tr>


            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>تسجيل الدخول </td>
                <td>تسجيل الدخول - التالكد من ان الحساب هو حساب مدير او مدرس فقط - </td>
                <td><a class="btn btn-sm btn-info" href="{{ route('login') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>تسجيل الخروج </td>
                <td>اجراء تسجيل الخروج- </td>
                <td>--</td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>ادارة المديرين</td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('admins.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>ادارة المدرسين</td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('teachers.index') }}">الرابط</a></td>
            </tr>


            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>ادارة مشرفين الغياب</td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('AttendanceManagers.index') }}">الرابط</a></td>
            </tr>


            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>ادارة مشرفين الطلبات</td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('ApplicationManagers.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>ادارة اولياء الأمور</td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('guardians.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>الادوار و الأذونات</td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('roles.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>السنوات الدراسية </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('years.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>الفصول الدراسية </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('years.semesters.index',['year'=> 2]) }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td>الانظمة الدراسية </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('types.index') }}">الرابط</a></td>
            </tr>



            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الانواع (بنين - بنات - مشترك) </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('genders.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> المراحل التعليمية </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('grades.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الصفوف التعليمية </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('levels.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الفصول الدراسية </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('classes.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الدول </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('countries.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الجنسيات </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('nationalities.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> ألفئات </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('categories.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> فترات السداد </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('periods.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> انظمة السداد </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('plans.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الخصومات </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('periods.discounts.index',1) }}">الرابط</a></td>
            </tr>


            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الطلبات </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('applications.index') }}">الرابط</a></td>
            </tr>

            <tr class="table-light">
                <th scope="row">
                    -
                </th>
                <td> الطلاب </td>
                <td>تعديل - حذف - اضافة - مشاهدة</td>
                <td><a class="btn btn-sm btn-info" href="{{ route('students.index') }}">الرابط</a></td>
            </tr>
            <!-- <th scope="row">
                    <img src="./assets/profile.png" alt="profile" width="40" height="40" class="profile-image" />
                </th> -->
        </tbody>
    </table>
</div>

@endsection
