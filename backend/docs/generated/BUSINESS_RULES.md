# Business Rules

## FinanceService

**Namespace**
App\Services\Finance

**Dependencies**
- None

**Methods**
- record(1 params) : void

---

## JournalValidator

**Namespace**
App\Services\Finance\Accounting

**Dependencies**
- None

**Methods**
- validate(1 params) : void

---

## MikroTikConnectionService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- None

**Methods**
- connect(4 params) : bool
- client(0 params) : ?RouterOS\Client
- isConnected(0 params) : bool
- disconnect(0 params) : void
- ping(0 params) : bool

---

## MikroTikDhcpService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getAll(0 params) : array
- find(1 params) : ?array
- findByMac(1 params) : ?array
- create(4 params) : bool
- update(2 params) : bool
- delete(1 params) : bool
- makeStatic(1 params) : bool
- removeStatic(1 params) : bool
- search(1 params) : array
- statistics(0 params) : array
- activeClients(0 params) : array

---

## MikroTikFirewallService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getRules(0 params) : array
- find(1 params) : ?array
- create(1 params) : bool
- update(2 params) : bool
- delete(1 params) : bool
- disable(1 params) : bool
- enable(1 params) : bool
- getNatRules(0 params) : array
- findNat(1 params) : ?array
- createNat(1 params) : bool
- updateNat(2 params) : bool
- deleteNat(1 params) : bool
- search(1 params) : array
- statistics(0 params) : array

---

## MikroTikHotspotService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getUsers(0 params) : array
- findUser(1 params) : ?array
- getActiveSessions(0 params) : array
- getActiveSession(1 params) : ?array
- createUser(4 params) : bool
- disableUser(1 params) : bool
- enableUser(1 params) : bool
- deleteUser(1 params) : bool
- disconnectUser(1 params) : bool
- status(1 params) : array
- updateUser(2 params) : bool
- updateProfile(2 params) : bool
- updatePassword(2 params) : bool
- search(1 params) : array
- statistics(0 params) : array

---

## MikroTikMonitoringService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getSystemResource(0 params) : array
- getIdentity(0 params) : array
- getInterfaces(0 params) : array
- getInterfaceTraffic(0 params) : array
- ping(2 params) : bool
- healthCheck(0 params) : array
- summary(0 params) : array

---

## MikroTikPppoeService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getAllUsers(0 params) : array
- getUser(1 params) : ?array
- createUser(4 params) : bool
- updateUser(2 params) : bool
- disableUser(1 params) : bool
- enableUser(1 params) : bool
- deleteUser(1 params) : bool
- getActiveSessions(0 params) : array
- getActiveSession(1 params) : ?array
- disconnectUser(1 params) : bool
- updateProfile(2 params) : bool
- updatePassword(2 params) : bool
- searchUsers(1 params) : array
- status(1 params) : array

---

## MikroTikProvider

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- App\Services\Network\Providers\MikroTik\MikroTikPppoeService
- App\Services\Network\Providers\MikroTik\MikroTikQueueService
- App\Services\Network\Providers\MikroTik\MikroTikHotspotService
- App\Services\Network\Providers\MikroTik\MikroTikFirewallService
- App\Services\Network\Providers\MikroTik\MikroTikDhcpService
- App\Services\Network\Providers\MikroTik\MikroTikMonitoringService

**Methods**
- __construct(7 params) : mixed
- connect(4 params) : bool
- disconnect(0 params) : void
- isConnected(0 params) : bool
- name(0 params) : string
- capabilities(0 params) : array
- pppoe(0 params) : App\Contracts\Network\Services\PppoeServiceInterface
- queue(0 params) : App\Contracts\Network\Services\QueueServiceInterface
- hotspot(0 params) : App\Contracts\Network\Services\HotspotServiceInterface
- firewall(0 params) : App\Contracts\Network\Services\FirewallServiceInterface
- dhcp(0 params) : App\Contracts\Network\Services\DhcpServiceInterface
- monitoring(0 params) : App\Contracts\Network\Services\MonitoringServiceInterface

