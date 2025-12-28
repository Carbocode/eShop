@echo off
echo Starting eShop Environment...

:: Check for PHP
php -v >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERROR] PHP is not found in your PATH.
    echo Please install XAMPP or PHP, and add 'php.exe' to your system PATH.
    echo If you have XAMPP installed, it is typically in C:\xampp\php
    pause
    exit /b 1
)

:: Install dependencies if composer.json exists
if exist composer.json (
    echo Checking for Composer...
    call composer -v >nul 2>&1
    if %errorlevel% equ 0 (
        echo Installing dependencies...
        call composer install
    ) else (
        echo [WARNING] Composer not found. Skipping dependency installation.
        echo If you have dependencies, please install Composer or run 'php composer.phar install'.
    )
)

:: Run Database Setup
echo Running Database Setup...
php api/config/setup_database.php

:: Start Server
echo.
echo Starting PHP Server on http://localhost:8000
echo Press Ctrl+C to stop.
echo.
php -S localhost:8000
