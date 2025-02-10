<?php

namespace App\Models\Management;

use Orchid\Screen\AsSource;
use App\Models\Assessment\Threat;
use Orchid\Attachment\Attachable;
use Laravel\Scout\Searchable;
use App\Models\Assessment\Valuation;
use App\Orchid\Presenters\AssetManagementPresenter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetManagement extends Model
{
    use HasFactory, AsSource, Attachable, Searchable;

    protected $table = 'asset_management';
    protected $primaryKey = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    protected $searchable = [
        'name',
        'type',
        'location',
        'custodian',
        'owner',
        'description',
    ];

    protected $fillable = [
        'name',
        'quantity',
        'description',
        'location',
        'custodian',
        'created_at',
        'updated_at',
        'type',
        'secura_id',
        'owner',
        'status',
    ];

    protected $allowedSorts = [
        'name',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the presenter instance for the model.
     */
    public function presenter()
    {
        return new AssetManagementPresenter($this);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'location' => $this->location,
            'custodian' => $this->custodian,
            'owner' => $this->owner,
            'description' => $this->description,
        ];
    }

    /**
     * Get the value used to index the model.
     */
    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    /**
     * Get the key name used to index the model.
     */
    public function getScoutKeyName(): mixed
    {
        return 'id';
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return true;
    }

    public function valuation()
    {
        return $this->hasOne(Valuation::class, 'asset_id');
    }

    public function threats()
    {
        return $this->hasMany(Threat::class, 'asset_id');
    }
}
