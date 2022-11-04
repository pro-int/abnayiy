<?php

/**
 * @author Amr Abd-Rabou
 * @author Amr Abd-Rabou <amrsoft13@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\guardian;
use Bavix\Wallet\Models\Transaction;
use Bavix\Wallet\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    /**
     * @param int $user
     * 
     */
    public function getUserWallet()
    {
        $user = guardian::find(auth()->id());
        try {
            $wallets = Wallet::where('holder_id', $user->guardian_id)->select('uuid', 'name', 'balance', 'slug', 'decimal_places', 'updated_at')->get();

            $balance = $user->balanceFloat;
            $total_balance = (float) $balance;
            $credit = 0;

            if ($user->hasWallet(CREDIT_WALLET_SLUG)) {
                $credit = $user->getWallet(CREDIT_WALLET_SLUG);
                $total_balance += (float) $credit->balanceFloat;
            }

            return $this->ApiSuccessResponse(['wallet' => [
                'balance' => $balance,
                'credit' => $credit->balanceFloat,
                'total_balance' =>  (float) $total_balance,
                'wallets' => $wallets
            ]]);
        } catch (\Throwable $th) {
            Log::debug($th);
            return $this->ApiErrorResponse('خطأ اثناء استعادة المعلومات');
        }
    }

    public function geWalletTransactions($wallet)
    {
        $wallet = Wallet::select([
            'id',
            'name',
            'slug',
            'uuid',
            'description',
            'meta',
            'balance',
            'decimal_places',
        ])->where('uuid', $wallet)->where('holder_id', auth()->id())->first();

        if ($wallet) {
            $transactions = Transaction::select([
                'uuid',
                'type',
                'meta',
                'amount',
                'balance',
                'created_at',
            ])->where('wallet_id', $wallet->id)->get();

            #wallet has been founded
            return $this->ApiSuccessResponse(['wallet' => $wallet, 'transaction' => $transactions]);
        }
        return $this->ApiErrorResponse('لم يتم العقور علي المعاومات المطلوبة', 404);
    }
}
