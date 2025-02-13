<?php

namespace App\Models\Assessment;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Assessment\Threat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RMSD extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'asset_rmsd';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'threat_id',
        'safeguard_id',
        'safeguard_group',
        'risk_level',
        'risk_owner',
        'business_loss',
        'impact_level',
        'vuln_group',
        'vuln_name',
        'likelihood',
        'scale_5',
        'business_loss_5',
        'impact_level_5',
        'likelihood_5',
        'risk_level_5',
    ];

    public function threat()
    {
        return $this->belongsTo(Threat::class, 'threat_id');
    }
}
