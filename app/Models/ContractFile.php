<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

class ContractFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'file_path',
        'contract_id',
        'admin_id',
        'file_type',
    ];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            if (Storage::exists($item->file_path)) {
                Storage::unlink($item->file_path);
            }
        });
    }

    public function contract()
    {
        return $this->belongsTo(contract::class);
    }

    public function fileType($returnArray = false)
    {
        switch ($this->file_type) {
            case 'installment':
                $span['color'] = 'danger';
                $span['text'] = 'سند امر';
                break;
            case 'general':
                $span['color'] = 'success';
                $span['text'] = 'مرفقات عامة';
                break;
            default:
                $span['color'] = 'info';
                $span['text'] = 'غير محدد';
                break;
        }

        return $returnArray ? $returnArray : '<span class="badge bg-' . $span['color'] . '">' . $span['text'] . '</span>';
    }
}
