<!-- <script type="text/javascript">
async function getUserIP() {
    try {
        const response = await fetch('https://api.ipify.org?format=json');
        const data = await response.json();
        console.log('Your IP Address is: ' + data.ip);
        document.getElementById('ipDisplay').innerText = 'IP Address: ' + data.ip;
    } catch (error) {
        console.error('Error fetching IP:', error);
    }
}

getUserIP();
</script>

-->
<?php
        $Com_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $ip = GetHostByName($_SERVER['REMOTE_ADDR']);
        $Hos_ton = gethostbyaddr('10.68.7.130');
        echo $ip . "<br>";
        echo $Hos_ton . "<br>";
        echo $Com_name;

        echo "<pre>";
        print_r($_SERVER);
        echo "</pre>";
        echo "<pre>";
        print_r($_ENV);
        echo "</pre>";

        ?>

<!-- <?php
echo $_SERVER['AUTH_USER']; // ดึงชื่อผู้ใช้ที่เข้าสู่ระบบ Windows
?> -->