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
        'threat_id',
        'protection_strategy',
        'decision',
        'protection_id'


    ];

    public function threat()
    {
        return $this->belongsTo(Threat::class, 'threat_id');
    }
}
