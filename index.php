<?php


$databasehost = "localhost";
$databasename = "eval_php";
$databasetable = "geoip";
$databaseusername="root";
$databasepassword = "123";
$fieldseparator = ",";
$contentseparator = '"';
$lineseparator = "\n";
$csvfile = "geoip.csv";
$addauto = 0;
$save = 1;


if(!file_exists($csvfile)) 
{
    die("File not found. Make sure you specified the correct path.");
}
try 
{
    $pdo = new PDO("mysql:Host=$databasehost;dbname=$databasename", 
        $databaseusername, $databasepassword,
        array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL
        )
    );
}
catch (PDOException $e) 
{
    die("database connection failed: ".$e->getMessage());
}

$affectedRows = $pdo->exec("
    LOAD DATA LOCAL INFILE ".$pdo->quote($csvfile)." INTO TABLE `$databasetable`
      FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)."
      OPTIONALLY ENCLOSED BY '\"' "."
      LINES TERMINATED BY ".$pdo->quote($lineseparator));

echo "Loaded a total of $affectedRows records from this csv file.\n";

