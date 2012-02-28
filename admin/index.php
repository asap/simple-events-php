<?php
session_start();
require_once dirname(__FILE__) . '/includes/fns.php';
require_once dirname(__FILE__) . '/classes/Membership.php';
require_once dirname(__FILE__) . '/classes/Event.php';

$membership = New Membership();

// $membership->confirm_Member();

// If the user clicks the "Log Out" link on the index page.
if(isset($_GET['status']) && $_GET['status'] == 'loggedout') {
  $membership->log_User_Out();
}

// Did the user enter a password/username and click submit?
if($_POST && !empty($_POST['username']) && !empty($_POST['password'])) {
  $response = $membership->validate_User($_POST['username'], $_POST['password']);
}
                            

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Simple Events Admin</title>
  
  <link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css">
  <style>
    ul.upcoming-events li span.date{ display: block; }
  </style>
  <script type="text/javascript" charset="utf-8" src="../includes/jquery-1.4.2.min.js"></script>

  <script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
      $('div.alert-message a.close').live('click', function(){
        $(this).parent().hide();
      });
      $('div.topbar ul.nav li.home').addClass('active');
      
    });
  </script>
</head>
<body>
  
<div class="topbar">
<?php include('includes/topbar.php'); ?>
</div>

    <div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Page name <small>Supporting text or tagline</small></h1>
        </div>

        <?php if(isset($response)) { ?>

        <div class='alert-message warning'>
          <a class="close" href="#">×</a>
          <p><?php echo $response; ?></p>
        </div>
        <?php } ?>
        
        <div class="row">

        <?php if( !$membership->is_logged_in() ) { ?>
  
          <div class="span16">
            <h2>Please log in</h2>
          </div>

        <?php } else { ?>
        
          <div class="span10">
            <h2>Main Info Panel</h2>
            <p>You can put some really usefull information in here, but I've not gotten around to it yet</p>
          </div>
          <div class="span6">
            <h3>Upcoming Events - <?php echo today("m/d"); ?> to <?php echo nextMonth("m/d"); ?></h3>
            <?php
              $event_list = new EventList();
              
              $events = $event_list->get_events( today(), nextMonth() );

            ?>
            <ul class="upcoming-events">
            <?php
             if( sizeof( $events ) <= 0 ) {
              ?><li>There are no upcoming events!</li><?php
             } else {
              foreach( $events as $event ){ ?>
              <li><span class="date"><?php echo format_date($event->date, "l F d g:i a"); ?></span> - <span class="venue"><?php echo $event->venue; ?></span></li>
              <?php } ?>
            <?php } ?>
            </ul>
              <div id="controls"><a href="events.php">View Events List</a></div>
          </div>

        <?php } ?>


        </div>
      </div>

      <footer>
        <p>&copy; Simple Events Manager 2011</p>
      </footer>

    </div> <!-- /container -->
</body>
</html>