<?php 
// session_start();
include_once("../config.php");

if(isset($_POST['user_sale']) && ($_POST['user_sale'])){
    $i_sale = $_POST['user_sale'];
    echo '<option value="">โปรดเลือกผู้ขาย</option>';
    $user_s = $mysqli->query("SELECT name,lname,user,id FROM `user` WHERE wh = '$i_sale' AND id in (select iduser from `p_so_h`)");
    while($rowu = $user_s->fetch_assoc()){
        $name  = $rowu['name'];
        $lname = $rowu['lname'];
        $user  = $rowu['id'];
        $user_name  = $rowu['user'];

        echo "<option value=\"$user\">$user_name | $name $lname</option>";
    }
}
?>