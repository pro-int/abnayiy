@extends('layouts.contentLayoutMaster')

@section('content')

<div class="container_table">
    <div class="pair_header">
        <h4>قائمة الدول</h4>
        <div class="btn-group pair_group_btn" role="group" aria-label="Basic outlined example">
            @can('countries-create')
            <a class="btn" href="{{ route('countries.create') }}"> اضافة دولة</a>
            @endcan

        </div>
    </div>

    <table class="table table-style">
        <thead class="add_posation">
            <tr class="table-light">
                <th scope="col">كود</th>
                <th scope="col">اسم الدولة</th>
                <th scope="col">كود الجوال</th>  
                <th scope="col">الحالة</th>  
                <th scope="col">الاجراءات المتاحة</th>

            </tr>
        </thead>

        <tbody>
            @foreach ($countries as $key => $country)
            <tr class="table-light">
                <th scope="row">
                    {{ $country->id }}
                </th>
                <td>{{ $country->country_name }}</td>
                <td>{{ $country->country_code }}</td>
                <td>{{ $country->active == 1 ? 'فعال' : 'غير مفعل' }}</td>
    
                <td>
                
                    <a class="btn btn-sm btn-info" href="{{ route('countries.show',$country->id) }}">مشاهدة</a>
                    
                    @can('countries-edit')
                    <a class="btn btn-sm btn-success" href="{{ route('countries.edit',$country->id) }}">تعديل</a>
                    @endcan
                    
                    @can('countries-delete')
                    @include('admin.inputs.buttons.delete',['route' => route('countries.destroy', $country->id)])
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