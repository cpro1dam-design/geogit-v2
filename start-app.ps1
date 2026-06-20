<#
    start-app.ps1 — Lance l'application Geoworld en local.

    - Active le profil "local" (MySQL local : root, sans mot de passe, base geoworld)
    - Démarre le serveur MySQL d'EasyPHP s'il n'est pas déjà lancé
    - Lance le serveur PHP intégré sur le port choisi

    Utilisation :
        .\start-app.ps1
        .\start-app.ps1 -Port 9000 -Debug

    Si PowerShell refuse d'exécuter le script :
        Set-ExecutionPolicy -Scope CurrentUser RemoteSigned
#>

param(
    [int]    $Port = 8000,
    [switch] $Debug
)

$ErrorActionPreference = "Stop"
$root = Split-Path -Parent $MyInvocation.MyCommand.Path
$listenHost = "127.0.0.1"

# --- 1. S'assurer que MySQL écoute sur le port 3306 ---
$mysqlUp = (Test-NetConnection -ComputerName $listenHost -Port 3306 -WarningAction SilentlyContinue).TcpTestSucceeded
if (-not $mysqlUp) {
    $dbServer = "C:\Program Files (x86)\EasyPHP-Devserver-17\eds-binaries\dbserver\mysql5717x86x210507080732\bin\eds-dbserver.exe"
    if (Test-Path $dbServer) {
        Write-Host "Demarrage du serveur MySQL d'EasyPHP..." -ForegroundColor Yellow
        Start-Process -FilePath $dbServer -WindowStyle Minimized
        for ($i = 0; $i -lt 15; $i++) {
            Start-Sleep -Seconds 1
            if ((Test-NetConnection -ComputerName $listenHost -Port 3306 -WarningAction SilentlyContinue).TcpTestSucceeded) {
                $mysqlUp = $true; break
            }
        }
    }
    if (-not $mysqlUp) {
        Write-Warning "MySQL ne repond pas sur ${listenHost}:3306. Demarrez-le via EasyPHP, puis relancez."
    }
} else {
    Write-Host "MySQL est deja en ecoute sur ${listenHost}:3306." -ForegroundColor Green
}

# --- 2. Profil local (lu par l'app modernisee, deplacee dans ../geoworld-app) ---
$env:GEOWORLD_ENV   = "local"
$env:GEOWORLD_DEBUG = if ($Debug) { "1" } else { "0" }

# --- 3. Lancer le serveur PHP integre (racine du projet) ---
Write-Host ""
Write-Host "Application d'origine : http://${listenHost}:${Port}/" -ForegroundColor Cyan
Write-Host "App modernisee        : depot separe dans ..\geoworld-app" -ForegroundColor DarkCyan
Write-Host "  (lancer a part : php -S ${listenHost}:8001 -t ..\geoworld-app)" -ForegroundColor DarkGray
Write-Host "(Ctrl+C pour arreter)" -ForegroundColor DarkGray
Write-Host ""

php -S "${listenHost}:${Port}" -t $root
