          <div class="container">
          <br>
            <div class="form-group row">
                <div class="col-1 col-md-4"></div>
                <div class="col-5 col-md-2">
                  <a class="btn-ct" href="index.php" role="button"><i class="fas fa-home mr-2"></i><br>หน้าหลัก</a>
                </div>
                <div class="col-5 col-md-2">
                  <a class="btn-ct" href="../logout.php" role="button"><i class="fas fa-sign-out-alt mr-2"></i><br>ออกจากระบบ</a>
                </div>
                <div class="col-1 col-md-4"></div>
              </div>
          <?php
                $i = 1; 
                //--------------------------permission menu
                if($user_group!=''){
                  $sql_c = "SELECT ref_menu_detail ,ref_menu FROM permission WHERE group_menu = '$user_group' GROUP BY ref_menu_detail ,ref_menu ORDER BY ref_menu ";
                  }else{
                  $sql_c = "SELECT ref_menu_detail ,ref_menu FROM permission WHERE ref_user = '$user_id' GROUP BY ref_menu_detail ,ref_menu ORDER BY ref_menu ";
                  }
                  //echo "---$sql_c---<br>";
                  $result = mysqli_query($mysqli,$sql_c);
                  $rowcount=mysqli_num_rows($result);                

                if($user_group!=''){
                $sql_p = "SELECT ref_menu_detail ,ref_menu FROM permission WHERE group_menu = '$user_group' GROUP BY ref_menu_detail ,ref_menu ORDER BY ref_menu ";
                }else{
                $sql_p = "SELECT ref_menu_detail ,ref_menu FROM permission WHERE ref_user = '$user_id' GROUP BY ref_menu_detail ,ref_menu ORDER BY ref_menu ";
                }
                
                $query_p = mysqli_query($mysqli,$sql_p);
                while($result_p=mysqli_fetch_array($query_p,MYSQLI_ASSOC))
                {
                    $se_ref_menu_detail=$result_p['ref_menu_detail'];
                    $se_ref_menu=$result_p['ref_menu'];
                   
                        $se_link_m='';
                        $sql_m = "SELECT * FROM menu_detail WHERE id = '$se_ref_menu_detail' AND (sta = 'A' OR sta = 'P') ";
                        $query_m = mysqli_query($mysqli,$sql_m);
                       
                        while($result_m=mysqli_fetch_array($query_m,MYSQLI_ASSOC))
                        {
                            $se_id_m=$result_m['id'];
                            $se_name_m=$result_m['name'];
                            $se_link_m=$result_m['link'];
                            $se_icon_m=$result_m['icon'];

                            $x = ($i%2) == 1; 
                            $y = ($i%2) == 0;  

                         if($x == '1'){
                            $se_name_m2 = $se_name_m; 
                            $se_link_m2 = $se_link_m;
                            $se_icon_m2 = $se_icon_m;
                    ?>
                    <div class="form-group row">
                    <div class="col-1 col-md-4"></div>                   
                    <div class="col-5 col-md-2"><a class="btn-ct" href="<?php echo$se_link_m2?>" role="button"><i class="<?php echo$se_icon_m2 ?>"></i><br><?php echo$se_name_m2 ?></a></div>
                    <?php
                        }elseif($y == '1' ){
                            $se_name_m3 = $se_name_m;
                            $se_link_m3 = $se_link_m;  
                            $se_icon_m3 = $se_icon_m;
                    ?>
                    <div class="col-5 col-md-2"> <a class=" btn-ct" href="<?php echo$se_link_m3?>" role="button"><i class="<?php echo$se_icon_m3 ?>"></i><br><?php echo$se_name_m3 ?></a></div>
                    <div class="col-1 col-md-4"></div>
                    </div>
                    <?php
                      }
                    $i++;
                      }                
                    }
                    ?>                 
            </div>
            </div>