---

## MikroTikQueryService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**
- __construct(1 params) : mixed
- execute(1 params) : array
- first(1 params) : ?array
- write(1 params) : bool

---

## MikroTikQueueService

**Namespace**
App\Services\Network\Providers\MikroTik

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikQueryService

**Methods**
- __construct(1 params) : mixed
- getAll(0 params) : array
- find(1 params) : ?array
- create(6 params) : bool
- update(2 params) : bool
- delete(1 params) : bool
- disable(1 params) : bool
- enable(1 params) : bool
- getUsage(0 params) : array
- getUserQueue(1 params) : ?array
- updateSpeed(3 params) : bool
- resetCounters(1 params) : bool
- search(1 params) : array
- statistics(1 params) : array

---

## MikrotikService

**Namespace**
App\Services

**Dependencies**
- None

**Methods**
- __construct(0 params) : mixed
- getClient(0 params) : RouterOS\Client
- getPppoeUsers(0 params) : array
- createPppoeUser(4 params) : void
- findPppoeUser(1 params) : ?array
- setPppoeUserStatus(2 params) : void
- getHotspotUsers(0 params) : array
- createHotspotUser(3 params) : void
- findHotspotUser(1 params) : ?array
- getHotspotUserId(1 params) : string
- setHotspotUserStatus(2 params) : void
- deleteHotspotUser(1 params) : void
- getActiveHotspotUsers(0 params) : array

---

## MikrotikServiceAdapter

**Namespace**
App\Services\Network

**Dependencies**
- App\Services\Network\NetworkManager

**Methods**
- __construct(1 params) : mixed
- connect(4 params) : bool
- createUser(4 params) : bool
- disableUser(1 params) : bool
- enableUser(1 params) : bool
- deleteUser(1 params) : bool
- getAllUsers(0 params) : array
- getActiveSessions(0 params) : array
- updateUserQueue(3 params) : bool
- getQueueUsage(0 params) : array
- getDeviceStats(0 params) : array
- ping(1 params) : bool
- disconnectUser(1 params) : bool
- updateDeviceStatus(1 params) : void
- getHotspotUsers(0 params) : array
- getHotspotActiveSessions(0 params) : array
- createHotspotUser(4 params) : bool
- disableHotspotUser(1 params) : bool
- enableHotspotUser(1 params) : bool

---

## NetworkDeviceConnectionManager

**Namespace**
App\Services\Network

**Dependencies**
- App\Services\Network\Providers\MikroTik\MikroTikConnectionService

**Methods**
- __construct(1 params) : mixed
- connectById(1 params) : App\Services\Network\Providers\MikroTik\MikroTikConnectionService
- connect(1 params) : App\Services\Network\Providers\MikroTik\MikroTikConnectionService

---

## NetworkManager

**Namespace**
App\Services\Network

**Dependencies**
- App\Services\Network\NetworkProviderResolver

**Methods**
- __construct(1 params) : mixed
- connect(1 params) : bool
- disconnect(0 params) : void
- provider(0 params) : ?App\Contracts\Network\NetworkProviderInterface
- device(0 params) : ?App\Models\NetworkDevice
- connected(0 params) : bool
- providerName(0 params) : ?string
- capabilities(0 params) : array

---

## NetworkProviderResolver

**Namespace**
App\Services\Network

**Dependencies**
- None

**Methods**
- resolve(1 params) : App\Contracts\Network\NetworkProviderInterface
- resolveByName(1 params) : App\Contracts\Network\NetworkProviderInterface
- register(2 params) : void
- available(0 params) : array

---

## TelegramNotificationService

**Namespace**
App\Services\Notification

**Dependencies**
- None

**Methods**
- __construct(0 params) : mixed
- sendMessage(1 params) : mixed
- sendDeviceAlert(1 params) : mixed

---
