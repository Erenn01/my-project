<?php

class Database{

public static function db(){

$ini = dirname(__FILE__)."/dbconfig.ini";
$config = parse_ini_file($ini, true);
if($config === false){
  die("INI DOSYASI OKUNAMADI");
}
   $Hostname = $config["Host"];
   $Dataname = $config["dbname"];
   $Username = $config["username"];
   $Password = $config["password"];
   $dsn = "mysql:Host={$Hostname};dbname={$Dataname}";
   try{
   $pdo = new PDO($dsn,$Username,$Password ,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
   return $pdo;
}
catch(PDOException $e){
    die("veritabanı bağlantısı hatası".$e->getMessage());
}
}
}
function getItemAll($table){ // parametrede girilen tablodaki tüm verileri çeker.
    $query = "SELECT * FROM $table";
    $pdo = Database::db();
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC); // tüm verileri çektiğimiz için fetcAll kullandık.
    return $row;
}

    function safe_query($query){
       try{
        $pdo = Database::db();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
       }
       catch(PDOException $e){
        die("başarısız hata". $e->getMessage());
    }
}

function silme($gorev_id){
try{
    $pdo = Database::db();
    $query = "DELETE FROM `table_todo` WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':id'=> $gorev_id));
    return true; 
}
catch(PDOException $e){
    echo "Görev silinirken bir hata oluştu: " . $e->getMessage();
}
}
function getItemCutAll($table){
    try{
        $pdo = Database::db();
        $query = "DELETE FROM $table ; ALTER TABLE $table AUTO_INCREMENT= 1"; // burada alter tableyi "id yi" sifirlamasi icin kullandim.
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $msg = "tüm veriler silinmiştir";
        return $msg;
    }
    catch(PDOException $e){
      die("silme işleminde bir hata meydana geldi!". $e->getMessage());
    }
}
?>