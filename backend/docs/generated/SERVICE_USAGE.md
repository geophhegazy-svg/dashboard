# Service Usage

## FinanceService

**Class**

```
App\Services\Finance\FinanceService
```

**Public Methods**

- record

## JournalValidator

**Class**

```
App\Services\Finance\Accounting\JournalValidator
```

**Public Methods**

- validate

## MikroTikConnectionService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikConnectionService
```

**Public Methods**

- client
- connect
- disconnect
- isConnected
- ping

## MikroTikDhcpService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikDhcpService
```

**Public Methods**

- __construct
- activeClients
- create
- delete
- find
- findByMac
- getAll
- makeStatic
- removeStatic
- search
- statistics
- update

## MikroTikFirewallService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikFirewallService
```

**Public Methods**

- __construct
- create
- createNat
- delete
- deleteNat
- disable
- enable
- find
- findNat
- getNatRules
- getRules
- search
- statistics
- update
- updateNat

## MikroTikHotspotService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikHotspotService
```

**Public Methods**

- __construct
- createUser
- deleteUser
- disableUser
- disconnectUser
- enableUser
- findUser
- getActiveSession
- getActiveSessions
- getUsers
- search
- statistics
- status
- updatePassword
- updateProfile
- updateUser

## MikroTikMonitoringService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikMonitoringService
```

**Public Methods**

- __construct
- getIdentity
- getInterfaceTraffic
- getInterfaces
- getSystemResource
- healthCheck
- ping
- summary

## MikroTikPppoeService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikPppoeService
```

**Public Methods**

- __construct
- createUser
- deleteUser
- disableUser
- disconnectUser
- enableUser
- getActiveSession
- getActiveSessions
- getAllUsers
- getUser
- searchUsers
- status
- updatePassword
- updateProfile
- updateUser

## MikroTikProvider

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikProvider
```

**Public Methods**

- __construct
- capabilities
- connect
- dhcp
- disconnect
- firewall
- hotspot
- isConnected
- monitoring
- name
- pppoe
- queue

## MikroTikQueryService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikQueryService
```

**Public Methods**

- __construct
- execute
- first
- write

## MikroTikQueueService

**Class**

```
App\Services\Network\Providers\MikroTik\MikroTikQueueService
```

**Public Methods**

- __construct
- create
- delete
- disable
- enable
- find
- getAll
- getUsage
- getUserQueue
- resetCounters
- search
- statistics
- update
- updateSpeed

## MikrotikService

**Class**

```
App\Services\MikrotikService
```

**Public Methods**

- __construct
- createHotspotUser
- createPppoeUser
- deleteHotspotUser
- findHotspotUser
- findPppoeUser
- getActiveHotspotUsers
- getClient
- getHotspotUserId
- getHotspotUsers
- getPppoeUsers
- setHotspotUserStatus
- setPppoeUserStatus

## MikrotikServiceAdapter

**Class**

```
App\Services\Network\MikrotikServiceAdapter
```

**Public Methods**

- __construct
- connect
- createHotspotUser
- createUser
- deleteUser
- disableHotspotUser
- disableUser
- disconnectUser
- enableHotspotUser
- enableUser
- getActiveSessions
- getAllUsers
- getDeviceStats
- getHotspotActiveSessions
- getHotspotUsers
- getQueueUsage
- ping
- updateDeviceStatus
- updateUserQueue

## NetworkDeviceConnectionManager

**Class**

```
App\Services\Network\NetworkDeviceConnectionManager
```

**Public Methods**

- __construct
- connect
- connectById

## NetworkManager

**Class**

```
App\Services\Network\NetworkManager
```

**Public Methods**

- __construct
- capabilities
- connect
- connected
- device
- disconnect
- provider
- providerName

## NetworkProviderResolver

**Class**

```
App\Services\Network\NetworkProviderResolver
```

**Public Methods**

- available
- register
- resolve
- resolveByName

## TelegramNotificationService

**Class**

```
App\Services\Notification\TelegramNotificationService
```

**Public Methods**

- __construct
- sendDeviceAlert
- sendMessage
