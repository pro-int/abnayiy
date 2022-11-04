<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Http\Requests\bank\StoreBankRequest;
use App\Http\Requests\bank\UpdateBankRequest;
use App\Http\Requests\paymentNetwork\StorePaymentNetworkRequest;
use App\Http\Requests\paymentNetwork\UpdatePaymentNetworkRequest;
use App\Models\PaymentNetwork;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPaymentNetworkController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:accuonts-list|accuonts-create|accuonts-edit|accuonts-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:accuonts-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accuonts-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:accuonts-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $networks = PaymentNetwork::select('payment_networks.*', DB::raw('CONCAT(users.first_name, " " ,users.last_name) as admin_name'))
            ->leftjoin('users', 'users.id', 'payment_networks.add_by')
            ->get();

        return view('admin.paymentNetwork.index', compact('networks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.paymentNetwork.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\paymentNetwork\StorePaymentNetworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentNetworkRequest $request)
    {
        $paymentNetwork = PaymentNetwork::create($request->only(
            'network_name',
            'account_number',
            'active'
        ) + ['add_by' => Auth::id()]);

        if ($paymentNetwork) {
            return redirect()->route('payment_networks.index')
                ->with('alert-success', 'تم اضافة الشبكة بنجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء اضافة الشبكة');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentNetwork  $PaymentNetwork
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentNetwork $PaymentNetwork)
    {
        return view('admin.paymentNetwork.show', compact('PaymentNetwork'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentNetwork  $PaymentNetwork
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentNetwork $PaymentNetwork)
    {
        return view('admin.paymentNetwork.edit', compact('PaymentNetwork'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\paymentNetwork\StorePaymentNetworkRequest  $request
     * @param  \App\Models\PaymentNetwork  $PaymentNetwork
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentNetworkRequest $request, PaymentNetwork $PaymentNetwork)
    {
        $PaymentNetwork = $PaymentNetwork->update($request->only([
            'network_name',
            'account_number',
            'active'
        ]));

        if (!$PaymentNetwork) {
            return redirect()->back()
                ->with('alert-danger', 'خطأ اثناء تعديل معلومات الشبكة ');
        }

        return redirect()->route('payment_networks.index')
            ->with('alert-success', 'تم تعديل معلومات الشبكة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentNetwork  $PaymentNetwork
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentNetwork $PaymentNetwork)
    {
        if ($PaymentNetwork->delete()) {
            return redirect()->back()
                ->with('alert-success', 'تم حذف الشبكة ينجاح');
        }
        return redirect()->back()
            ->with('alert-danger', 'خطأ اثناء حذف  الشبكة ');
    }
}
