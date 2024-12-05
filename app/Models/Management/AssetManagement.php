<?php

namespace App\Models\Management;

use Orchid\Screen\AsSource;
use App\Models\Assessment\Threat;
use Orchid\Attachment\Attachable;
use App\Models\Assessment\Valuation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AssetManagement extends Model
{
    use HasFactory, AsSource,Attachable;
    protected $table = 'asset_management';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'name',
        'quantity',
        'description',
        'location',
        'custodian',
        'created_at',
        'updated_at',
        'type',
        'sims_id',
        'owner',
        'status',


    ];

    protected $allowedSorts = [
        'name',
        'created_at',
        'updated_at'
    ];

    public function valuation()
    {
        return $this->hasOne(Valuation::class, 'asset_id'); // Ensure the foreign key is asset_id
    }

    // Relationship with Threat
    public function threats()
    {
        return $this->hasMany(Threat::class, 'asset_id'); // Adjust 'asset_id' to match your foreign key
    }
 

}

