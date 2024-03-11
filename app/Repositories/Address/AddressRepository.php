<?php

namespace App\Repositories\Address;

use App\Models\Address;
use App\Http\Controllers\Controller;
use App\Models\UserAddress;

class AddressRepository extends Controller implements AddressInterface
{
    private Address $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function get($request)
    {
        // TODO: Implement get() method.
    }

    public function getById($id)
    {
        return $this->address::find($id);
    }

    public function store($request)
    {
        return $this->address::firstOrCreate($request);
    }

    public function update($request, $id)
    {
        $this->address::find($id)->fill($request)->save();
    }

    public function destroy($id)
    {
        $this->address::find($id)->delete();
    }

    public function saveAddressUser($user_id, $addressData)
    {
        $userAddress = UserAddress::firstOrNew(['user_id' => $user_id]);

        $address = $userAddress->address ?? new Address();
        $address->fill($addressData);
        $address->save();

        $userAddress->address_id = $address->id;
        $userAddress->save();

        return $address;
    }
}
