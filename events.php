<?php
session_start();
require_once dirname(__FILE__) . '/admin/includes/fns.php';
require_once dirname(__FILE__) . '/admin/classes/Membership.php';
require_once dirname(__FILE__) . '/admin/classes/Event.php';

$events_list = new EventList;

$events = $events_list->get_events( today(), nextMonth() );
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Simple Events Manager</title>
<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script type="text/JavaScript">
<!--
  $(document).ready(function(){
    $('span.tel').wrapInner('<a href="" class="value">');

    $.each( $('span.tel a'), function(){
      $(this).attr('href', 'tel:+1' + $(this).text().replace(/[^0-9]/g, '') );
    });

  });
</script>
</head>
<body>
<h1>Upcoming Events</h2>
<div id="events_list">
  <ul><?php foreach($events as $event){ ?>
    <li class="vevent">
      <span class="dtstart"><?php echo strtoupper( date( "l F d, Y, g:i a" , strtotime( $event->date ) ) ); ?></span>
      <span class="location">
        <span class="fn org"><?php
          if( $event->link ) : 
            ?><a href="<?php echo $event->link; ?>" rel="external"><?php echo $event->venue; ?></a><?php 
          else : echo $event->venue;
          endif; 
        ?></span>
        <span class="adr"><?php echo $event->address; ?></span>
        <span class="tel"><?php echo format_phone_number( $event->phone ); ?></span>
      </span>
      <span class="summary"><?php echo $event->summary; ?></span>
    </li><?php } ?>
  </ul>
</div>

</body>
</html>
