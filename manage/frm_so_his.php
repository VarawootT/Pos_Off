<?php
@$result = $mysqli->query("SELECT wh, team FROM `user` WHERE id='$user_id'");
@$row = $result->fetch_assoc();
@$SE_WH = $row['wh'];
@$SE_TEAM = $row['team'];
?>

<?php
if ($SE_WH == 'ALL') {
?>

  <SCRIPT language=JavaScript>
    function chkSub(form) {

      if (form.i_WH.value == "") {
        alert("กรุณาเลือก คลัง ด้วยครับ")
        form.i_WH.focus();
        return false;
      }

    }
  </SCRIPT>

<?php
}
?>


<form action="?link=s_so_his" method="post" enctype="multipart/form-data" onSubmit="return chkSub(this)">

  <div class="card-header bg-secondary">
    <h3 class="card-title"><i class="fas far fas fa-archive mr-2"></i>ประวัติขาย</h3>
  </div>
  <div class="container">
    <br>
    <div class="form-group row">
      <!--col12-->
      <div class="col-3 col-md-2 text-right"><label for="i_DATE1" class="col-form-label">วันที่ : </label></div>
      <div class="col-6 col-md-3"><input class="form-control form-control-sm" type="date" placeholder="จำนวน" name="i_DATE1" value="<?php echo date('Y-m-d'); ?>"></div>
      <div class="col-3 col-md-7"></div>
    </div>

    <div class="form-group row">
      <!--col12-->
      <div class="col-3 col-md-2 text-right"><label for="i_DATE2" class="col-form-label">ถึงวันที่ : </label></div>
      <div class="col-6 col-md-3"><input class="form-control form-control-sm" type="date" placeholder="จำนวน" name="i_DATE2" value="<?php echo date('Y-m-d'); ?>"></div>
      <div class="col-3 col-md-7"></div>
    </div>

    <div class="form-group row">
      <!--col12-->
      <div class="col-3 col-md-2 text-right"><label for="i_user" class="col-form-label">สาขา : </label></div>
      <div class="col-6 col-md-3">
        <select class="form-control select2bs4" name="user_sale" id="user_sale">
          <?php if ($SE_WH == "" || $SE_WH == "ALL") { ?>
            <option value="" selected>โปรดเลือกสาขา</option>
          <?php
          } else {
          }
          if ($SE_WH == "" || $SE_WH == "ALL") {
            $user_sale = $mysqli->query("SELECT wh,name_wh FROM `p_wh` GROUP BY wh,name_wh");
          } else {
            $user_sale = $mysqli->query("SELECT wh,name_wh FROM `p_wh` WHERE wh = '$SE_WH' GROUP BY wh,name_wh");
          }
          while ($row = $user_sale->fetch_assoc()) {
            $wh = $row['wh'];
            $wh_name = $row['name_wh'];

            echo "<option value=\"$wh\">$wh | $wh_name</option>";
          }

          ?>
        </select>
      </div>
      <div class="col-3 col-md-7"></div>
    </div>

    <div class="form-group row">
      <!--col12-->
      <div class="col-3 col-md-2 text-right"><label for="i_DATE2" class="col-form-label">ผู้ขาย : </label></div>
      <div class="col-6 col-md-3">

        <select class="form-control select2bs4" name="user_s" id="user_s">
          <option value="" selected>โปรดเลือกผู้ขาย</option>

          <?php
          if ($SE_WH == "" || $SE_WH == "ALL") {
            $result = $mysqli->query("SELECT * FROM `user` WHERE id in (select iduser from `p_so_h`)");
          } else {
            $result = $mysqli->query("SELECT * FROM `user` WHERE wh = '$SE_WH' AND id in (select iduser from `p_so_h`)");
          }
          while ($row = $result->fetch_assoc()) {
            $SE_USER_NAME = $row['name'];
            $SE_USER_LNAME = $row['lname'];
            $SE_USER_ID   = $row['id'];
            echo "<option value=\"$SE_USER_ID\">$SE_USER_NAME - $SE_USER_LNAME</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-3 col-md-7"></div>
    </div>


    <div class="form-group row">
      <!--col12-->
      <div class="col-3 col-md-2 mb-2"></div>
      <div class="col-6 col-md-3"><button type="submit" class="btn btn-primary" name="sub_int" id="sub_int" value="int">ค้นหา</button></div>
      <div class="col-3 col-md-7"></div>
    </div>

  </div>

</form>
<script type="text/javascript">
  $('#user_sale').change(function() {
    var user_sale = $(this).val();

    $.ajax({
      type: "POST",
      url: "ajax_summary.php",
      data: {
        user_sale: user_sale
      },
      success: function(data) {
        $('#user_s').html(data);
      }
    });
  });
</script>