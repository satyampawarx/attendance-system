<?php
// Neon DB Credentials
$conn_string = "host=ep-wandering-sea-a16rzjhf-pooler.ap-southeast-1.aws.neon.tech port=5432 dbname=attendance user=neondb_owner password=npg_aM9uDmfJd3Fg sslmode=require";

// '@' symbol vaparla ahe jene karun PHP chya default warnings screen var disnar nahit
$conn = @pg_connect($conn_string);

if(!$conn){
    echo "Database connection failed. Please refresh the page after 5 seconds.";
    // die() takla karan connection fail zalyas pudhcha code run houn error yeu naye
    die(); 
}
?>