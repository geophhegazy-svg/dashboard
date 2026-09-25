# AI Context

## Project

EgyptNet Enterprise ISP Platform

## Technology Stack

- Laravel 13
- PHP 8.4
- Docker
- MySQL
- MikroTik RouterOS API

## Architecture

- Core Platform
- Module-based business architecture
- Presentation → Application → Domain → Infrastructure
- Kernel-owned module discovery and registration
- Action Bus / Command Bus / Query Bus / Event Bus
- Workflow Engine
- Spatie Permission based authorization
- Tenant-aware business boundaries

## Documentation

- Documentation Module
- ProjectScanner
- DocumentationKnowledgeGeneratorRegistry
- KnowledgeGeneratorManager
- DocumentationWriter
- Generated documentation under `docs/generated/`

## Current Inventory

Models: 27
Services: 14
Controllers: 36
Repositories: 20
Actions: 90

## Development Rules

- Preserve the established Core → Modules → Infrastructure → Presentation architecture.
- Keep module ownership boundaries explicit.
- Use Actions / Workflows according to the established use-case architecture.
- Do not introduce compatibility adapters without architectural evidence.
- Do not perform speculative refactoring.
- Keep tests passing.
- Regenerate documentation after structural changes.