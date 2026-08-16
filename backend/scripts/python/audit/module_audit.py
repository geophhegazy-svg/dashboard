from __future__ import annotations

from pathlib import Path

from rich.console import Console
from rich.table import Table


ROOT = Path(__file__).resolve().parents[3]
MODULES_PATH = ROOT / "app" / "Modules"

console = Console()


def php_files(path: Path) -> list[Path]:
    if not path.exists():
        return []

    return sorted(
        file
        for file in path.rglob("*.php")
        if file.is_file()
    )


def count_php(path: Path) -> int:
    return len(php_files(path))


def audit_modules() -> None:
    if not MODULES_PATH.exists():
        console.print(
            f"[red]Modules directory not found:[/red] {MODULES_PATH}"
        )
        return

    modules = sorted(
        path
        for path in MODULES_PATH.iterdir()
        if path.is_dir()
    )

    table = Table(
        title="EgyptNet Module Audit",
        show_lines=True,
    )

    table.add_column("Module")
    table.add_column("Actions", justify="right")
    table.add_column("Workflows", justify="right")
    table.add_column("Services", justify="right")
    table.add_column("Repositories", justify="right")
    table.add_column("PHP Files", justify="right")

    for module in modules:
        application = module / "Application"

        actions = count_php(
            application / "Actions"
        )

        workflows = count_php(
            application / "Workflows"
        )

        services = count_php(
            application / "Services"
        )

        repositories = count_php(
            module / "Infrastructure" / "Repositories"
        )

        total_php = count_php(module)

        table.add_row(
            module.name,
            str(actions),
            str(workflows),
            str(services),
            str(repositories),
            str(total_php),
        )

    console.print()
    console.print(table)
    console.print()


if __name__ == "__main__":
    audit_modules()
