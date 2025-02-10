<?php

namespace App\Models\Management;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;


class SecuraManagement extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'secura_management';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'name',
        'standard_num',
        'scope_definition',
        'approval_date',
        'approval_attachment',
        'image_logo',

    ];



}

