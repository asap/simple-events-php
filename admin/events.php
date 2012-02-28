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
	<title>Simple Events</title>
	
	<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css">
	<script type="text/javascript" charset="utf-8" src="../js/jquery-1.6.2.min.js"></script>
</head>
<script type="text/javascript" charset="utf-8">
	$(document).ready(function(){
		$('div.alert-message a.close').bind('click', function(){
			$(this).parent().hide();
		});
		
		$('div.topbar ul.nav li.events').addClass('active');
	});
</script>
<style type="text/css" media="screen">
	body {
	        padding-top: 60px;
	      }
</style>
<body>
	<?php 
		$message=NULL;
	
      if(isset($_POST['action']) && ( $_POST['action'] == 'save_new_event' || $_POST['action'] == 'update_event' ) ) {

			$event = new Event(
				$_POST['event-id'],
				convert_to_mysqldate( $_POST['event-date'] ),
				$_POST['event-venue'],
				$_POST['event-address'],
				clean_phone_number( $_POST['event-phone'] ),
				$_POST['event-text'],
				$_POST['event-link']
			);

			if( $_POST['action'] == 'save_new_event' )
				$events_list->create_event( $event );

			if( $_POST['action'] == 'update_event' )
				$events_list->update_event( $event );

			try{
				$message = "Saved Event";
				$alert = 'success';
			} catch (MyException $e){
				$message = "Problem Saving Record: " . $e->getMessage() . "\n";
				$alert = 'error';
			}
		}
		
		if(isset($_GET['action']) && $_GET['action'] == 'delete'){
						
			if($_GET['id']){
				$event = $events_list->get_event( $_GET['id'] );
				
				$events_list->destroy_event( $event );
			
				$message = "Deleted Event";
				$alert = 'success';
			} else {
				$message = "Could not delete event";
				$alert = 'warning';
			}
		}
		
//		update tablename set columnname = "newdata" where columnname = value;
		
		
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
			<?php if($message): ?>
			<div class="alert-message <?php echo $alert; ?>"><a class="close" href="#">×</a><?php echo $message; ?></div>
			<?php endif; ?>
			<table id="events_list" class="bordered-table zebra-striped">
				<thead>
					<tr><th>&nbsp;</th><th>Date</th><th>Venue</th><th>Address</th><th>Phone Number</th><th>Summary</th><th>Link</th></tr>
				</thead>
				<tbody>
				<?php 
				
				$events = $events_list->get_events();
				
				foreach( $events as $event ) { ?>
					<tr data-id="<?php echo $event->id; ?>">
						<td nowrap="true"><a class="edit" href="events-edit.php?action=edit&id=<?php echo $event->id; ?>">Edit</a> | <a class="delete" href="?action=delete&id=<?php echo $event->id; ?>">Delete</a></td>
						<td><?php echo format_date( $event->date ); ?></td>
						<td nowrap="true"><?php echo $event->venue; ?></td>
						<td nowrap="true"><?php echo $event->address; ?></td>
						<td nowrap="true"><?php echo format_phone_number( $event->phone ); ?></td>
						<td class="summary"><?php echo $event->summary; ?></td>
						<td class="url"><?php echo $event->link; ?></td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		  </div>

        </div>
      </div>

      <footer>
        <p>&copy; Simple Events Admin 2011</p>
      </footer>

    </div> <!-- /container -->
</body>
</html>