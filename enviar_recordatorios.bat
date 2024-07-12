@echo off
REM Ruta completa al ejecutable de PHP de XAMPP
set PHP="C:\xampp\php\php.exe"

REM Ruta completa de tu script PHP que deseas ejecutar
set SCRIPT="C:C:\xampp\htdocs\aplicacion\enviar_recordatorios.php"

REM Ejecutar el script PHP
%PHP% -f %SCRIPT%

