<?php
  function escape($string){
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    <title>API Test Suite </title>
  </head>
  <body>
    <main class="container">
      <div class="header">
          API tester Hesita CP
      </div>
      <div class="content">
        <ul>
            <li>Step 1: Login in to your Hesita server</li>
            <li>Step 2: Go to "Server" (Cogs icon) -> Configure server -> Security</li>
            <li>Step 3: Go to API -> Enable API Access (Yes)</li>
            <li>Step 4: Enter your server ip (<?php echo $_SERVER['SERVER_ADDR'];?>) and if on the same server also enter 127.0.0.1</li>
            <li>Step 5: Save</li>
            <li>Step 6: Go to the admin user</li>
            <li>Step 7: Create a new Access key</li>
            <li>Step 8: Select DNS cluster</li>
            <li>Step 9: Fill the form below</li>
      </div>
      <?php
        if($_POST){
        $fields = array('hostname', 'port', 'access_key', 'secret_key', 'cmd','returncode');
        $check = true;
        foreach ( $fields as $field){
          if(empty($_POST[$field])){
            $check = false;
          }
        }
        $empty = array('arg1','arg2','arg3','arg4','arg5','arg6','arg7','arg8','arg9');

        
        if(!is_numeric($_POST['port'])){
          $check = false;
        }
        if($check === true){
          $postvars = array(
              'access_key' => $_POST['access_key'],
              'secret_key' => $_POST['secret_key'],
              'returncode' => $_POST['returncode'],
              'cmd' => $_POST['cmd'],
          );
          foreach ( $empty as $field){
            if(!empty($_POST[$field])){
              $postvars[$field] = $_POST[$field];
            }
          }
          $postdata = http_build_query($postvars);
          $curl = curl_init();
          curl_setopt($curl, CURLOPT_URL, 'https://' . $_POST['hostname'] . ':' . $_POST['port'] . '/api/');
          curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
          $answer = curl_exec($curl);
        }
        ?>
          <pre><?php var_dump($answer);?></pre>
        <?php
      }
      
      ?>
      <form action="" method="post" id="form">
            <!-- Markup example 1: input is inside label -->
            <label for="hostname">Hostname</label>
              <input type="text" id="hostname" name="hostname" placeholder="Hostname" required <?php if(!empty($_POST['hostname'])){ echo 'value="'.escape($_POST['hostname']).'"';} ?> >
            <label for="port">Port</label>
              <input type="text" id="port" name="port" placeholder="Port" required <?php if(!empty($_POST['port'])){ echo 'value="'.escape($_POST['port']).'"';}else{ echo 'value="8083"';} ?>>
            <label for="accesskey">Access key</label>
              <input type="text" id="access_key" name="access_key" placeholder="Access key" required <?php if(!empty($_POST['access_key'])){ echo 'value="'.escape($_POST['access_key']).'"';} ?>>
            <label for="sercretkey">Secret key</label>
              <input type="text" id="secret_key" name="secret_key" placeholder="Sercret key" required <?php if(!empty($_POST['secret_key'])){ echo 'value="'.escape($_POST['secret_key']).'"';} ?>>
            <label for="cmd">Return code</label>
              <input type="text" id="returncode" name="returncode" placeholder="no" required value="no" <?php if(!empty($_POST['returncode'])){ echo 'value="'.escape($_POST['returncode']).'"';} ?>>
            <label for="cmd">Command</label>
              <input type="text" id="cmd" name="cmd" placeholder="v-list-users" required <?php if(!empty($_POST['cmd'])){ echo 'value="'.escape($_POST['cmd']).'"';} ?>>
            <label for="arg1">Argument 1</label>
            <input type="text" id="arg1" name="arg1" placeholder="json">
            <label for="arg2">Argument 2</label>
            <input type="text" id="arg2" name="arg2" placeholder="">
            <label for="arg3">Argument 3</label>
            <input type="text" id="arg3" name="arg3" placeholder="">
            <label for="arg4">Argument 4</label>
            <input type="text" id="arg4" name="arg4" placeholder="">
            <label for="arg5">Argument 5</label>
            <input type="text" id="arg5" name="arg5" placeholder="">
            <label for="arg6">Argument 6</label>
            <input type="text" id="arg6" name="arg6" placeholder="">
            <label for="arg7">Argument 7</label>
            <input type="text" id="arg7" name="arg7" placeholder="">
            <label for=""></label>
            <label for="arg8">Argument 8</label>
            <input type="text" id="arg8" name="arg8" placeholder="">
            <label for="arg9">Argument 9</label>
            <input type="text" id="arg9" name="arg9" placeholder="">
            <input type="submit" id="submit" name="submit"  value="Submit">
      </form>
    </main>
    
  </body>
</html>