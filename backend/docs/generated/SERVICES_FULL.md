# Services

---

## FinanceService

**Namespace**

```
App\Services\Finance
```

**File**

```
/var/www/app/Services/Finance/FinanceService.php
```

**Methods**

- record() : void

---

## JournalValidator

**Namespace**

```
App\Services\Finance\Accounting
```

**File**

```
/var/www/app/Services/Finance/Accounting/JournalValidator.php
```

**Methods**

- validate() : void

---

## MikroTikConnectionService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikConnectionService.php
```

**Properties**

- $client : ?RouterOS\Client

**Methods**

- connect() : bool
- client() : ?RouterOS\Client
- isConnected() : bool
- disconnect() : void
- ping() : bool

---

## MikroTikDhcpService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikDhcpService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getAll() : array
- find() : ?array
- findByMac() : ?array
- create() : bool
- update() : bool
- delete() : bool
- makeStatic() : bool
- removeStatic() : bool
- search() : array
- statistics() : array
- activeClients() : array

---

## MikroTikFirewallService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikFirewallService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getRules() : array
- find() : ?array
- create() : bool
- update() : bool
- delete() : bool
- disable() : bool
- enable() : bool
- getNatRules() : array
- findNat() : ?array
- createNat() : bool
- updateNat() : bool
- deleteNat() : bool
- search() : array
- statistics() : array

---

## MikroTikHotspotService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikHotspotService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getUsers() : array
- findUser() : ?array
- getActiveSessions() : array
- getActiveSession() : ?array
- createUser() : bool
- disableUser() : bool
- enableUser() : bool
- deleteUser() : bool
- disconnectUser() : bool
- status() : array
- updateUser() : bool
- updateProfile() : bool
- updatePassword() : bool
- search() : array
- statistics() : array

---

## MikroTikMonitoringService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikMonitoringService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getSystemResource() : array
- getIdentity() : array
- getInterfaces() : array
- getInterfaceTraffic() : array
- ping() : bool
- healthCheck() : array
- summary() : array

---

## MikroTikPppoeService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikPppoeService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getAllUsers() : array
- getUser() : ?array
- createUser() : bool
- updateUser() : bool
- disableUser() : bool
- enableUser() : bool
- deleteUser() : bool
- getActiveSessions() : array
- getActiveSession() : ?array
- disconnectUser() : bool
- updateProfile() : bool
- updatePassword() : bool
- searchUsers() : array
- status() : array

---

## MikroTikProvider

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikProvider.php
```

**Constructor Dependencies**

- MikroTikConnectionService $connection
- MikroTikPppoeService $pppoe
- MikroTikQueueService $queue
- MikroTikHotspotService $hotspot
- MikroTikFirewallService $firewall
- MikroTikDhcpService $dhcp
- MikroTikMonitoringService $monitoring

**Properties**

- $connection : App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- $pppoe : App\Services\Network\Providers\MikroTik\MikroTikPppoeService
- $queue : App\Services\Network\Providers\MikroTik\MikroTikQueueService
- $hotspot : App\Services\Network\Providers\MikroTik\MikroTikHotspotService
- $firewall : App\Services\Network\Providers\MikroTik\MikroTikFirewallService
- $dhcp : App\Services\Network\Providers\MikroTik\MikroTikDhcpService
- $monitoring : App\Services\Network\Providers\MikroTik\MikroTikMonitoringService

**Methods**

- connect() : bool
- disconnect() : void
- isConnected() : bool
- name() : string
- capabilities() : array
- pppoe() : App\Contracts\Network\Services\PppoeServiceInterface
- queue() : App\Contracts\Network\Services\QueueServiceInterface
- hotspot() : App\Contracts\Network\Services\HotspotServiceInterface
- firewall() : App\Contracts\Network\Services\FirewallServiceInterface
- dhcp() : App\Contracts\Network\Services\DhcpServiceInterface
- monitoring() : App\Contracts\Network\Services\MonitoringServiceInterface

---

## MikroTikQueryService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikQueryService.php
```

**Constructor Dependencies**

- MikroTikConnectionService $connection

**Properties**

- $connection : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**

- execute() : array
- first() : ?array
- write() : bool

---

## MikroTikQueueService

**Namespace**

```
App\Services\Network\Providers\MikroTik
```

**File**

```
/var/www/app/Services/Network/Providers/MikroTik/MikroTikQueueService.php
```

**Constructor Dependencies**

- MikroTikQueryService $query

**Properties**

- $query : App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**

- getAll() : array
- find() : ?array
- create() : bool
- update() : bool
- delete() : bool
- disable() : bool
- enable() : bool
- getUsage() : array
- getUserQueue() : ?array
- updateSpeed() : bool
- resetCounters() : bool
- search() : array
- statistics() : array

---

## MikrotikService

**Namespace**

```
App\Services
```

**File**

```
/var/www/app/Services/MikrotikService.php
```

**Properties**

- $client : ?RouterOS\Client

**Methods**

- getClient() : RouterOS\Client
- getPppoeUsers() : array
- createPppoeUser() : void
- findPppoeUser() : ?array
- setPppoeUserStatus() : void
- getHotspotUsers() : array
- createHotspotUser() : void
- findHotspotUser() : ?array
- getHotspotUserId() : string
- setHotspotUserStatus() : void
- deleteHotspotUser() : void
- getActiveHotspotUsers() : array

---

## MikrotikServiceAdapter

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/MikrotikServiceAdapter.php
```

**Constructor Dependencies**

- NetworkManager $networkManager

**Properties**

- $networkManager : App\Services\Network\NetworkManager

**Methods**

- connect() : bool
- createUser() : bool
- disableUser() : bool
- enableUser() : bool
- deleteUser() : bool
- getAllUsers() : array
- getActiveSessions() : array
- updateUserQueue() : bool
- getQueueUsage() : array
- getDeviceStats() : array
- ping() : bool
- disconnectUser() : bool
- updateDeviceStatus() : void
- getHotspotUsers() : array
- getHotspotActiveSessions() : array
- createHotspotUser() : bool
- disableHotspotUser() : bool
- enableHotspotUser() : bool

---

## NetworkDeviceConnectionManager

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/NetworkDeviceConnectionManager.php
```

**Constructor Dependencies**

- MikroTikConnectionService $connectionService

**Properties**

- $connectionService : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**

- connectById() : App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- connect() : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

---

## NetworkManager

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/NetworkManager.php
```

**Constructor Dependencies**

- NetworkProviderResolver $resolver

**Properties**

- $device : ?App\Models\NetworkDevice
- $provider : ?App\Contracts\Network\NetworkProviderInterface
- $resolver : App\Services\Network\NetworkProviderResolver

**Methods**

- connect() : bool
- disconnect() : void
- provider() : ?App\Contracts\Network\NetworkProviderInterface
- device() : ?App\Models\NetworkDevice
- connected() : bool
- providerName() : ?string
- capabilities() : array

---

## NetworkProviderResolver

**Namespace**

```
App\Services\Network
```

**File**

```
/var/www/app/Services/Network/NetworkProviderResolver.php
```

**Properties**

- $providers : array

**Methods**

- resolve() : App\Contracts\Network\NetworkProviderInterface
- resolveByName() : App\Contracts\Network\NetworkProviderInterface
- register() : void
- available() : array

---

## TelegramNotificationService

**Namespace**

```
App\Services\Notification
```

**File**

```
/var/www/app/Services/Notification/TelegramNotificationService.php
```

**Properties**

- $botToken : mixed
- $chatId : mixed

**Methods**

- sendMessage() : mixed
- sendDeviceAlert() : mixed
