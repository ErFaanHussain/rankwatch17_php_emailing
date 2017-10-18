<!DOCTYPE html>
<html lang="en">
<head>
	<title>Email Service</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootsrap CSS, jQuery, Tether, Bootsrap JS CDNs -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<body>
  <!-- Using full width container for NavBar -->
<div class="container-fluid px-0">
  <nav class="navbar navbar-inverse bg-primary">
    <div class="navbar-brand mx-auto">Email Service</div>
  </nav>
</div>
<div class="container">
	<div class="col-md-6 mx-auto mt-5" >
    <ul class="nav nav-tabs">
			<li class="nav-item">
				<span class="nav-link active"><h6>Send Email</h6></span>
			</li>
		</ul>
    <div class="tab-content">
      <div class="tab-pane fade show active">
        <!-- Form to take input parameters from the user -->
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
          <div class="form-group">
            <label class="col-form-label" for="name">Enter Recepient Name</label>
            <input type="text" class="form-control" name="r_Name" value="">
          </div>
          <div class="form-group">
            <label class="col-form-label" for="email">Enter Email</label>
            <input type="email" class="form-control" name="email" value="">
          </div>
          <div class="form-group">
            <label class="col-form-label" for="subject">Enter Subject</label>
            <input type="text" class="form-control" name="subject" value="">
          </div>
          <div class="form-group">
            <label class="col-form-label" for="message">Enter the Message</label>
            <textarea class="form-control" rows="3" name="message" value=""></textarea>
          </div>
          <!--  -->
          <div id="Alert" role="alert"></div>
          <div class="form-group">
          <div class="text-center">
            <button type="submit" class="btn btn-primary" name="send">Send</button>
            <button type="reset" class="btn btn-danger ml-md-5">Cancel</button>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  </div>
</body>
</html>
<?php
if(isset($_POST["send"])){
  if(isset($_POST["subject"]) && isset($_POST["message"]) && isset($_POST["email"]) && isset($_POST["r_Name"])){
    $recipient_name = $_POST["r_Name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $mes = $_POST["message"];
    if (empty($email) || empty($subject) || empty($mes) || empty($recipient_name))
    { ?>
      <script>
        jQuery("#Alert").addClass("alert alert-danger alert-dismissible fade show").html('<button type="button" class="close" data-dismiss="alert"><span> &times; </span> </button>Please enter the details');
      </script>
    <?php }
    else{
      //Used Composer to resolve Mandrill library dependency, Mandrill library provides Mandrill/MailChimp API
      require_once 'vendor/autoload.php';
      $from_email = "me@erfaanhussain.co";
      $from_name = "ErFaan Hussain";
      try {
          $mandrill = new Mandrill('CazWu1bgRBeJthD4WQ8XLw');
          $message = array(
              'html' => '<p>' .$mes . '</p>',
              'text' => $mes,
              'subject' => $subject,
              'from_email' => $from_email,
              'from_name' => $from_name,
              'to' => array(
                  array(
                      'email' => $email,
                      'name' => $recipient_name,
                      'type' => 'to'
                  )
              ),
              'headers' => array('Reply-To' => $from_email)
          );
          //if set to true email will be sent asyncronously in background , it is moved to queue and result is immediatey returned
          $async = false;
          $ip_pool = 'Main Pool';
          //$send_at, when to send the email, mandrill also provides facility to schedule email for a future date
          $send_at = date("Y-m-d h:i:s");
          $test = new DateTime('08/18/2016');
          $send_at = date_format($test, 'Y-m-d h:i:s');
          //message is sent using object of Mandrill Class (provided by Mandrill API)
          $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
          //Mandrill returns an associative array containing results of the transaction.
          if($result[0]["status"] == 'sent'){
            ?>
              <script>
                jQuery("#Alert").removeClass('alert-danger').addClass("alert alert-success alert-dismissible fade show").html('<button type="button" class="close" data-dismiss="alert"><span> &times; </span> </button> Your email is sent.');
              </script>
            <?php
          }
          elseif(isset($result[0]["reject_reason"])){
            ?>
              <script>
                jQuery("#Alert").removeClass('alert-success').addClass("alert alert-danger alert-dismissible fade show").html('<button type="button" class="close" data-dismiss="alert"><span> &times; </span> </button> Email rejected, contact administrator with following code <?php echo $result[0]["reject_reason"]; ?>');
              </script>
            <?php
          }
      } catch(Mandrill_Error $e) {
          // Mandrill errors are thrown as exceptions
          ?>
            <script>
              jQuery("#Alert").addClass("alert alert-danger alert-dismissible fade show").html('<button type="button" class="close" data-dismiss="alert"><span> &times; </span> </button><?php echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();?>');
            </script>
          <?php
          // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
          throw $e;
      }
    }
  }
}
?>
