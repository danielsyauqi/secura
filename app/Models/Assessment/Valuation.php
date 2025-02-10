<?php

namespace App\Models\Assessment;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Management\AssetManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valuation extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'asset_valuation';

    protected $primaryKey = 'id';


    protected $fillable = [
        'asset_id',
        'depend_on',
        'depended_asset',
        'confidential',
        'integrity',
        'availability',
        'asset_value',
        'scale_5',
        'confidential_5',
        'integrity_5',
        'availability_5',
        'asset_value_5',
    ];

    public function asset()
    {
        return $this->belongsTo(AssetManagement::class, 'asset_id');
    }
}
