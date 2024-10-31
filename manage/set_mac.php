  <script language="JavaScript">
    function chkSub(form) {
      if (form.i_SO.value == "") {
        alert("กรุณาเลือก Mac ด้วยครับ");
        form.i_SO.focus();
        return false;
      } 
    }
  </script>

<?php
@$user_id=$_SESSION['id'];

@$result = $mysqli->query("SELECT M.id_mac, M.mac FROM user AS U INNER JOIN mac AS M ON U.id_mac = M.id_mac WHERE U.id='$user_id'");
@$row = $result->fetch_assoc();
@$se_id_mac=$row['id_mac'];
@$se_mac=$row['mac'];
?>

<body>
    <div class="card-header bg-secondary">
    <h3 class="card-title"><i class="fas far fas fa-archive mr-2"></i>ตั้งค่า Mac</h3>
    </div>
      <div class="container">
        <form action="sql_set_mac.php" method="post" enctype="multipart/form-data" onSubmit="return chkSub(this)">
          <br>
          
            <div class="form-group row">
              <!--col12-->
              <div class="col-3 col-md-2 text-right"><label for="i_MAC" class="col-form-label">Mac : </label></div>
              <div class="col-6 col-md-3">

                <select name="i_MAC" id="i_MAC">
                  <?php
                    if($se_id_mac != 0){
                      echo "<option value=\"$se_id_mac\">$se_mac</option>";
                    }else{
                      echo "<option value=\"\">เลือก MAC</option>";
                    }

                    $sql_mac = "SELECT id_mac, mac FROM mac ";
                    $query_mac = mysqli_query($mysqli,$sql_mac);
                    while($rowmac=mysqli_fetch_array($query_mac,MYSQLI_ASSOC))
                    {
                      $SE_ID_MAC = $rowmac['id_mac'];
                      $SE_MAC = $rowmac['mac'];
                      echo "<option value=\"$SE_ID_MAC\">$SE_MAC</option>";
                    }
                  ?>
                </select>

              </div>
              <div class="col-3 col-md-7"></div>
            </div>

            <div class="form-group row">
              <!--col12-->
              <div class="col-3 col-md-2 mb-2"></div>
              <div class="col-6 col-md-3"><button type="submit" class="btn btn-primary" name="sub_int" id="sub_int" value="int">บันทึก</button></div>
              <div class="col-3 col-md-7"></div>
            </div>

        </form>
      </div>
</body>