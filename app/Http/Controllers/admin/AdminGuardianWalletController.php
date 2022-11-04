<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers\admin;

use App\Exceptions\GeneralSystemsException;
use App\Http\Controllers\Controller;
use App\Models\guardian;
use App\Http\Requests\guardian\wallet\StoreGuardianWalletRequest;
use Bavix\Wallet\Exceptions\BalanceIsEmpty;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use Bavix\Wallet\Exceptions\InsufficientFunds;

class AdminGuardianWalletController extends Controller
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
    public function index(Request $request, guardian $guardian)
    {
        if (!$guardian->hasWallet(CREDIT_WALLET_SLUG)) {
            # create wallet if don't have
            $guardian->createWallet([
                'name' => CREDIT_WALLET,
                'slug' => CREDIT_WALLET_SLUG,
                'description' => CREDIT_WALLET_DISC,
                'meta' => ['color_class' => 'warning']
            ]);
        }
        $wallets =  $guardian->wallets;
        $transactions = $guardian->transactions()->orderBy('id', 'DESC')->paginate(config('view.PER_PAGE', 30));

        return view('admin.users.guardian.wallet.index', compact('wallets', 'guardian', 'transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, guardian $guardian)

    {
        $wallet = $guardian->getWallet($request->wallet);

        if (!$wallet) {
            return back()->with('alert-danger', 'المحفظة المطلوبة غير موجودة في حساب ولي الأمر');
        }

        $schools = ['deposit' => 'ايداع'];

        if ($wallet->slug == DEFAULT_WALLET_SLUG) {
            $schools = ['' => 'نوع العملية', 'withdraw' => 'سحب', 'deposit' => 'ايداع'];
        }
        return view('admin.users.guardian.wallet.create', compact('guardian', 'wallet', 'schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\guardian $guardian
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGuardianWalletRequest $request,  guardian $guardian)
    {
        $meta['user_name'] = $request->user()->getFullName();
        $meta['user_id'] = auth()->id();
        $meta['description'] = $request->description;

        if ($logo = $request->file('receipt')) {
            $path = $logo->storeAs(WALLET_RECEIPT_PATH, '/byAdmin-U' . auth()->id() . '-' . time() . '.' . $logo->getClientOriginalExtension(), 'public');
            $meta['file_path'] = $path;
        }


        try {
            $wallet = $guardian->getWallet($request->wallet);
            if ($request->transaction_type == 'deposit') {
                # deposit amount
                $wallet->depositFloat($request->amount, $meta);
                $msg = 'تم ايداع الرصيد بنجاح';
            } else if ($request->transaction_type == 'withdraw') {
                # deposit amount
                $wallet->withdrawFloat($request->amount, $meta);
                $msg = 'تم سحب الرصيد بنجاح';
            }
            return redirect()->route('guardians.wallets.index', $guardian->guardian_id)
                ->with('alert-success', $msg);
        } catch (InsufficientFunds | BalanceIsEmpty $th) {
            return redirect()->back()
                ->with('alert-danger',   $th->getMessage())->withInput();
        }
        return redirect()->back()
            ->with('alert-danger',  'خطأ غير متوقع اثناء الأضافة ..')->withInput();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(guardian $guardian, Wallet $wallet)
    {
        $transactions =  $guardian->getWallet($wallet->slug)->transactions()->where('wallet_id', $wallet->id)->orderBy('id', 'DESC')->paginate(config('view.PER_PAGE', 30));

        return view('admin.users.guardian.wallet.show', compact('transactions', 'guardian', 'wallet'));
    }
}
