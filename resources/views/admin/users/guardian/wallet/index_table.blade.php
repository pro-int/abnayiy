@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"], ['link' => route('users.edit',$guardian->user->id), 'name' => $guardian->user->getFullName()], ['link' => route('guardians.wallets.index',$guardian->user->id), 'name' => 'المحافظ']],['title' => 'تاريخ الحركات المالية']];
@endphp

@section('title', 'تاريخ الحركات المالية ولي الأمر | ' . $guardian->user->getFullName())

@section('content')

<div class="row">
    @foreach ($wallets as $wallet)
    <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{!! sprintf('%s - الرصيد (%s) <span class="text-danger">%s</span>',$wallet->name, getBadge(['success', $wallet->balanceFloat]),$wallet->description ?? 'قابل للسحب' ) !!} </h4>
        <a class="btn btn-outline-primary btn-sm btn-initialize" href="{{ route('guardians.wallets.show',[$guardian->guardian_id, $wallet->id]) }}">التفاصيل</a>
      </div>
    
    </div>
</div>
@endforeach
</div>

<!-- Striped rows start -->
<x-ui.table>
    <x-slot name="title">تفاصيل الحركات المالية الخاصة بـ ولي الأمر  <span class="text-danger">{{ $guardian->user->getFullName() }}</span> </x-slot>
    <x-slot name="cardbody">لدي كل ولي امر محفظة تحتوي علي الرصيد المالي القابل للسحب ومحفظة اخري تحتوي علي الرصيد الترويجي الذي يمكنة استخدامة ولا يمكن سحبة</x-slot>
    <x-slot name="button">
    <x-inputs.link route="guardians.index">عودة</x-inputs.link>

    </x-slot>

    <x-slot name="thead">
        <tr>
            <th scope="col">رقم الحركة</th>
            <th scope="col">المحفظة</th>
            <th scope="col">وصف الحركة</th>
            <th scope="col">المبلغ</th>
            <th scope="col">الاجراء</th>
            <th scope="col">ملاحظات</th>
            <th scope="col">المرجع</th>
            <th scope="col">المستخدم</th>
            <th scope="col">تاريخ الحركة</th>
        </tr>
    </x-slot>

    <x-slot name="tbody">
        @foreach ($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->wallet->name }}</td>
            <td>{{ getWalletMeta($transaction->meta, 'description') }}</td>
            <td>{{ $transaction->amountFloat . ' ر.س' }}</td>
            <td>{!! getBadge([$transaction->type == 'deposit' ? 'success' : 'danger', $transaction->type == 'deposit' ? 'اضافة' : 'خصم']) !!}</td>
            <td>{{ getWalletMeta($transaction->meta, 'reason') }}</td>
            <td>
                @if($url = getWalletMeta($transaction->meta, 'url')) 
                <x-inputs.btn.generic icon="aperture" title="المرجع" colorClass="info btn-icon" :route="$url" />
                @endif
            </td>
            <td>{{ getWalletMeta($transaction->meta, 'admin_name') }}</td>
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
