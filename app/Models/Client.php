<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Client
 * @package App
 */
class Client extends Model
{
    protected $appends = ['totalUser'];

    protected $fillable = [
        'client_name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'phone_no1',
        'phone_no2',
        'latitude',
        'longitude',
        'zip',
        'start_validity',
        'end_validity',
        'status'
    ];

    const STATUS_ACTIVE = 'Active';

    const STATUS_INACTIVE = 'Inactive';

    const ALLOWED_FILTERS = [
        'id',
        'client_name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'phone_no1',
        'phone_no2',
        'zip',
        'start_validity',
        'end_validity',
        'status'
    ];

    const ALLOWED_SORTS = [
        'id',
        'client_name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'phone_no1',
        'phone_no2',
        'zip',
        'start_validity',
        'end_validity',
        'status'
    ];

    const PER_PAGE = 10;

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @param $value
     * @return int[]
     */
    public function getTotalUserAttribute($value): array
    {
        $result = [
            "all" => 0,
            "active" => 0,
            "inactive" => 0
        ];

        $totalUser = User::where('client_id',$this->id)->get();
        $result['all'] = $totalUser->count();
        $result['active'] = $totalUser->where('status','Active')->count();
        $result['inactive'] = $totalUser->where('status','Inactive')->count();

        return $result;
    }
}
