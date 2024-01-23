<?php

/* $DB_SERVER = getenv("MVC_SERVER") ?: "192.168.125.2"; */
 $DB_SERVER = getenv("MVC_SERVER") ?: "92.139.213.250:1974";
$DB_DATABASE = getenv("MVC_DB") ?: "bd_MediaTP";
$DB_USER = getenv("MVC_USER") ?: "Gilbert";
$DB_PASSWORD = getenv("MVC_TOKEN") ?: "Montagné";
$DEBUG = getenv("MVC_DEBUG") ?: true;
/* $URL_VALIDATION = getenv("MVC_URL_VALIDATION") ?: "192.168.125.2"; */
 $URL_VALIDATION = getenv("MVC_URL_VALIDATION") ?: "localhost:9000";
$MAIL_SERVER = getenv("MVC_MAIL_SERVER") ?: "192.168.10.15";
$FROM_EMAIL = getenv("MVC_FROM_EMAIL") ?: "contact@localhost.fr";

return array(
    "DB_USER" => $DB_USER,
    "DB_PASSWORD" => $DB_PASSWORD,
    "DB_DSN" => "mysql:host=$DB_SERVER;dbname=$DB_DATABASE;charset=utf8",
    "DEBUG" => $DEBUG,
    "MAIL_SERVER" => $MAIL_SERVER,
    "FROM_EMAIL" => $FROM_EMAIL,
    "URL_VALIDATION" => $URL_VALIDATION
);

