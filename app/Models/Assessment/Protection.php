<?php

namespace App\Models\Assessment;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Management\AssetManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Protection extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'asset_protection';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'asset_id',
        'recommend',
        'protection_strategy',
        'others',
        'decision',

    ];

    public function asset()
    {
        return $this->belongsTo(AssetManagement::class, 'asset_id');
    }
}
