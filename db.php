<?php
$conn = pg_connect("
host=ep-wandering-sea-a16rzjhf-pooler.ap-southeast-1.aws.neon.tech
port=5432
dbname=attendance
user=neondb_owner
password=npg_aM9uDmfJd3Fg
sslmode=require
options='endpoint=ep-wandering-sea-a16rzjhf'
");

if(!$conn){
    echo "Database connection failed";
}
?>