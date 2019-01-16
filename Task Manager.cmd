@echo off

echo   - = = =   Schedule Run Jobs == = = = -

CD c: &&  CD \xampp\htdocs\geatransport && php artisan schedule:run

