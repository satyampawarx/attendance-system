<?php
// options chi line kadhun takli ahe
$conn = pg_connect("
host=ep-wandering-sea-a16rzjhf-pooler.ap-southeast-1.aws.neon.tech
port=5432
dbname=attendance
user=neondb_owner
password=npg_aM9uDmfJd3Fg
sslmode=require
");

if(!$conn){
    echo "Database connection failed";
}
?>