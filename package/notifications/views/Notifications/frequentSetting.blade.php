@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4> اشعارات {{ request()->target == 'user' ? 'المستخدم' : 'المدير' }}</h4>
        <div class="btn-group pair_group_btn" role="group" aria-label="Basic outlined example">
            @can('accuonts-create')
            <a class="btn" href="{{ route('notificationTypes.create') }}"> اضافة اشعار</a>
            @endcan

        </div>
    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">القسم</th>
                <th scope="col">الحدث</th>
                <th scope="col">نوع الاشعار</th>
                <th scope="col">ارسال فوري</th>
                <th scope="col">الحالة</th>
                <th scope="col">الاجراءات المتاحة</th>
            </tr>
        </thead>

        <tbody>
            @foreach($notifications as $notification)
            <tr class="table-light">
                <th scope="row">
                    {{ $notification->id }}
                </th>
                <td>{{ $notification->section_name }}</td>
                <td>{{ $notification->event_name }}</td>
                <td>{{ $notification->frequent }}</td>
                <td>{{ $notification->fire_once_crated ? 'نعم' : 'لا' }}</td>
                <td>{{ $notification->active ? 'مفعل' : 'غير مفعل' }}</td>
                <td>
                    @if($notification->getRawOriginal('frequent') == 'frequent')
                    <a class="btn btn-sm btn-info" href="{{ route('notificationTypes.create') }}">ادارة التكرار</a>
                    @endif

                    @can('countries-edit')
                    <a class="btn btn-sm btn-success" href="{{ route('notificationTypes.create') }}">تعديل</a>
                    @endcan

                    @include('admin.inputs.buttons.delete',['route' => route('notificationTypes.create')])
                
                </td>
            </tr>
            @endforeach


        </tbody>
    </table>
</div>

@endsection