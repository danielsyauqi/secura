<?php

namespace App\Models\Assessment;

use Orchid\Screen\AsSource;
use App\Models\Assessment\Threat;
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
        'id',
        'threat_id',
        'protection_strategy',
        'protection_id',
        'decision'
    ];

    public function threat()
    {
        return $this->belongsTo(Threat::class, 'threat_id', 'id');
    }

    public function rmsd()
    {
        return $this->belongsTo(RMSD::class, 'threat_id', 'threat_id');
    }

    public function asset()
    {
        return $this->belongsTo(AssetManagement::class, 'threat_id', 'id')
            ->through('threat');
    }
}
