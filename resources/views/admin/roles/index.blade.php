@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4>المستويات الادارية</h4>
        <div class="btn-group pair_group_btn" role="group" aria-label="Basic outlined example">
            @can('role-create')
            <a class="btn" href="{{ route('roles.create') }}"> اضافة دور</a>
            @endcan

        </div>
    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">الاسم عربي</th>
                <th scope="col">الاسم انجليزي</th>
                <th scope="col">الاجراءات المتاحة</th>
               
            </tr>
        </thead>

        <tbody>
            @foreach ($roles as $key => $role)
            <tr class="table-light">
                <th scope="row">
                    {{ $role->id }}
                </th>
                <td><span class="badge badge-{{$role->color}}">{{ $role->display_name }}</span></td>
                <td>{{ $role->name }}</td>

                <td>
                    @can('role-edit')
                    <a class="btn btn-sm btn-success" href="{{ route('roles.edit',$role->id) }}">تعديل</a>
                    @endcan
                
                <a class="btn btn-sm btn-info" href="{{ route('roles.show',$role->id) }}">مشاهدة</a>
               
                    @can('role-delete')
                    @include('admin.inputs.buttons.delete',['route' => route('roles.destroy', $role->id)])
                    @endcan
                </td>

            </tr>
            @endforeach

            <!-- <th scope="row">
                    <img src="./assets/profile.png" alt="profile" width="40" height="40" class="profile-image" />
                </th> -->


        </tbody>
    </table>
</div>

@endsection