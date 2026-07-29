# ADR-001: Kernel Provider Extraction

## Status

Accepted

## Date

2026-07-29

---

## Context

The EgyptNet Platform Kernel was initially registered through a single
Laravel Service Provider:

`App\Providers\EgyptNetKernelServiceProvider`

Over time, the provider accumulated multiple responsibilities:

- Core Kernel bindings
- Validation services
- Event Bus registration
- Compiler pipeline
- Health services
- Infrastructure adapters
- Bootstrap lifecycle

This created a high coupling point between Laravel Infrastructure
and the Platform Kernel.

---

## Decision

The Kernel registration responsibilities were extracted into dedicated
Infrastructure Laravel Service Providers.

The main entry provider remains:


App\Providers\EgyptNetKernelServiceProvider


Its responsibility is now limited to:

1. Register Kernel Infrastructure Providers.
2. Start Kernel bootstrap lifecycle.

---

## New Provider Structure


app/Infrastructure/Laravel/Providers

KernelCoreServiceProvider
KernelValidationServiceProvider
KernelInfrastructureServiceProvider
KernelBusServiceProvider
KernelEventBusServiceProvider
KernelCompilerPipelineServiceProvider
KernelHealthServiceProvider
KernelBootstrapServiceProvider


---

## Responsibilities

### KernelCoreServiceProvider

Responsible for core runtime services:

- Module Registry
- Module Discovery
- Module Loader
- Kernel Runtime State
- Lifecycle Management
- Boot Monitoring

---

### KernelValidationServiceProvider

Responsible for:

- Kernel Validation
- Validation Rules Registry

---

### KernelInfrastructureServiceProvider

Responsible for Laravel adapters:

- Container Adapter
- Console integration
- Laravel specific implementations

---

### KernelBusServiceProvider

Responsible for:

- Command Bus
- Query Bus
- Action Bus

---

### KernelEventBusServiceProvider

Responsible for:

- Event Registry
- Event Dispatcher
- Listener Resolver

---

### KernelCompilerPipelineServiceProvider

Responsible for:

- Manifest Collection
- Manifest Compilation
- Compiled Registration Pipeline
- Manifest Cache
- Fingerprinting

---

### KernelHealthServiceProvider

Responsible for:

- Kernel Health Checks
- Health Reporting

---

### KernelBootstrapServiceProvider

Responsible for:

- Kernel Bootstrapper binding

---

## Consequences

### Positive

- Core remains framework independent.
- Laravel remains an Infrastructure concern.
- Provider responsibilities are isolated.
- Future Module migration becomes safer.
- Kernel APIs become more stable.

### Negative

- More provider files exist.
- Registration flow requires understanding provider boundaries.

---

## Validation

After extraction:


Tests: 239 passed
Assertions: 464


Core dependency checks:

- No Laravel dependency inside `app/Core`.
- No Module dependency inside `app/Core`.
- No Infrastructure dependency inside `app/Core`.

---

## Status

Core Architecture Freeze v1 completed.
