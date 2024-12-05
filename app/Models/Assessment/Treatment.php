<?php

namespace App\Models\Assessment;

use Orchid\Screen\AsSource;
use App\Models\Assessment\Threat;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treatment extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'asset_treatment';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'threat_id',
        'treatment',
        'personnel',
        'start_date',
        'end_date',
        'residual_risk',
        'scale_5',

    ];

    public function threat()
    {
        return $this->belongsTo(Threat::class, 'threat_id');
    }
}
