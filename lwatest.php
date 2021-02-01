   <head>
  
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      
      <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #FFFFFF;
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
		 .ap {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h3{
            text-align: center;
            color: red;
         }
		  h2{
            text-align: center;
            color: #017572;
			postion: relative;
         }
		 p{
            text-align: center;
            color: #017572;
         }
      </style>
      
   </head>
<body>
<div id="amazon-root"></div>
<script type="text/javascript">

    window.onAmazonLoginReady = function() {
        amazon.Login.setClientId('amzn1.application-oa2-client.a11228e4948f4cb28a59941ee5a42fee');
        amazon.Login.setSandboxMode(true);
    };
    (function(d) {
        var a = d.createElement('script'); a.type = 'text/javascript';
        a.async = true; a.id = 'amazon-login-sdk';
        a.src = 'https://assets.loginwithamazon.com/sdk/na/login1.js';
        d.getElementById('amazon-root').appendChild(a);
    })(document);

</script>

   <h2>LWA to CV2 Account Linking Test Site </h2> 
   <p> The User should be able to login via LWA and Yet SSO into Amazon Pay session on Cv2 </p>
   <p> Login with LWA created in Amazon Developer Account : <b>balibani+test@amazon.com</b>  </p>
   <p> Login Linked to Amazon Pay Account : <b>balibani+ap@amazon.com </b> </p>
   <p> LWA Developer ClientID is moved over to Amazon Pay Account  </p>
   <p> This makes this implementation demonstrate SSO with LWA + AP   </p>
   
<div class ="ap">
<div id="AmazonPayButton" >
</div>

<div id="Logout"><a href="">Logout from Amazon</a></div>
<br/>
<a href id="LoginWithAmazon">
    <img border="0" alt="Login with Amazon"
         src="https://images-na.ssl-images-amazon.com/images/G/01/lwa/btnLWA_gold_156x32.png"
         width="156" height="32" />
</a>
</div>

<?php
   ob_start();
   session_start();
?>



    
     
   
      <div class = "container form-signin">
         
         <?php
     /*       $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
				
               if ($_POST['username'] == 'sree' && 
                  $_POST['password'] == '1234') {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['username'] = 'sree';
                  
                  echo 'You have entered valid use name and password';
               }else {
                  $msg = 'Wrong username or password';
               }
            } */
         ?>
      </div> <!-- /container -->
   <!--
      <div class = "container">
      
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "sree" 
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "password = 1234" required> </br>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button> </br>
			  
			   			   		
         </form>
		 </div>
		-->
		

      

<script type="text/javascript">
    document.getElementById('LoginWithAmazon').onclick = function() {
        setTimeout(window.doLogin, 1);
        return false;
    };

    var accesscode = "";
    window.doLogin = function() {
        options = {};
        options.client_id = 'amzn1.application-oa2-client.a11228e4948f4cb28a59941ee5a42fee';
        options.scope = 'profile payments:widget payments:shipping_address';
        options.redirect_uri = '/demo-cv2/sree_onetime.php';
        options.state = '123456';

        amazon.Login.authorize(options,
            "/demo-cv2/sree_onetime.php");
        return false;

    };
    
</script>





</body>