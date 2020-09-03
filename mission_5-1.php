<body>

<?php

$dsn = 'datebasename';
    $user = 'username';
    $password = 'mypassword';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    /*$sql = "CREATE TABLE IF NOT EXISTS BOARDS2"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment char(32),"
    . "date DATETIME,"
    . "password INT"
    .");";
    $stmt = $pdo->query($sql);*/

    /*$sql ='SHOW CREATE TABLE BOARDS2';
	$result = $pdo -> query($sql);
    foreach ($result as $row)
        {
		echo $row[1];
	    }
        echo "<hr>";*/
    
        if(isset($_POST["submit"]))
            {
            $phpname=($_POST["名前"]);
            $phpcomment=($_POST["コメント"]);
            $phppassword=($_POST["password"]);
            if(!empty($phpname) and !empty($phpcomment) and !empty($phppassword)) 
                {
                $sql = $pdo -> prepare("INSERT INTO BOARDS2 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
	            $sql -> bindParam(':name', $sqlname, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $sqlcomment, PDO::PARAM_STR);
                $sql -> bindParam(':date', $sqlpostedat, PDO::PARAM_STR);
                $sql -> bindParam(':password', $sqlpassword, PDO::PARAM_STR);

	            $sqlname=$phpname;
                $sqlcomment=$phpcomment;
                $sqlpostedat=date("Y/m/d H:i:s");
                $sqlpassword=$phppassword;
                $sql -> execute();
                }
            }
    
        if (isset($_POST["delete"])) 
            {
            $sql = 'SELECT * FROM BOARDS2';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
            foreach ($results as $row)
                {
                $phpdelpassword=($_POST["delpassword"]);
                if ($row['password'] == $phpdelpassword)
                    {
                    $phpdelete = $_POST["deleteNo"];
                    $id =$phpdelete ;
                    $sql = 'delete from BOARDS2 where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();    
                    }
                }
            }

        if (isset($_POST["edit"]))
            {
            $sql = 'SELECT * FROM BOARDS2';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
            foreach ($results as $row)
                {
                if ($row['password']==$_POST["edpassword"])
                    {
                    $id = $_POST["edNo"];
	                $sqlname =$_POST["ed名前"];
	                $sqlcomment =$_POST["edコメント"];
	                $sql = 'UPDATE BOARDS2 SET name=:name,comment=:comment WHERE id=:id';
	                $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':name', $sqlname, PDO::PARAM_STR);
	                $stmt->bindParam(':comment', $sqlcomment, PDO::PARAM_STR);
	                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                $stmt->execute();    
                    }
                }
            }

    $sql = 'SELECT * FROM BOARDS2';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
    foreach ($results as $row)
        {
		echo $row['id'].' ';
        echo $row['name'].' ';
        echo $row['comment'].' ';
        echo $row['date'].' ';
	    echo "<hr>";
	    }
    
    
?>

    <form action="" method="POST">
    <input type="string" name="名前" placeholder="名前を入力してください"><br>
    <input type="string" name="コメント" placeholder="コメント"><br>
    <input type="string" name="password" placeholder="パスワード" ><br>
    <input type="submit" name="submit">
    </form>
    

    
    <form action="" method="POST">
        <input type="string" name="edNo" placeholder="編集番号指定用フォーム"><br>
        <input type="string" name="ed名前" placeholder="名前"><br>
        <input type="string" name="edコメント" placeholder="コメント"><br>
        <input type="string" name="edpassword" placeholder="パスワード"><br>
        <input type="submit" name="edit">
    </form> 
    
    <form action="" method="POST">
    <input type="text" name="deleteNo"><br>
    <input type="string" name="delpassword" placeholder="パスワード" ><br>
    <input type="submit" name="delete" value="削除">
    </form>

</body>