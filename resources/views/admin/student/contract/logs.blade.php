@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('students.contracts.logs',[$student_id,$contract]), 'name' => "سجل التعاقد"],['name'=> 'سجل التعاقد']],['title'=> 'ادارة سجل التعاقد']];
@endphp

@section('title', 'سجل التعاقد')

@section('content')


<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">سجل التعاقد </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">كود</th>
            <th scope="col">السجل</th>
            <th scope="col">بواسطة</th>
            <th scope="col">التاريخ</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($logs as $key => $log)

        <th>{{ $log['model_id'] }}</th>
        <td>{{ $log['message'] }}</td>
        <td><abbr title="{{ $log['created_by'] }}">{{ $log['user']->first_name.' '.$log['user']->last_name }}</abbr></td>
        <td><abbr title="{{ \Carbon\Carbon::createFromTimeString($log['created_at'])->format('Y-m-d H:m:s') }}">{{ \Carbon\Carbon::createFromTimeString($log['created_at'])->format('Y-m-d H:m:s') }}</abbr></td>

        </tr>
        @endforeach
        </tbody>
    </x-slot>

</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection

