<?php
require('lib/db-function.php');
ini_set("display_errors","0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
<link rel="stylesheet" href='main.css'>
</head>
<body>
<div class="container">
    <h2>To-Do List</h2>
    <form class="todo-form" id="todoForm" action="./index.php" method = "post">
        <input type="text" id="todoInput" placeholder="Yapılacaklar..." name="todoinput">
        <input type="submit" value="Ekle">
    </form>
 <?php
        $query = "table_todo";
        $todos = getItemAll($query);
        foreach($todos as $value){
            echo '<li id = "'.$value['id'].'">'.$value['id'].' = '.$value['task'].'</li>';
            }
 ?>

<?php 
if($_POST['todoinput']){
    $todo_deger = $_POST['todoinput'];
    $todo_add =" INSERT INTO `table_todo`(`task`) VALUES ('$todo_deger')";
    if(safe_query($todo_add) === FALSE){
        echo "ekleme işlemi başarısız";
    }
    else{   
        header("refresh:0");
        exit();
    }
}
   // if(safe_query($todo_add)){
       // echo "ekleme işlemi başarılı oldu";
      // echo '<script>refreshPage();</script>'; 
       // header("refresh:0");
       // exit();
    
  //  else{
        //echo "ekleme işlemi başarısız oldu";
     //    header("refresh:0");
  //       exit();
  //  }

if(isset($_POST["todosil"])){
    $gorev_id = $_POST["todosil"];
    if(silme($gorev_id) === FALSE){
        echo "silme işlemi başarısız oldi";
    }
    else{
        header("refresh:0");
        exit();
    }
}

if(isset($_POST["tumsil"])){
    $Cut_Table="Table_todo";
    if(getItemCutAll($Cut_Table) === FALSE){
        echo "silme işleminde hata meydana geldi";
    }
    else{
        header("Refresh:0");
        exit();
    }
}
?>
    <form class="todo-form" id="todoForm" action="./index.php" method = "post">
        <input type="text" id="todoInput" placeholder="seçileni sil..." name="todosil">
        <input type="submit" value="sil">
    </form>
    <form class="todo-form" id="todoForm" action="./index.php" method = "post">
        <input type="submit" value="Tümünü sil" name="tumsil">
    </form>
    </div>
</body>
</html>