<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use RouterOS\Client;
use RouterOS\Config;
use RouterOS\Query;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\HotspotSubscription;
use App\Models\Invoice;

class MikrotikController extends Controller
{
    private function client()
    {
        return new Client(
            new Config([
                'host' => '2.2.2.2',
                'user' => 'hegazy',
                'pass' => 'Gedo2010',
                'port' => 8728,
            ])
        );
    }
    

    public function pppoeUsers()
    {
        $query = new Query('/ppp/secret/print');

        $users = $this->client()
            ->query($query)
            ->read();

        return response()->json($users);
    }
    public function createPppoeUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'profile'  => 'required',
        ]);

        $query = new Query('/ppp/secret/add');

        $query->equal('name', $request->username);
        $query->equal('password', $request->password);
        $query->equal('profile', $request->profile);
        $query->equal('service', 'pppoe');

        $this->client()
            ->query($query)
            ->read();

        return response()->json([
            'message' => 'PPPoE user created successfully'
        ]);
    }
    public function hotspotUsers()
    {
        $query = new Query('/ip/hotspot/user/print');

        $users = $this->client()
            ->query($query)
            ->read();

        foreach ($users as &$user) {

            foreach ($user as $key => $value) {

                if (is_string($value)) {

                    $converted = @iconv(
                        'Windows-1256',
                        'UTF-8//IGNORE',
                        $value
                    );

                    if ($converted !== false) {
                        $user[$key] = $converted;
                    }
                }
            }
        }


        foreach ($users as $index => $user) {

            foreach ($user as $key => $value) {

                if (!is_string($value)) {
                    continue;
                }

                if (!mb_check_encoding($value, 'UTF-8')) {

                    dd([
                        'index' => $index,
                        'field' => $key,
                        'value' => $value,
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'count'   => count($users),
            'data'    => $users
        ]);
    }
    public function createHotspotUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'profile'  => 'nullable'
        ]);

        $client = $this->client();

        $query = (new \RouterOS\Query('/ip/hotspot/user/add'))
            ->equal('name', $request->username)
            ->equal('password', $request->password)
            ->equal(
                'profile',
                $request->profile ?? 'default'
            );

        $client->query($query)->read();

        return response()->json([
            'message' => 'Hotspot user created'
        ]);
    }
    public function deleteHotspotUser($username)
    {
        $client = $this->client();

        $find = (new \RouterOS\Query('/ip/hotspot/user/print'))
            ->where('name', $username);

        $user = $client->query($find)->read();

        if (!count($user)) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $remove = (new \RouterOS\Query('/ip/hotspot/user/remove'))
            ->equal('.id', $user[0]['.id']);

        $client->query($remove)->read();

        return response()->json([
            'message' => 'User deleted'
        ]);
    }
    public function activeUsers()
    {
        $query = new Query('/ip/hotspot/active/print');

        $users = $this->client()
            ->query($query)
            ->read();

        return response()->json(
            json_decode(
                json_encode($users, JSON_INVALID_UTF8_IGNORE),
                true
            )
        );
    }
    public function suspendHotspotUser($username)
    {
        $client = $this->client();

        $find = (new Query('/ip/hotspot/user/print'))
            ->where('name', $username);

        $user = $client->query($find)->read();

        if (!count($user)) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $disable = (new Query('/ip/hotspot/user/set'))
            ->equal('.id', $user[0]['.id'])
            ->equal('disabled', 'yes');

        $client->query($disable)->read();

        return response()->json([
            'message' => 'Hotspot user suspended'
        ]);
    }
    public function activateHotspotUser($username)
    {
        $client = $this->client();

        $find = (new Query('/ip/hotspot/user/print'))
            ->where('name', $username);

        $user = $client->query($find)->read();

        if (!count($user)) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $enable = (new Query('/ip/hotspot/user/set'))
            ->equal('.id', $user[0]['.id'])
            ->equal('disabled', 'no');

        $client->query($enable)->read();

        return response()->json([
            'message' => 'Hotspot user activated'
        ]);
    }
    public function dashboardStats()
    {
        $stats = [
            'customers' => Customer::count(),

            'active_pppoe' => Subscription::where(
                'status',
                'active'
            )->count(),

            'active_hotspot' => HotspotSubscription::where(
                'status',
                'active'
            )->count(),

            'pending_invoices' => Invoice::where(
                'status',
                'pending'
            )->count(),

            'paid_invoices' => Invoice::where(
                'status',
                'paid'
            )->count(),

            'monthly_revenue' => Invoice::where(
                'status',
                'paid'
            )
                ->whereMonth('paid_at', now()->month)
                ->sum('amount'),
        ];

        return response()->json($stats);
    }
}
