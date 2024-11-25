<?php

namespace App\Models\Management;

use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class TeamMember extends Model
{
    use HasFactory, AsSource,Attachable;
    public $timestamps = false;
    protected $table = 'team_members';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'user_id',
        'sims_id',
        'job_function',
        'sector',
        'ra_function',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
