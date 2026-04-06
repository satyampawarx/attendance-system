<?php
$conn = pg_connect("host=localhost dbname=attendance user=postgres password=Pass@123");

if(!$conn){
    echo "Database connection failed";
}
?>