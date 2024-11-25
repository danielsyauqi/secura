<?php

namespace App\Models\Management;

use Orchid\Screen\AsSource;
use App\Models\Assessment\Threat;
use Orchid\Attachment\Attachable;
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

    ];

    protected $allowedSorts = [
        'name',
        'created_at',
        'updated_at'
    ];

 

}

