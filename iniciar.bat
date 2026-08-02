@echo off
title CORPO_SALUD - Sistema de Inventario
echo ==========================================
echo   CORPO SALUD - Iniciando Sistema
echo ==========================================
echo.

set SCRIPT_DIR=%~dp0
cd /d "%SCRIPT_DIR%"

if exist "CORPO_SALUD.exe" (
    echo Iniciando servidor en http://localhost:5000
    echo Usuario: admin ^| Contrasena: admin123
    echo Presione Ctrl+C para detener
    echo.
    start "" "CORPO_SALUD.exe"
) else (
    echo ERROR: CORPO_SALUD.exe no encontrado.
    echo Ejecute primero el build de PyInstaller o use python app.py
    pause
    exit /b 1
)
