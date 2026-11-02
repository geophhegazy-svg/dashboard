# EgyptNet — Project Execution & Responsibility Reference

## 1. Project identity
EgyptNet is an **Enterprise ISP Platform**, not merely a Laravel project. Laravel is framework/infrastructure; the product includes customer, subscription, billing, network-service, provisioning, and operational workflows.

## 2. Assistant responsibility
The implementation role covers:
- Product and workflow design
- Enterprise architecture
- Backend/API contracts
- React/TypeScript frontend
- MikroTik/RouterOS and ISP networking
- Evidence-first validation and regression control

Do not act as a command executor only. Preserve architecture, product intent, prior decisions, and closed green gates. Never fill missing facts by guessing.

## 3. Evidence rule
Use:
**Evidence → Contract → Decision → Minimal Change → Targeted Test → Runtime Evidence → Green Gate → STOP**

Sources of truth, in order:
1. Actual project files/code
2. API routes/controllers/resources/contracts/DTOs/requests
3. Existing tests
4. Runtime/API evidence
5. Explicit architectural/product decisions
6. Conversation memory as context only

If memory conflicts with current code/evidence, verify and use current evidence; do not guess.

## 4. No-loop rule
Do not reopen completed phases without new regression evidence or an explicit decision. Do not perform speculative refactoring. If there is No Gap, make no change. If Green, STOP.

## 5. Frontend direction
Frontend is API-first:
- React 19
- TypeScript
- React Router
- Tailwind 4
- Vite
- Bearer-token authentication
- `/app` protected application shell

Frontend should represent business workflows, not become a collection of disconnected CRUD screens.

## 6. Subscriber Onboarding — canonical product workflow
Adding a subscriber is one guided workflow, not separate user-facing Customer/Create Subscription/Create Network Service CRUD flows:

Customer
→ Service Type
→ Package
→ Subscription
→ Network Configuration
→ Review
→ Provisioning
→ Verification
→ Success / Failure

The exact fields and API calls must be derived from the current backend contracts. Never invent fields, statuses, endpoints, permissions, or network capabilities.

### Responsibilities
Backend owns:
- validation
- authorization
- business rules
- persistence
- transaction boundaries
- provisioning actions
- provider communication
- authoritative application/network state

Frontend owns:
- workflow UX
- navigation between steps
- presentation/client-side validation
- progress and loading states
- errors
- review
- provisioning feedback

Frontend must not duplicate backend business rules.

## 7. Network / MikroTik responsibility
Treat MikroTik/RouterOS as a real network execution target and EgyptNet as the application/business truth.

Network expertise is part of the implementation responsibility, including:
- RouterOS 7
- PPPoE users/profiles/sessions
- Hotspot users/profiles
- Queues / Queue Tree where applicable
- DHCP / leases
- IP addressing/subnets
- provider capabilities
- synchronization
- provisioning/de-provisioning
- disconnect/reconnect
- retry/idempotency and partial failure handling
- network security and credential handling
- distinction between persisted DB state and actual live network state

The UI must not imply live network truth from persisted flags alone.

## 8. Dashboard semantics
`onlineUsers` and `activeUsers` are not authoritative live-network measurements. Current persisted sources represent application/last-sync state. The UI must not present them as proof of current network connectivity unless a new verified live-network contract is introduced.

## 9. Architecture rules
- Core remains framework-independent where reasonably possible.
- Laravel-specific implementations belong under `Infrastructure/Laravel`.
- Layering: `Presentation → Application → Domain → Infrastructure`.
- No compatibility adapters unless explicitly decided.
- No speculative refactoring.
- Invoice module is the sole owner of the Invoice aggregate; other modules use the appropriate Invoice service contract rather than direct invoice creation/number generation.
- Task authorization remains permission-based at the controller boundary unless new evidence changes the contract.
- Do not reopen established Network/Kernel/Domain boundaries without evidence.

## 10. Change record required for meaningful work
Every completed change should record:
- **Change** — what was created/modified
- **Why** — reason
- **Evidence** — proof of the gap/requirement
- **Files** — changed files
- **Contract** — affected API/domain/UI contract
- **Tests** — targeted tests and result
- **Runtime** — runtime/API evidence
- **Result** — GREEN / BLOCKED / GAP REMAINS
- **Next** — only the next concrete step

## 11. Stop condition
A scope is complete only when its contract, implementation, tests, and required runtime evidence are green. Then stop. Do not continue polishing the same scope without a new gap or explicit request.

## 12. Canonical current direction
The backend readiness work is closed for the current scope. Frontend foundation and Dashboard scope are green. The next product workflow is the **Subscriber Onboarding Workflow** above.

This document supplements `docs/MASTER_ROADMAP.md` as the execution/responsibility reference. `docs/MASTER_ROADMAP.md` remains the canonical roadmap for phases and completion state.
