@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4>{{ request()->target_user && request()->target_user == 'user' ? 'اشعارات المستخدم' : 'اشعارات الادارة' }}</h4>
        <div class="btn-group pair_group_btn" role="group" aria-label="Basic outlined example">
            @can('notifications-create')
            <a class="btn" href="{{ route('notifications.create') }}"> اضافة اشعار</a>
            @endcan

        </div>
    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">الوصف</th>
                <th scope="col">القسم</th>
                <th scope="col">المناسبة</th>
                <th scope="col">ارسال فوري</th>
                <th scope="col">الحالة</th>
                <th scope="col">الاجراءات المتاحة</th>
            </tr>
        </thead>

        <tbody>
            @foreach($internal_notifications as $notification)
            <tr class="table-light">
                <th scope="row">
                    {{ $notification->id }}
                </th>
                <td>{{ $notification->notification_name }}</td>
                <td>{{ $notification->section_name }}</td>
                <td>{{ $notification->event_name }}</td>
                <td>{{ $notification->fire_once_crated ? 'نعم' : 'لا' }}</td>
                <td>{{ $notification->active ? 'مفعل' : 'غير مفعل' }}</td>
                <td>
                    @can('notifications-edit')
                    <a class="btn btn-sm btn-success" href="{{ route('notifications.edit',$notification->id) }}">تعديل</a>
                    @endcan

                    @can('notifications-list')
                    <a class="btn btn-sm btn-info" href="{{ route('notifications.Settings',$notification->id) }}">اشعار المستخدم</a>
                    <a class="btn btn-sm btn-primary" href="{{ route('notifications.Settings',$notification->id) }}">اشعارات الأدارة</a>
                    @endcan
                    
                    @can('notifications-delete')
                    @include('admin.inputs.buttons.delete',['route' => route('notifications.destroy',$notification->id)])
                    @endcan
                    
                </td>
            </tr>
            @endforeach


        </tbody>
    </table>
</div>

@endsection