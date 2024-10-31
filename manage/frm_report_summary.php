<?php
	@$result = $mysqli->query("SELECT wh, team FROM `user` WHERE id='$user_id'");
	@$row = $result->fetch_assoc();
	@$SE_WH=$row['wh'];
    @$SE_TEAM=$row['team'];
?>
<style>
    .select2-selection__rendered {
        line-height: 31px !important;
    }

    .select2-container .select2-selection--single {
        height: 35px !important;
    }
</style>

<form action="print_report_summary.php" method="post" enctype="multipart/form-data"> <!-- form ใช้สำหรับกำหนด สิ่งต่างใน from นี้ เพื่อนำไป action เข้าไปที่หน้านึง -->
    <div class="card-header bg-secondary"> <!-- เรียก funtion card-header สำหรับกำหนดให้ตัวนี้เป็นหัวและกำหนดให้สีเป็นสีเทา  -->
        <h3 class="card-title"><i class="fas far fas fa-archive mr-2"></i>สรุปการขาย</h3> <!-- //หัวกำนดหน้า กำหนดให้ h3 -->
    </div>
    <div class="container"> <!-- ตัวเปิด container -->
        <br> <!-- //เว้นวางเพื่อไม่ให้ติดกับหน้าบนมาเกินไป -->
        <!-- ---------------------------------------------------------------------------------------------------------------------------------------------------------------วันที่เริ่มหา -->
        <div class="form-group row"> <!-- // แบ่งกันให้เป็นกลุ่ม และ แสดงเป๋นในรูปแบบ row ใน class นี้ หรือ ไปด้านข้าง -->
            <div class="col-3 col-md-2 text-right"><label for="i_DATE1" class="col-form-label">วันที่ :</label></div><!-- //เว้นหน้าว่าง 2 แถวของ bootstrap และเพิ่ม text-align เป็น right -->
            <div class="col-6 col-md-3">
                <input class="form-control form-control-sm" type="datetime-local" step="1" name="i_DATE1" id="i_DATE1" value="<?php echo date('Y-m-d\TH:i:s',mktime(8, 0, 0)); ?>"> <!-- // input รับวันที่เข้ามาในระบบ โดยกำหนด id="i_date1" และ กดหนด values เป็นวันนี้ -->
            </div>
            <div class="col-3 col-md-7"></div><!-- ตัวปิดกำหนดแถวละ 12 col-md-12 เท่านั้น แต่ละแถวมี col-md-12 แถว -->
        </div>
        <!-- //---------------------------------------------------------------------------------------------------------------------------------------------------------------ถึงวันที่ต้องการ -->
        <div class="form-group row"> <!-- // แบ่งกันให้เป็นกลุ่ม และ แสดงเป๋นในรูปแบบ row ใน class นี้ หรือ ไปด้านข้าง -->
            <div class="col-3 col-md-2 text-right"><label for="i_DATE2" class="col-form-label">ถึงวันที่ :</label></div> <!-- //เว้นหน้าว่าง 2 แถวของ bootstrap  -->
            <div class="col-6 col-md-3">
                <input class="form-control form-control-sm" type="datetime-local" step="1" name="i_DATE2" id="i_DATE2" value="<?php echo date('Y-m-d\TH:i:s',mktime(18, 0, 0)); ?>">  <!-- // input รับวันที่เข้ามาในระบบ โดยกำหนด id="i_date1" และ กำหนด values เป็นวันนี้ -->
            </div>
            <div class="col-3 col-md-7"></div><!-- ตัวปิดกำหนดแถวละ 12 col-md-12 เท่านั้น แต่ละแถวมี col-md-12 แถว -->
        </div>
        <!-- //---------------------------------------------------------------------------------------------------------------------------------------------------------------userชองคนที่ขาย -->
        <div class="form-group row"> <!-- // แบ่งกันให้เป็นกลุ่ม และ แสดงเป๋นในรูปแบบ row ใน class นี้ หรือ ไปด้านข้าง -->
            <div class="col-3 col-md-2 text-right"><label for="i_DATE1" class="col-form-label">สาขา :</label></div> <!-- //เว้นหน้าว่าง 2 แถวของ bootstrap  -->
            <div class="col-6 col-md-3">
                <select class="form-control select2bs4" name="user_sale" id="user_sale">
                    <?php if($SE_WH == "" || $SE_WH == "ALL" ){ ?>
                    <option value="" selected>โปรดเลือกสาขา</option>
                    <?php
                    }else{ }                                                                              //query เก่า ปิดไว้วันที่ 2024-09-02               
                    // $user_sale = $mysqli->query("SELECT iduser,name,lname FROM `p_so_h`             //query เก่า ปิดไว้วันที่ 2024-09-02                                                                                
                    // A INNER JOIN `user` B ON A.iduser = B.ID GROUP BY iduser,name,lname");          //query เก่า ปิดไว้วันที่ 2024-09-02                                                                                   
                    // while($row = $user_sale->fetch_assoc())                                         //query เก่า ปิดไว้วันที่ 2024-09-02                                                    
                    // {                                                                               //query เก่า ปิดไว้วันที่ 2024-09-02              
                    //     $user_id = $row['iduser'];                                                  //query เก่า ปิดไว้วันที่ 2024-09-02                                           
                    //     $user_name = $row['name'];                                                  //query เก่า ปิดไว้วันที่ 2024-09-02                                           
                    //     $user_lname = $row['lname'];                                                //query เก่า ปิดไว้วันที่ 2024-09-02                                             
                    //     echo "<option value=\"$user_id\">$user_name $user_lname</option>";          //query เก่า ปิดไว้วันที่ 2024-09-02                                                                                   
                    // }                                                                               //query เก่า ปิดไว้วันที่ 2024-09-02
                    if($SE_WH == "" || $SE_WH == "ALL" ){
                    $user_sale = $mysqli->query("SELECT wh,name_wh FROM `p_wh` GROUP BY wh,name_wh");  //edit 2024-09-02 time
                    }else{
                    $user_sale = $mysqli->query("SELECT wh,name_wh FROM `p_wh` WHERE wh = '$SE_WH' GROUP BY wh,name_wh");
                    }                                                                                      
                    while($row = $user_sale->fetch_assoc())                                                                //edit 2024-09-02 time                                                
                    {                                                                                                      //edit 2024-09-02 time          
                        $wh = $row['wh'];                                                                                  //edit 2024-09-02 time                              
                        $wh_name = $row['name_wh'];                                                                        //edit 2024-09-02 time                                        
                                                                                                                           //edit 2024-09-02 time             
                        echo "<option value=\"$wh\">$wh | $wh_name</option>";                                              //edit 2024-09-02 time                                                                  
                    }                                                                                                      //edit 2024-09-02 time

                    ?>
                </select><!-- // input รับวันที่เข้ามาในระบบ โดยกำหนด id="i_date1" และ กำหนด values เป็นวันนี้ -->
            </div>
            <div class="col-3 col-md-7"></div><!-- ตัวปิดกำหนดแถวละ 12 col-md-12 เท่านั้น แต่ละแถวมี col-md-12 แถว -->
        </div>
       <!-- //----------------------------------------------------------------------------------------------------------------------------------------------------------------userผู้ขายแบบตัวเลือก -->
        <div class="form-group row">
            <div class="col-3 col-md-2 text-right">
                <label for="i_user" class="col-form-label">ผู้ขาย :</label>
            </div>
            <div class="col-6 col-md-3">
                <select class="form-control select2bs4" name="user_s" id="user_s">

                    <option value="">โปรดเลือกผู้ขาย</option>
                    <?php
                    if($SE_WH == "" || $SE_WH == "ALL" ){
                    $user_s = $mysqli->query("SELECT name,lname,user,id FROM `user` WHERE id in (select iduser from `p_so_h`)");
                    }else{
                    $user_s = $mysqli->query("SELECT name,lname,user,id FROM `user` WHERE wh = '$SE_WH' AND id in (select iduser from `p_so_h`)");    
                    }
                    while($rowu = $user_s->fetch_assoc())
                    {
                        $name  = $rowu['name'];
                        $lname = $rowu['lname'];
                        $user_name = $rowu['user'];
                        $user  = $rowu['id'];

                        echo "<option value=\"$user\">$user_name | $name $lname</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-3 col-md-7"></div>
        </div>
       <!--  //---------------------------------------------------------------------------------------------------------------------------------------------------------------ปุ่มกดเพื่อดำเนินการระบบ -->
        <div class="form-group row"> <!-- // แบ่งกันให้เป็นกลุ่ม และ แสดงเป๋นในรูปแบบ row ใน class นี้ หรือ ไปด้านข้าง -->
            <div class="col-3 col-md-2"></div> <!-- //เว้นหน้าว่าง 2 แถวของ bootstrap  -->
            <div class="col-6 col-md-3"><button type="submit" class="btn btn-primary" name="sub_int" id="sub_int" value="int" >ค้นหา</button></div> <!-- ปุ่ม submit เพื่อ Action กับ form ไปอีกหน้านึง  -->
            <div class="col-3 col-md-7"></div><!-- ตัวปิดกำหนดแถวละ 12 col-md-12 เท่านั้น แต่ละแถวมี col-md-12 แถว -->
        </div> 
       <!--  //--------------------------------------------------------------------------------------------------------------------------------------------------------------จบหน้า -->

    </div> <!--ตัวปิด container -->
</form> <!-- ตัวปิด form -->


<script type="text/javascript">
$('#user_sale').change(function(){
   var  user_sale = $(this).val();

   $.ajax({
    type: "POST",
    url: "ajax_summary.php",
    data: {user_sale:user_sale},
    success:function(data){
        $('#user_s').html(data);
    }
   });
});
</script>