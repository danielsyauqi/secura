<?php

namespace App\Models;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrgProfile extends Model
{
    use HasFactory, AsSource, Attachable;
    protected $table = 'org_profile';
    public $timestamps = false;
    protected $primaryKey = 'id';

    
    protected $fillable = [
        'name',
    ];

    protected $allowedSorts = [
        'name',
       
    ];


 

}

