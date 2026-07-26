# ADR-0007: Framework Isolation Boundary

## Status

Accepted

## Date

2026-07-26

---

## Context

EgyptNet ISP Platform is designed as an enterprise platform.

Laravel is used as an infrastructure framework and application runtime,
but it is not considered the platform architecture itself.

The Core layer contains platform capabilities that must survive
framework changes.

Direct dependencies from Core to Laravel would create architectural
coupling and reduce long-term flexibility.

---

## Decision

Establish a strict dependency boundary:

Core MUST NOT depend on Laravel.

The dependency direction is:



Presentation

    ↓

Infrastructure

    ↓

Core

    ↓

Contracts


Core provides:

- Domain contracts.
- Platform services.
- Kernel lifecycle.
- Event abstractions.
- Module architecture.

Infrastructure provides:

- Laravel bindings.
- Console commands.
- Service providers.
- Framework adapters.
- External integrations.

---

## Migration Applied

The following Laravel-specific components were moved outside Core:

- Kernel Console Commands

From:


App\Core\Kernel\Console


To:


App\Infrastructure\Laravel\Console\Kernel


---

## Validation

The isolation rule is verified by:


grep -R "Illuminate" app/Core

grep -R "Laravel" app/Core


The Core layer must return no framework references.

---

## Consequences

### Positive

- Core can evolve independently.
- Framework replacement remains possible.
- Architecture ownership is clear.
- Modules depend on platform contracts instead of Laravel.

### Negative

- Infrastructure requires explicit adapters.
- More initial structure.

---

## Alternatives Considered

### Allow Laravel Dependencies Inside Core

Rejected.

Reason:

Would turn Core into a Laravel application layer.

---

### Put All Logic Inside Laravel Structure

Rejected.

Reason:

Does not support a long-lived enterprise platform architecture.

---

## Result

The Framework Isolation Boundary is established.

Laravel is an implementation detail.

EgyptNet Core remains the platform foundation.
