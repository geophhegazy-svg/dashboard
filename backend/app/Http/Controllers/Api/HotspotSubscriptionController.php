<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HotspotSubscription;
use App\Models\Customer;
use Illuminate\Http\Request;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;

class HotspotSubscriptionController extends Controller
{
    private function client()
    {
        return new Client(new Config(['host' => '2.2.2.2', 'user' => 'hegazy', 'pass' => 'Gedo2010', 'port' => 8728,]));
    }
    private function findHotspotUserId(
        $username
    ) {
        $query = (new Query('/ip/hotspot/user/print'))
            ->where('name', $username);

        $result = $this->client()
            ->query($query)
            ->read();

        if (!count($result)) {
            throw new \Exception(
                'Hotspot user not found'
            );
        }

        return $result[0]['.id'];
    }
    public function index()
    {
        return HotspotSubscription::with(['customer', 'package'])->latest()->paginate();
    }
    public function store(Request $request)
    {
        $data = $request->validate(['tenant_id' => 'required', 'customer_id' => 'required', 'package_id' => 'required', 'start_date' => 'required|date', 'end_date' => 'required|date', 'monthly_price' => 'required|numeric',]);
        $customer = Customer::findOrFail($data['customer_id']);
        $username = 'hs' . $customer->id;
        $password = substr(md5(uniqid()), 0, 8);
        $profile = 'default';
        $query = new Query('/ip/hotspot/user/add');
        $query->equal('name', $username)->equal('password', $password)->equal('profile', $profile);
        $this->client()->query($query)->read();
        $data['hotspot_username'] = $username;
        $data['hotspot_password'] = $password;
        $data['mikrotik_profile'] = $profile;
        $subscription = HotspotSubscription::create($data);
        return response()->json($subscription, 201);
    }
    public function show(HotspotSubscription $hotspotSubscription)
    {
        return $hotspotSubscription->load(['customer', 'package']);
    }
    public function destroy(HotspotSubscription $hotspotSubscription)
    {
        $hotspotSubscription->delete();
        return response()->json(['message' => 'Deleted']);
    }
    public function suspend(
        HotspotSubscription $hotspotSubscription
    ) {
        $query = (new Query('/ip/hotspot/user/set'))
            ->equal(
                '.id',
                $this->findHotspotUserId(
                    $hotspotSubscription->hotspot_username
                )
            )
            ->equal('disabled', 'yes');

        $this->client()
            ->query($query)
            ->read();

        $hotspotSubscription->update([
            'status' => 'suspended'
        ]);

        return response()->json([
            'message' => 'Hotspot subscription suspended'
        ]);
    }
    public function activate(
        HotspotSubscription $hotspotSubscription
    ) {
        $query = (new Query('/ip/hotspot/user/set'))
            ->equal(
                '.id',
                $this->findHotspotUserId(
                    $hotspotSubscription->hotspot_username
                )
            )
            ->equal('disabled', 'no');

        $this->client()
            ->query($query)
            ->read();

        $hotspotSubscription->update([
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'Hotspot subscription activated'
        ]);
    }
}
