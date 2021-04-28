<?php

namespace App\Repositories\Clients;

use App\Exceptions\ErrorException;
use App\Repositories\Locations\LocationRepositoryInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redis;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Hash;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class ClientRepository
 * @package App\Http\Repository
 */
class ClientRepository implements ClientRepositoryInterface
{
    /**
     * @var LocationRepositoryInterface
     */
    private LocationRepositoryInterface $locationRepository;

    /**
     * ClientRepository constructor.
     * @param LocationRepositoryInterface $locationRepository
     */
    function __construct(LocationRepositoryInterface $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
     * @throws ErrorException
     */
    public function store(array $data)
    {
        $geoCoordinates = $this->getGeoCoordinates($data);
        DB::beginTransaction();
        try {
            $client = Client::create([
                'client_name' => $data['name'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'city' => $data['city'],
                'state' => $data['state'],
                'country' => $data['country'],
                'latitude' => $geoCoordinates['lat'],
                'longitude' => $geoCoordinates['lng'],
                'phone_no1' => $data['phoneNo1'],
                'phone_no2' => $data['phoneNo2'],
                'zip' => $data['zipCode'],
                'start_validity' => Carbon::now(),
                'end_validity' => Carbon::now()->add(15, 'days'),
                'status' => Client::STATUS_INACTIVE
            ]);

            Redis::set("user_$client->id", json_encode(['latitude' => 11, 'longitute' => -2]));

            User::create([
                'client_id' => $client->id,
                'first_name' => $data['user']['firstName'],
                'last_name' => $data['user']['lastName'],
                'email' => $data['user']['email'],
                'password' => Hash::make($data['user']['password']),
                'phone' => $data['user']['phone'],
                'last_password_reset' => Carbon::now(),
                'status' => User::STATUS_INACTIVE
            ]);
        } catch (Exception $e) {
            DB::rollback();
            throw new ErrorException('exception.internal_server_error');
        }
        DB::commit();
        return $client;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAll(): LengthAwarePaginator
    {
        return QueryBuilder::for(Client::class)
            ->allowedFilters(Client::ALLOWED_FILTERS)
            ->allowedSorts(Client::ALLOWED_SORTS)
            ->paginate(Client::PER_PAGE);
    }

    /**
     * @param array $data
     * @return string[]
     */
    public function buildGetGeoCoordinatesParams(array $data): array
    {
        return [
            'address' => "{$data['address1']} {$data['address2']} {$data['city']} {$data['state']} {$data['country']} {$data['zipCode']}"
        ];
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getGeoCoordinates(array $data)
    {
        return $this->locationRepository->getGeographicCoordinates($this->buildGetGeoCoordinatesParams($data));
    }
}
