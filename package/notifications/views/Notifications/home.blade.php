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
                    <a href="{{ route('notifications.index') }}">
                        <h4>اادارة</h4>
                        <p>اشعارات المسجلة</p>
                    </a>
                </div>
            </div>
            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('contents.index') }}">
                        <h4>اادارة</h4>
                        <p>محتوي الأشعارات</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('channels.index') }}">
                        <h4>اادارة</h4>
                        <p>قنوات الأرسال</p>
                    </a>
                </div>
            </div>

            <div class="item">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="text_content">
                    <a href="{{ route('sections.index') }}">
                        <h4>اادارة</h4>
                        <p>اقسام الأشعارات</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection