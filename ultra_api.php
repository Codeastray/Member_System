<?php



$data = file_get_contents("php://input", "r");
$mydata = array();
$mydata = json_decode($data, true);
if(isset($mydata["username"]) && isset($mydata["password"]) && isset($mydata["email"]) && isset($mydata["department"]) && isset($mydata["seniority"]) && isset($mydata["hobby"]) && isset($mydata["area"])){
	if($mydata["username"]!="" && $mydata["password"]!=""  && $mydata["email"]!=""  && $mydata["department"]!=""  && $mydata["seniority"]!=""  && $mydata["hobby"]!=""  && $mydata["area"]!=""){

		$c_username = $mydata["username"];
		$c_password = $mydata["password"];
		$c_email = $mydata["email"];
		$c_department = $mydata["department"];
		$c_seniority = $mydata["seniority"]; 
		$c_hobby = $mydata["hobby"];
		$c_area = $mydata["area"]; 
		// $c_created_at = $mydata["created_at"];
		

		// $servername = "localhost";
		// $username = "owner";
		// $password = "1234567";
		// $dbname = "u933610124_U9H3X";

		// $conn = mysqli_connect($servername, $username, $passward, $dbname);
		// if(!$conn) {
		// 	die("Connection failed:".mysquli_connect_error());
		// }

		// mysql_query($conn, "SET NAMES utf8");



        require_once("dbtool.php");  

        $conn = create_connect();

		$sql = "INSERT INTO user(Username,Password,Email,Department,Seniority,Hobby,Area)VALUES ('$c_username','$c_password','$c_email','$c_department','$c_seniority','$c_hobby','$c_area')";

		if (execute_sql($conn,"u933610124_U9H3X",$sql)){
			echo '{"state" : true, "message" : "註冊成功!" }';
		}else{
			echo '{"state" : false, "message" : "註冊失敗!:'.mysqli_error($conn).$sql.' "}';
		}

		mysqli_close ($conn);

	}else{
		echo '{"state" : false, "message" : "欄位不得為空白!" }';
	}

}else if(isset($mydata["username"])&&isset($mydata["password"])){
    if($mydata["username"]!=""&&$mydata["password"]!=""){
        $check_username = $mydata["username"];
        $check_password = $mydata["password"];
        $UID_1;
        $UID_2;

        require_once("dbtool.php");
        $conn = create_connect();
        $sql = " SELECT Username, Password FROM user WHERE Username = '$check_username' AND Password ='$check_password' ";
        $result =execute_sql($conn,"u933610124_U9H3X",$sql);

        if(mysqli_num_rows($result) == 1){
            $UID_1 = substr(sha1(md5(uniqid(date("l jS \of F Y h:i:s A")))),5,7 );
            $UID_2 = substr(sha1(md5(uniqid(date("l jS \of F Y h:i:s A")))),5,7 );
            $sql = " UPDATE user SET UID_1 ='$UID_1',UID_2 ='$UID_2'  WHERE Username = '$check_username'";
            $result = execute_sql($conn,"u933610124_U9H3X",$sql);
            if($result){
                echo '{"state" : true, "message" : "登入成功!", "UID_1" : "'.$UID_1.'" ,"UID_2" : "'.$UID_2.'"  }';
            }else{
                echo '{"state" : false, "message" : "uid更新失敗，登入失敗" }';
            } 	
        }else{
            echo '{"state" : false, "message" : "登入失敗" }';
        }
        mysqli_close($conn);
    }else{
        echo '{"state" : false, "message" : "欄位不得為空白!" }';
    }

}else if (isset($mydata["UID_1"]) && isset($mydata["UID_2"])) {
    if ($mydata["UID_1"] != "" && $mydata["UID_2"] != "") {
        $C_UID_1 = $mydata["UID_1"];
        $C_UID_2 = $mydata["UID_2"];
        require_once("dbtool.php");
        $conn = create_connect();
        $sql = "SELECT Username,Email,Department,UID_1,UID_2,Level,Seniority FROM user WHERE UID_1 = '$C_UID_1' AND UID_2 = '$C_UID_2' ";
        $result = execute_sql($conn, "u933610124_U9H3X", $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            echo '{"state" : true, "message" : "登入成功","data":' . json_encode($row) . ' }';
        } else {
            echo '{"state" : false, "message" : "登入失敗!" }';
        }
        // $mydata = array();

        // while($row = mysqli_fetch_assoc($result)){
        //   $mydata [] = $row;
        // }
        mysqli_close($conn);
    } else {
        echo '{"state" : false, "message" : "欄位不得為空白!" }';
    }


}else if(isset($mydata["ID"])&& isset($mydata["email"]) && isset($mydata["department"])&& isset($mydata["seniority"])&& isset($mydata["hobby"])&& isset($mydata["area"])&& isset($mydata["level"])){
    if($mydata["ID"]!=""&& $mydata["email"]!="" && $mydata["department"]!=""&& $mydata["seniority"]!=""&& $mydata["hobby"]!=""&& $mydata["area"]!=""&& $mydata["level"]!="" ){

        $u_id = $mydata["ID"];
        // $c_username = $mydata["username"];
        $c_email = $mydata["email"];
        $c_department = $mydata["department"];
        $c_seniority = $mydata["seniority"];
        $c_hobby = $mydata["hobby"];
        $c_area = $mydata["area"];
        $c_level = $mydata["level"];


        require_once("dbtool.php");

        $conn = create_connect();

        $sql = "UPDATE user SET Email = '$c_email',Department = '$c_department',Seniority = '$c_seniority',Hobby = '$c_hobby',Area = '$c_area',Level = '$c_level' WHERE ID ='$u_id'";

        if (execute_sql($conn,"u933610124_U9H3X",$sql)) {
            if(mysqli_affected_rows($conn)==1){
                echo'{"state": true, "message":"更新成功!"}';
            }else{
                echo '{"state": false, "message":"更新失敗, 語法成功但無此欄位!"}';
            }
         // echo '{"state": true, "message":"更新成功!"'.mysqli_affected_rows($link).'}';
        } else {
          echo '{"state": false, "message":"更新失敗!"}';
        }

        mysqli_close($conn);
    }else{
        echo '{"state": false, "message":"欄位不得為空白!"}';
    }
}else if(isset($mydata["ID"])){
    if(true){
        $d_id = $mydata["ID"];
    
        require_once("dbtool.php");

        $conn = create_connect();
        $sql = "DELETE FROM user WHERE ID ='$d_id'";	
        

         

      if (execute_sql($conn,"u933610124_U9H3X",$sql)) {
          if(mysqli_affected_rows($conn)==1){
            echo'{"state": true, "message":"刪除成功!"}';
          }else{
            echo '{"state": false, "message":"刪除失敗, 語法成功但無此資料!"}';
          }
       // echo '{"state": true, "message":"更新成功!"'.mysqli_affected_rows($conn).'}';
      } else {
        echo '{"state": false, "message":"刪除失敗!'.mysqli_error($conn).'"}';
      }

      mysqli_close($conn);
    }else{
      echo '{"state": false, "message":"欄位不得為空白!"}';
    }
    
}else if(isset($mydata["username"])){
    if($mydata["username"]!=""){
        $check_username = $mydata["username"];
        require_once("dbtool.php");

        $conn = create_connect();

        $sql = "SELECT Username FROM user WHERE Username = '$check_username'";
        $result =execute_sql($conn,"u933610124_U9H3X",$sql);

        if(mysqli_num_rows($result) == 1){
            echo '{"state" : false, "message" : "帳號存在，不可以使用" }';
        }else{
            echo '{"state" : true, "message" : "帳號不存在，可以使用!" }';
        }

        // $mydata = array();

        // while($row = mysqli_fetch_assoc($result)){
        //   $mydata [] = $row;
        // }
        mysqli_close($conn);
    }else{
        echo '{"state" : false, "message" : "欄位不得為空白!" }';
    }

}else if(true){
    require_once("dbtool.php");

    $conn = create_connect();

	$sql = "SELECT ID,Username,Email,Department,Seniority,Hobby,Area,Level,Created_at FROM user ORDER BY ID DESC";
	$result =execute_sql($conn,"u933610124_U9H3X",$sql);
	if(mysqli_num_rows($result) > 0){
	   $mydata = array();
	   while($row = mysqli_fetch_assoc($result)){
	   $mydata [] = $row;
	  
	  // echo json_encode($mydata);

	}
		echo '{"state" : true, "data":'.json_encode($mydata).',"message" : "資料讀取成功!" }';
	}else{
		echo '{"state" : false, "message" : "讀取資料失敗" }';
		
	}

}else{
    echo '{"state": false, "message":"API規定的欄位不存在!"}';
}


    ?>
