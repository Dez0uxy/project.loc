@echo off
REM Путь к интерпретатору PHP
set PHP_PATH="C:\OSPanel\home\test.loc\vendor\cebe\markdown\Parser.php"

REM Путь к PHP файлу
set SCRIPT_PATH="C:\OSPanel\home\test.loc\console\controllers\ParserController.php"

REM Запуск PHP файла
%PHP_PATH% %SCRIPT_PATH%

REM Ожидание завершения выполнения (необязательно)
pause