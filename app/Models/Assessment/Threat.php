<?php

namespace App\Models\Assessment;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Management\AssetManagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Threat extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'asset_threat';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'asset_id',
        'threat_group',
        'threat_name',
        'status',

    ];

    public function asset()
    {
        return $this->belongsTo(AssetManagement::class, 'asset_id');
    }

    public function rmsd()
    {
        return $this->hasMany(RMSD::class, 'threat_id'); // Ensure the foreign key is asset_id
    }

    public function protection()
    {
        return $this->hasMany(Protection::class, 'threat_id'); // Ensure the foreign key is asset_id
    }

    public function treatment()
    {
        return $this->hasMany(Treatment::class, 'threat_id'); // Ensure the foreign key is asset_id
    }

 
}
