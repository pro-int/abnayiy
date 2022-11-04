@extends('layouts.contentLayoutMaster')

@section('content')
<div class="contanier_slider">

    <!-- start items -->
    <div class="pair_items">
        <div class="item">

            <div class="icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="text_content">
                <a href="{{ route('admins.index') }}">
                    <h4>ادارة</h4>
                    <p>المديرين</p>
                </a>
            </div>
        </div>

        <div class="item">
            <div class="icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="text_content">
                <a href="{{ route('teachers.index') }}">
                    <h4>ادارة</h4>
                    <p>المدرسيين</p>
                </a>
            </div>
        </div>

        <div class="item">
            <div class="icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="text_content">
                <a href="{{ route('guardians.index') }}">
                    <h4>ادارة</h4>
                    <p>اولياء الأمور</p>
                </a>
            </div>
        </div>

        <div class="item">
            <div class="icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="text_content">
                <a href="{{ route('roles.index') }}">
                    <h4>ادارة</h4>
                    <p>الصلاحيات</p>
                </a>
            </div>
        </div>

        
        <div class="item">
                <div class="icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('ApplicationManagers.index') }}">
                        <h4>ادارة</h4>
                        <p>مشرفين الطلبات</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('AttendanceManagers.index') }}">
                        <h4>ادارة</h4>
                        <p>مشرفين الغياب</p>
                    </a>
                </div>
            </div>
    </div>

</div>
@endsection