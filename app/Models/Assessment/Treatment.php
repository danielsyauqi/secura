<?php

namespace App\Models\Assessment;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Management\AssetManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treatment extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'asset_treatment';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'asset_id',
        'treatment',
        'personnel',
        'start_date',
        'end_date',
        'residual_risk',
    ];

    public function asset()
    {
        return $this->belongsTo(AssetManagement::class, 'asset_id');
    }
}
