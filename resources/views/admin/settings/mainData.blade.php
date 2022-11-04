@extends('layouts.contentLayoutMaster')

@section('content')
<div class="contanier_slider">
    <div class="container">
        <!-- start items -->

        <div class="pair_items">

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('years.index') }}">
                        <h4>اادارة</h4>
                        <p>السنوات الدراسية</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('types.index') }}">
                        <h4>اادارة</h4>
                        <p>الانظمة التعليمية</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('genders.index') }}">
                        <h4>اادارة</h4>
                        <p>الانواع</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('grades.index') }}">
                        <h4>اادارة</h4>
                        <p>المراحل الدراسية</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('levels.index') }}">
                        <h4>اادارة</h4>
                        <p>الصفوف الدراسية</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('classes.index') }}">
                        <h4>اادارة</h4>
                        <p>الفصول الدراسية</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('countries.index') }}">
                        <h4>اادارة</h4>
                        <p>االدول</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('nationalities.index') }}">
                        <h4>اادارة</h4>
                        <p>الجنسيات</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('categories.index') }}">
                        <h4>اادارة</h4>
                        <p>تصنيفات العملاء</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('plans.index') }}">
                        <h4>اادارة</h4>
                        <p>خطط الدفع</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('periods.index') }}">
                        <h4>اادارة</h4>
                        <p>افترات السداد</p>
                    </a>
                </div>
            </div>

            
            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('transportations.index') }}">
                        <h4>اادارة</h4>
                        <p>خطط النقل</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('coupons.index') }}">
                        <h4>اادارة</h4>
                        <p>قسائم الخصم</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('subjects.index') }}">
                        <h4>اادارة</h4>
                        <p>المواد الدراسية</p>
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('banks.index') }}">
                        <h4>اادارة</h4>
                        <p>البنوك</p>
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('appointments.sections.index') }}">
                        <h4>اادارة</h4>
                        <p>الأقسام</p>
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('appointments.reserved.index') }}">
                        <h4>اادارة</h4>
                        <p>اقسام المقابلات</p>
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('contract_terms.index') }}">
                        <h4>اادارة</h4>
                        <p>شروط واحكام العقد</p>
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('contract_design.edit') }}">
                        <h4>اادارة</h4>
                        <p>تصميمات العقود</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
