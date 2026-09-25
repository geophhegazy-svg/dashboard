$ErrorActionPreference = "Stop"

$BackupDir = "D:\EgyptNet\backups"
$RetentionDays = 7

New-Item -ItemType Directory -Force -Path $BackupDir | Out-Null

$Timestamp = Get-Date -Format "yyyy-MM-dd_HHmmss"
$BackupFile = Join-Path $BackupDir "egyptnet_$Timestamp.sql"

Write-Host "===== EGYPTNET BACKUP ====="
Write-Host "BACKUP_FILE=$BackupFile"

Write-Host ""
Write-Host "----- DATABASE BACKUP -----"

docker exec egyptnet_mysql sh -lc 'mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" --single-transaction --routines --triggers --events egyptnet' |
    Out-File -FilePath $BackupFile -Encoding utf8

$DumpExit = $LASTEXITCODE

Write-Host "MYSQLDUMP_EXIT_CODE=$DumpExit"

if ($DumpExit -ne 0) {
    if (Test-Path $BackupFile) {
        Remove-Item $BackupFile -Force
    }

    throw "mysqldump failed."
}

if (-not (Test-Path $BackupFile)) {
    throw "Backup file was not created."
}

$File = Get-Item $BackupFile

if ($File.Length -le 0) {
    Remove-Item $BackupFile -Force
    throw "Backup file is empty."
}

Write-Host "BACKUP_EXISTS=true"
Write-Host "BACKUP_SIZE_BYTES=$($File.Length)"

Write-Host ""
Write-Host "----- BACKUP HEADER CHECK -----"

$Header = Get-Content -Path $BackupFile -TotalCount 1

if ($Header -notmatch "MySQL dump") {
    Remove-Item $BackupFile -Force
    throw "Backup header validation failed."
}

Write-Host "BACKUP_HEADER_VALID=true"

Write-Host ""
Write-Host "----- RETENTION -----"

$Cutoff = (Get-Date).AddDays(-$RetentionDays)

$OldBackups = Get-ChildItem -Path $BackupDir -Filter "egyptnet_*.sql" -File |
    Where-Object { $_.LastWriteTime -lt $Cutoff }

foreach ($OldBackup in $OldBackups) {
    Write-Host "REMOVING_OLD_BACKUP=$($OldBackup.FullName)"
    Remove-Item $OldBackup.FullName -Force
}

$Remaining = Get-ChildItem -Path $BackupDir -Filter "egyptnet_*.sql" -File |
    Sort-Object LastWriteTime -Descending

Write-Host "BACKUP_COUNT=$($Remaining.Count)"

Write-Host ""
Write-Host "----- BACKUP INVENTORY -----"

$Remaining |
    Select-Object Name, Length, LastWriteTime |
    Format-Table -AutoSize

Write-Host ""
Write-Host "===== EGYPTNET BACKUP SUCCESS ====="
