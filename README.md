# blueghost

Do souboru .env zadejte cestu k databázi:
například: 
DATABASE_URL=“mysql://name:password@127.0.0.1:3306/blueghost“

spusťte migrace:
php bin/console doctrine:migrations:migrate
