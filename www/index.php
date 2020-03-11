<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>RegistrationForm_v7 by Colorlib</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
		
		<!-- STYLE CSS -->
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>



	<?php

set_time_limit(3600);

ob_implicit_flush(1);

if (isset($_POST['msg'])) {

    $server = trim($_POST['server']);
    $port = trim($_POST['port']);
    $phone_nos = explode("\n", $_POST['phone_nos']);
    $sec = (int) $_POST['sec'];
    $msg = urlencode($_POST['msg']);

    foreach ($phone_nos as $data) {
        if (!empty($data)) {

            if (strpos($data, '|') !== false) {
                $data = explode("|", $data);
                $phone = trim($data[0]);
                $beforeSMS = isset($data[1])? urlencode(trim($data[1]) . "\n"):null;
                $afterSMS = isset($data[2])? urlencode(trim($data[2]) . "\n"):null;
            } else {
                $phone = trim($data);
                $beforeSMS = null;
                $afterSMS = null;
            }
            
            if (!empty($afterSMS))
            {
                $msg .= urlencode("\n"); 
            }
            $finalmsg = $beforeSMS . $msg . $afterSMS;


            $url = "http://$server:$port/?number=$phone&message=$finalmsg";
            //echo $url."<br />";continue;
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_PORT, $port);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            //print_r(curl_error($ch));
            curl_close($ch);
           
            echo "<div class=\"sent\">Sending to: $phone</div>";
            
            //this is for the buffer achieve the minimum size in order to flush data
            echo str_repeat(' ',1024*64);
            
            sleep($sec);
        }
    }

}
?>
  

		<div class="wrapper">
			<div class="inner">
				<form action="">
					<h3>ELEGYLE SENDER</h3>
					<p>One way SMS Solution Develped By Zubair Ansari</p>

					<label class="form-group">
						<input type="text" class="form-control" name="server" id="server" value="<?php echo isset($_POST['server'])?$_POST['server']:null; ?>" required>
						<span>Server Address (i.e 192.168.--.--)</span>
						<span class="border"></span>
					</label>

					<label class="form-group">
						<input type="text" class="form-control" name="port" id="port" value="<?php echo isset($_POST['port'])?$_POST['port']:null; ?>" required>

						<span for="">Port No (i.e 8766)</span>
						<span class="border"></span>
					</label>

					<label class="form-group">
						<input type="text" class="form-control" name="sec" id="sec" value="<?php echo isset($_POST['sec'])?$_POST['sec']:null; ?>" required>                        
						<span for="">Delay (Min 5 Sec)</span>
						<span class="border"></span>
					</label>

					<label class="form-group" >
						<textarea class="form-control" name="phone_nos" rows="5" required></textarea>
						<span for="">Contact No ( phone|before SMS|after SMS )</span>
						<span class="border"></span>
					</label>

					<label class="form-group" >
					<textarea class="form-control" rows="5"  name="msg" required><?php echo isset($_POST['msg']) ? urldecode($_POST['msg']) : null; ?></textarea>
                      <span for="">Message</span>
						<span class="border"></span>
					</label>

					<button type="submit">Send 
						<i class="zmdi zmdi-arrow-right"></i>
					</button>
				</form>
			</div>
		</div>
		
	</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>