<?php

namespace App\Http\Controllers\Api;

use App\Models\Subscription;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Resources\SubscriptionResource;
use App\Models\Customer;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return SubscriptionResource::collection(
            Subscription::with(['customer', 'package'])
                ->latest()
                ->paginate()
        );
    }

    public function store(StoreSubscriptionRequest $request)
    {
        $data = $request->validated();

        $customer = Customer::findOrFail(
            $data['customer_id']
        );

        $pppoeUsername = 'ppp' . $customer->id;

        $pppoePassword = substr(
            md5(uniqid()),
            0,
            8
        );

        $package = \App\Models\Package::findOrFail(
            $data['package_id']
        );

        $mikrotikProfile =
            $package->mikrotik_profile ?? 'default';

        $config = new Config([
            'host' => '2.2.2.2',
            'user' => 'hegazy',
            'pass' => 'Gedo2010',
            'port' => 8728,
        ]);

        $client = new Client($config);

        $query = new Query('/ppp/secret/add');

        $query->equal('name', $pppoeUsername)
            ->equal('password', $pppoePassword)
            ->equal('service', 'pppoe')
            ->equal('profile', $mikrotikProfile);

        $client->query($query)->read();

        $data['pppoe_username'] = $pppoeUsername;
        $data['pppoe_password'] = $pppoePassword;
        $data['mikrotik_profile'] = $mikrotikProfile;

        $subscription = Subscription::create($data);

        return new SubscriptionResource(
            $subscription->load([
                'customer',
                'package'
            ])
        );
    }
    public function show(Subscription $subscription)
    {
        return new SubscriptionResource(
            $subscription->load(['customer', 'package'])
        );
    }

    public function update(
        StoreSubscriptionRequest $request,
        Subscription $subscription
    ) {
        $subscription->update(
            $request->validated()
        );

        return new SubscriptionResource(
            $subscription->load(['customer', 'package'])
        );
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return response()->json([
            'message' => 'Subscription deleted successfully'
        ]);
    }

    public function suspend(Subscription $subscription)
    {
        if (!$subscription->pppoe_username) {
            return response()->json([
                'message' => 'No PPPoE account linked'
            ], 400);
        }

        $config = new Config([
            'host' => '2.2.2.2',
            'user' => 'hegazy',
            'pass' => 'Gedo2010',
            'port' => 8728,
        ]);

        $client = new Client($config);

        $find = (new Query('/ppp/secret/print'))
            ->where('name', $subscription->pppoe_username);

        $secret = $client->query($find)->read();

        if (!count($secret)) {
            return response()->json([
                'message' => 'PPPoE user not found on MikroTik'
            ], 404);
        }

        $disable = (new Query('/ppp/secret/set'))
            ->equal('.id', $secret[0]['.id'])
            ->equal('disabled', 'yes');

        $client->query($disable)->read();

        $subscription->update([
            'status' => 'suspended'
        ]);

        return response()->json([
            'message' => 'Subscription suspended successfully'
        ]);
    }

    public function activate(Subscription $subscription)
    {
        if (!$subscription->pppoe_username) {
            return response()->json([
                'message' => 'No PPPoE account linked'
            ], 400);
        }

        $config = new Config([
            'host' => '2.2.2.2',
            'user' => 'hegazy',
            'pass' => 'Gedo2010',
            'port' => 8728,
        ]);

        $client = new Client($config);

        $find = (new Query('/ppp/secret/print'))
            ->where('name', $subscription->pppoe_username);

        $secret = $client->query($find)->read();

        if (!count($secret)) {
            return response()->json([
                'message' => 'PPPoE user not found on MikroTik'
            ], 404);
        }

        $enable = (new Query('/ppp/secret/set'))
            ->equal('.id', $secret[0]['.id'])
            ->equal('disabled', 'no');

        $client->query($enable)->read();

        $subscription->update([
            'status' => 'active'
        ]);

        return response()->json([
            'message' => 'Subscription activated successfully'
        ]);
    }
    public function availablePppoeUsers()
    {
        $client = new \RouterOS\Client(
            new \RouterOS\Config([
                'host' => '2.2.2.2',
                'user' => 'hegazy',
                'pass' => 'Gedo2010',
                'port' => 8728,
            ])
        );

        $users = $client
            ->query(new Query('/ppp/secret/print'))
            ->read();

        return response()->json(
            json_decode(
                json_encode($users, JSON_INVALID_UTF8_IGNORE),
                true
            )
        );
    }
    public function linkPppoe(
        Request $request,
        Subscription $subscription
    ) {
        $request->validate([
            'pppoe_username' => 'required'
        ]);

        $client = new Client(
            new Config([
                'host' => '2.2.2.2',
                'user' => 'hegazy',
                'pass' => 'Gedo2010',
                'port' => 8728,
            ])
        );

        $query = (new Query('/ppp/secret/print'))
            ->where(
                'name',
                $request->pppoe_username
            );

        $user = $client
            ->query($query)
            ->read();

        if (!count($user)) {
            return response()->json([
                'message' => 'PPPoE user not found'
            ], 404);
        }

        $subscription->update([
            'pppoe_username' =>
            $request->pppoe_username,

            'pppoe_password' =>
            $user[0]['password'] ?? null,

            'mikrotik_profile' =>
            $user[0]['profile'] ?? 'default',
        ]);

        return response()->json([
            'message' =>
            'PPPoE linked successfully'
        ]);
    }
}
