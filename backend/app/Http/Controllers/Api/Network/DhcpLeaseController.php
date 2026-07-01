<?php

namespace App\Http\Controllers\Api\Network;

use App\Http\Controllers\Controller;
use RouterOS\Client;
use RouterOS\Query;
use Illuminate\Http\JsonResponse;

class DhcpLeaseController extends Controller
{
    protected function client(): Client
    {
        return app(Client::class);
    }

    public function index(): JsonResponse
    {
        $leases = $this->client()->query(
            new Query('/ip/dhcp-server/lease/print')
        )->read();

        return response()->json([
            'data' => collect($leases)->map(function ($lease) {

                return [

                    'id' => $lease['.id'] ?? null,

                    'address' => $lease['address'] ?? null,

                    'mac_address' => $lease['mac-address'] ?? null,

                    'host_name' => $lease['host-name'] ?? null,

                    'server' => $lease['server'] ?? null,

                    'status' => $lease['status'] ?? null,

                    'dynamic' => ($lease['dynamic'] ?? 'false') === 'true',

                    'expires_after' => $lease['expires-after'] ?? null,

                    'comment' => $lease['comment'] ?? null,

                ];
            })->values()
        ]);
    }
}
