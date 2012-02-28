<?php 
session_start();
require_once dirname(__FILE__) . '/includes/fns.php';
require_once dirname(__FILE__) . '/classes/Membership.php';
require_once dirname(__FILE__) . '/classes/Event.php';

$membership = New Membership();

// $membership->confirm_Member();

$events_list = new EventList;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Simple Events Admin</title>
	
	<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css">
	<link type="text/css" href="css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
	<script type="text/javascript" src="../js/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
	
	
</head>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('div.topbar ul.nav li.events').addClass('active');
	});
</script>
<style type="text/css" media="screen">
	body {
	        padding-top: 60px;
	      }
				.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
				.ui-timepicker-div dl { text-align: left; }
				.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
				.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
				.ui-timepicker-div td { font-size: 90%; }
				.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }
</style>
	<script type="text/javascript">
		$(function(){

			// Datepicker
			$('#event-date').datetimepicker({
				inline: true,
				showButtonPanel: true,
				ampm: true,
				stepHour: 1,
				stepMinute: 10,
				hourGrid: 4,
				minuteGrid: 15,
				hour: 12,
				minute: 30
			});			
		});
	</script>

<body>
	<?php 
		if(isset($_GET['action']) && $_GET['action'] == 'edit') {

			if($_GET['id']){

				try{
					$event = $events_list->get_event( $_GET['id'] );
				} catch (MyException $e){
					$message = "Problem Fetching Record: " . $e->getMessage() . "\n";
					$alert = 'error';
				}
			} 
		}
	?>
    <div class="topbar">
	  <?php include('includes/topbar.php'); ?>
    </div>

    <div class="container-fluid">
	  <div class="sidebar">
	  	<div class="sidebar">
			<?php include('sidebar.php'); ?>
	  </div>
      <div class="content">
        <div class="page-header">
          <h1>Events <small>Latest events and readings</small></h1>
        </div>
        <div class="hero-content">
		  <div class="hero-unit">
			<?php if($_GET['action'] == 'edit'): ?><h2>Edit Events</h2>
			<?php else: ?><h2>Add Events</h2>
			<?php endif; ?>
			<form action="events.php" method="post" accept-charset="utf-8">
			<fieldset>
				<div class="cleafix">
					<label for="event-date">Event Date</label>
					<div class="input"><input type="text" name="event-date" value="<?php echo $event->date; ?>" id="event-date" class="span5" /></div>
				</div>

				<div class="cleafix">
					<label for="event-venue">Event Venue</label>
					<div class="input"><input type="text" name="event-venue" value="<?php echo $event->venue; ?>" id="event-venue" class="span5" /></div>
				</div>

				<div class="cleafix">
					<label for="event-address">Event Address</label>
					<div class="input"><input type="text" name="event-address" value="<?php echo $event->address; ?>" id="event-address" class="span5" /></div>
				</div>

				<div class="cleafix">
					<label for="event-phone">Event Phone</label>
					<div class="input"><input type="text" name="event-phone" value="<?php echo format_phone_number( $event->phone ); ?>" id="event-phone" class="span5" /></div>
				</div>

				<div class="cleafix">
					<label for="event-url">Event Link</label>
					<div class="input"><input type="text" name="event-link" value="<?php echo $event->link; ?>" id="event-link" class="span5" /></div>
				</div>

				<div class="cleafix">
					<label for="event-summary">Event Summary</label>
					<div class="input">
						<textarea name="event-text" value="" id="event-text" class="span5"><?php echo $event->summary; ?></textarea>
					</div>
				</div>
			</fieldset>
			
			<?php if(isset($_GET['action']) && $_GET['action'] == 'edit') { 
				$event_id = $_GET['id']; ?>
				<input type="hidden" id="event-id" name="event-id" value="<?php echo $event_id; ?>" />
				<input type="hidden" id="action" name="action" value="update_event" />
			<?php } else { ?>
				<input type="hidden" id="action" name="action" value="save_new_event" />
			<?php } ?>

			<div class="actions">
				<input type="submit" id="submit" name="submit" value="Save" class="btn primary" />
				<input type="reset" id="reset" name="reset" value="Reset" class="btn" />
			</div>
			</form>
		  </div>

        </div>
      </div>

      <footer>
        <p>&copy; Simple Events Admin 2011</p>
      </footer>

    </div> <!-- /container -->
</body>
</html>