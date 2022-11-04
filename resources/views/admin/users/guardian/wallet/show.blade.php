@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"], ['link' => route('users.edit',$guardian->user->id), 'name' => $guardian->user->getFullName()], ['link' => route('guardians.wallets.index',$guardian->user->id), 'name' => 'المحافظ'], [ 'name' => sprintf('سجل المحفظة (%s)',$wallet->name)]],['title' => 'تاريخ الحركات المالية']];
@endphp

@section('title', sprintf('تفاصيل الحركات المالية ولي الأمر %s - المحفظة %s', $guardian->user->getFullName() , $wallet->name))

@section('content')

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">{!! sprintf('تفاصيل الحركات المالية للمحفظة <span class="text-danger">(%s)</span> ولي الأمر <span class="text-danger">(%s)</span>' ,$wallet->name ,$guardian->user->getFullName()) !!}</x-slot>
    <x-slot name="cardbody">يمكنك ادناة الأطلاع علي تفاصيل الحركات المالية للمحفظة </x-slot>
    <x-slot name="button">
        <a class="btn btn-primary mb-1" href="{{ route('guardians.wallets.create',[$guardian->guardian_id, 'wallet'=> $wallet->slug]) }}">
            <em data-feather='plus-circle'></em> اضافة / سحب </a>
    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">رقم الحركة</th>
            <th scope="col">وصف الحركة</th>
            <th scope="col">المبلغ</th>
            <th scope="col">الاجراء</th>
            <th scope="col">ملاحظات</th>
            <th scope="col">المرجع</th>
            <th scope="col">الرصيد</th>
            <th scope="col">المستخدم</th>
            <th scope="col">تاريخ الحركة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ getWalletMeta($transaction->meta, 'description') }}</td>
            <td>{{ $transaction->amountFloat . ' ر.س' }}</td>
            <td>{!! getBadge([$transaction->type == 'deposit' ? 'success' : 'danger', $transaction->type == 'deposit' ? 'اضافة' : 'خصم']) !!}</td>
            <td>{{ getWalletMeta($transaction->meta, 'description') }}</td>
            <td>
                @if($path = getWalletMeta($transaction->meta, 'file_path'))
                <x-inputs.btn.generic icon="paperclip" title="ايصال الدفع" colorClass="danger btn-icon" :route="Storage::url($path)" />

                @elseif($url = getWalletMeta($transaction->meta, 'url'))
                <x-inputs.btn.generic icon="aperture" title="المرجع" colorClass="primary btn-icon" :route="$url" />
                @endif
            </td>
            <td>{{ number_format($transaction->balance /100,2) }} ر.س</td>
            <td>{{ getWalletMeta($transaction->meta, 'user_name') }}</td>
            <td>{{ $transaction->created_at }}</td>
        </tr>
        @endforeach
        </tbody>
    </x-slot>

    <x-slot name="pagination">
        {{ $transactions->appends(request()->except('page'))->links() }}
    </x-slot>
</x-ui.table>
<x-ui.SideDeletePopUp />

<!-- Striped rows end -->
@endsection