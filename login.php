<?php
include_once("config.php");
?>

<style type="text/css">	
	
    .marlogo {
       text-align: center;
       margin-top: 3%;
          }

    .martitle {
       text-align: center;
          }

    .marlogin {
       margin-top: 15px;
          }
   
  </style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="node_modules_s/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="asset/css/login.css">
    <title><?php echo "$title";?></title>
</head>

<body>

<div class="marlogo"><img src="images/login/bg_login.jpg" class="contentLogo" width="300"></div>
    <section class="marlogin">
        <h5 class="martitle"><?php echo "$title";?></h5>
        <br>
        <div class="container">
            <div class="row row-cols-1">
                <form action="chk_admin.php" method="post"onsubmit="return chkSub(this)"/>
                    <input name="login_admin" type="text" class="form-control2" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
                    <br>
                    <input name="pswd_admin" type="password" class="form-control2" placeholder="Password" aria-label="Username" aria-describedby="addon-wrapping">
                    <br>
                    <input  class="button" type="submit" value="Login">
                </form>
            </div>
        </div>
    </section>

    <SCRIPT language=JavaScript>
   
    function chkSub(form){
        if (form.login_admin.value==""){
        alert("กรุณากรอก Username ด้วยครับ")
        form.login_admin.focus();
        return false;
        }
        else if (form.pswd_admin.value==""){
        alert("กรุณากรอก Password ด้วยครับ")
        form.pswd_admin.focus();
        return false;
        }
    }

    </SCRIPT>

</body>
</html>