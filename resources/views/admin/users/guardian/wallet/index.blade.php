@extends('layouts.contentLayoutMaster')

@php
$breadcrumbs = [[['link' => route('guardians.index'), 'name' => "اولياء الأمور"], ['link' => route('users.edit',$guardian->user->id), 'name' => $guardian->user->getFullName()], ['link' => route('guardians.wallets.index',$guardian->user->id), 'name' => 'المحافظ']],['title' => 'المحافظ المالية']];
@endphp

@section('title', 'المحافظ المالية - ولي الأمر | ' . $guardian->user->getFullName())

@section('content')

<section class="basic-timeline">
    <div class="row">
        @foreach ($wallets as $wallet)

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{!! sprintf('%s - الرصيد %s %s',$wallet->name, getBadge([getWalletMeta($wallet->meta,'color_class'), $wallet->balanceFloat]),$wallet->description ?? 'قابل للسحب' ) !!} </h4>

                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a class="btn btn-{{getWalletMeta($wallet->meta,'color_class')}} btn-sm waves-effect waves-float waves-light" href="{{ route('guardians.wallets.create',[$guardian->guardian_id, 'wallet'=> $wallet->slug]) }}">ايداع/سحب رصيد</a>

                        <a class="btn btn-outline-primary btn-sm waves-effect waves-float waves-light" href="{{ route('guardians.wallets.show',[$guardian->guardian_id, $wallet->id]) }}">تفاصيل</a>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>


    <div class="row">
        <div class="col-lg-12">
            @if(count($transactions))
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{!! sprintf('محفظة ولي الأمر (<span class="text-danger">%s</span>) - اجمالي الرصيد %s ', $guardian->user->getFullName(), $guardian->getbalance()) !!} </h4>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        @foreach($transactions as $transaction)

                        <li class="timeline-item timeline-point-{{ $transaction->type == 'deposit' ? 'success' : 'danger' }}">
                            <span class="timeline-point">
                                <em data-feather="dollar-sign"></em>
                            </span>
                            <div class="timeline-event">
                                <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
                                    <h6>{!! sprintf('<span class="text-%s">%s</span>',$transaction->type == 'deposit' ? 'success' : 'danger', getWalletMeta($transaction->meta, 'description')) !!}</h6>
                                    <span class="timeline-event-time"><abbr title="{{ $transaction->created_at }}">{{ $transaction->created_at->diffforHumans() }}</abbr></span>

                                </div>
                                <div class="d-flex justify-content-between flex-wrap flex-sm-row flex-column">
                                    <div>
                                        <p class="text-muted mb-50">المبلغ</p>
                                        <div class="d-flex align-items-center">
                                            {{ $transaction->amountFloat }} ر.س
                                        </div>
                                    </div>
                                    <div class="mt-sm-0 mt-1">
                                        <p class="text-muted mb-50">المستخدم</p>
                                        <p class="mb-0">{{ getWalletMeta($transaction->meta, 'user_name') }}</p>
                                    </div>
                                    <div class="mt-sm-0 mt-1">
                                        <p class="text-muted mb-50">المحفظة</p>
                                        <p class="mb-0"><span class="badge bg-{{ getWalletMeta($transaction->wallet->meta,'color_class') }}">{{ $transaction->wallet->name }}</span></p>
                                    </div>
                                    <div class="mt-sm-0 mt-1">
                                        <p class="text-muted mb-50">المرجع</p>
                                        @if($path = getWalletMeta($transaction->meta, 'file_path'))
                                        <x-inputs.btn.generic icon="paperclip" title="ايصال الدفع" colorClass="success btn-icon" :route="Storage::url($path)" />

                                        @elseif($url = getWalletMeta($transaction->meta, 'url'))
                                        <x-inputs.btn.generic icon="aperture" title="المرجع" colorClass="success  btn-icon" :route="$url" />
                                        @endif
                                    </div>
                                    <div class="mt-sm-0 mt-1">
                                        <p class="text-muted mb-50">الرصيد</p>
                                        <p class="mb-0"><span class="badge bg-{{ getWalletMeta($transaction->wallet->meta,'color_class') }}">{{ number_format($transaction->balance /100,2) }} ر.س</span></p>
                                    </div>
                                </div>
                            </div>

                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="d-flex align-self-center mx-0 row m-2 ">
                    <div class="col-md-12">
                        {{ $transactions->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
            @else
            <div class="d-flex justify-content-center">
                <div class="col-md-10">
                    <div class="card shadow-none bg-transparent border-warning">
                        <div class="card-body text-center">
                            <h4 class="card-title">لا توجد حركات مالية مسجلة </h4>
                            <p class="card-text">لم يتم العثور علي اي عمليات ايداع او سحب للأموال في حساب ولي الأمر.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection