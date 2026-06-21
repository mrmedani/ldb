@echo OFF
title CHRONOREX EXPRESS - Plateforme
cd /d "%~dp0"
set PATH=C:\wamp64\bin\php\php8.3.14;%PATH%
set COMPOSER_HOME=%USERPROFILE%\AppData\Local\ComposerSetup
cls
echo ========================================
echo   CHRONOREX EXPRESS
echo   Plateforme de gestion des bureaux
echo ========================================
echo.
php -v
echo.
echo  Site public  : http://127.0.0.1:8000
echo  Admin login  : http://127.0.0.1:8000/login
echo  Email        : admin@chronorex.dz
echo  Mot de passe : password
echo.
echo  Appuyez sur Ctrl+C pour arreter le serveur
echo ========================================
echo.
php artisan serve
pause
