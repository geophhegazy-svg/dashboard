# ADR-0005: Core EventBus Abstraction

## Status

Accepted

## Date

2026-07-26

---

## Context

EgyptNet ISP Platform is designed as an Enterprise Platform where
Laravel is only an infrastructure framework.

The Core layer must remain framework independent and must not depend
on Laravel internal services.

The initial implementation used Laravel Event mechanisms directly,
which created a dependency between Core components and the framework.

This violated the architectural rule:

Core must not depend on Infrastructure.

---

## Decision

Introduce an internal EventBus abstraction inside Core.

Core components communicate through:

- EventDispatcherInterface
- EventContract
- EventRegistry

Infrastructure provides the framework integration through:

- Laravel Event Bridge
- Listener Resolver
- Service Provider bindings

Core dispatches domain events without knowing how they are transported.

---

## Consequences

### Positive

- Core is framework independent.
- Events can be tested without Laravel.
- Event transport can be replaced in the future.
- Modules communicate through contracts.
- Lifecycle events become part of the platform architecture.

### Negative

- Additional abstraction layer.
- Infrastructure must maintain event adapters.
- Listener resolution requires explicit configuration.

---

## Alternatives Considered

### Direct Laravel Events

Rejected.

Reason:

Would couple Core with Laravel and prevent framework independence.

---

### No Event System

Rejected.

Reason:

The platform requires event-driven communication between modules.

---

## Result

The EventBus is now a Core capability.

Laravel acts only as an adapter implementation.
