# ADR-0006: Kernel Lifecycle Management

## Status

Accepted

## Date

2026-07-26

---

## Context

EgyptNet ISP Platform requires a controlled kernel startup process.

The platform contains multiple modules, resources, registrations,
and runtime services that must be initialized in a predictable order.

A simple bootstrap method is not sufficient because:

- Module registration has dependencies.
- Resources require controlled registration.
- Failures must be tracked.
- The platform needs visibility into its runtime state.

---

## Decision

Introduce a Kernel Lifecycle State Machine.

The lifecycle is managed through:

- KernelLifecycleManager
- KernelLifecycleState
- KernelRuntimeState

The kernel follows a controlled transition flow:

Created

↓

Starting

↓

Booting

↓

Ready


Failure path:

Starting / Booting / Ready

↓

Failed

↓

Stopped


---

## Lifecycle Events

Kernel lifecycle exposes events:

- KernelBooting
- KernelBooted
- ModuleBooting
- ModuleBooted

These events allow modules and infrastructure services
to react without direct coupling.

---

## Runtime Separation

Kernel lifecycle state and runtime context are separated.

Lifecycle state answers:

"What phase is the kernel in?"

Runtime state answers:

"What runtime context is currently available?"

This prevents mixing execution state with lifecycle management.

---

## Consequences

### Positive

- Predictable boot process.
- Better diagnostics.
- Failure handling becomes explicit.
- Modules remain isolated.
- Future orchestration features are possible.

### Negative

- Additional state management.
- More explicit boot flow.

---

## Alternatives Considered

### Direct Service Provider Boot Logic

Rejected.

Reason:

Would couple platform lifecycle with Laravel execution lifecycle.

---

### Single Boolean Boot Flag

Rejected.

Reason:

Cannot represent failures, transitions, or operational state.

---

## Result

Kernel lifecycle is now a Core platform capability.

Infrastructure frameworks only trigger the lifecycle;
they do not own it.
