<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Traits\HasWallets;

class guardian extends Model implements Wallet, WalletFloat
{
    use HasFactory, LogsActivity;
    use HasWalletFloat;
    use HasWallets;

    protected $primaryKey = "guardian_id";

    protected $fillable = [
        'guardian_id',
        'nationality_id',
        'national_id',
        'address',
        'city_name',
        'category_id',
        'points_balance',
        'active',
        'odoo_record_id',
        'odoo_sync_status',
        'odoo_message',
    ];

    private $guardian;

    private $enableOdooIntegration = true;

    private $odooIntegrationKeys = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
        // Chain fluent methods for configuration options
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function (guardian $guardian) {
            $guardian->setOdooKeys($guardian);
            if (!$guardian->hasWallet(CREDIT_WALLET_SLUG)) {
                $guardian->createWallet([
                    'name' => CREDIT_WALLET,
                    'slug' => CREDIT_WALLET_SLUG,
                    'description' => CREDIT_WALLET_DISC,
                    'meta' => ['cololr_class' => 'warning']
                ]);
            }
        });

        self::updating(function ($guardian) {
            if ($guardian->isDirty('points_balance')) {

                $current_category = Category::find($guardian->category_id);
                if ($current_category && !$current_category->is_fixed) {
                    # no cetegory or category not fixed
                    $category = Category::where('is_fixed', false)
                        ->where('required_points', '<=', $guardian->points_balance)
                        ->orderBy('required_points', 'DESC')
                        ->where('active', true)
                        ->first() ?? Category::orderBy('required_points')->where('active', true)->where('is_fixed', false)->first();
                    if ($category) {
                        $guardian->category_id = $category->id;
                    }
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'guardian_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'guardian_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    /**
     * get guardian category.
     * @param int $guardian_id
     * @return App\Models\Category
     */
    public static function getCategory($guardian_id)
    {
        $guardian = guardian::find($guardian_id);
        if ($guardian && null !== $guardian->category_id) {
            return Category::find($guardian->category_id);
        }
        return Category::where('is_default', true)->first();
    }

    /**
     * get guardian category.
     * @param int $guardian_id
     * @return App\Models\guardian
     */
    public static function guardians($guardian_id)
    {
        return guardian::where('guardian_id', $guardian_id)->first();
    }

    public function getbalance($type = 'balanceFloat')
    {
        $balance = $this->$type;
        if ($this->hasWallet(CREDIT_WALLET_SLUG)) {
            $balance += $this->getWallet(CREDIT_WALLET_SLUG)->$type;
        }

        if ($balance > 0) {
            $class = 'success';
        } else if ($balance < 0) {
            $class = 'danger';
        } else {
            return '';
        }

        return getBadge([$class, $balance . ' ر.س']);
    }

    public function setOdooKeys(guardian $guardian)
    {
        $this->odooIntegrationKeys["name"] =  $guardian->user()->first()->getFullName();
        $this->odooIntegrationKeys["guardian_id"] = $guardian->guardian_id;
        $this->odooIntegrationKeys["guardian_national_id"] = $guardian->national_id;
        $this->odooIntegrationKeys["student_id"] = null;
        $this->odooIntegrationKeys["student_national_id"] = null;
        $this->odooIntegrationKeys["is_company"] = "True";
    }

    public function getOdooKeys(){
        return $this->odooIntegrationKeys;
    }

    public function getEnableOdooIntegration(){
        return $this->enableOdooIntegration;
    }
}
