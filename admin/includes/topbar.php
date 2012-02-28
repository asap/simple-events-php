<div class="fill">
    <div class="container">
      <a class="brand" href="index.php">Simple Events Admin</a>
      <ul class="nav">
				<li class="home"><a href="index.php">Home</a></li>
        <li class="events"><a href="events.php">Events</a></li>
      </ul>
<?php if( !$membership->is_logged_in() ) { ?>
      <form action="" method="post" class="pull-right">
     		<input class="input-small" type="username" placeholder="Username" name="username">
       	<input class="input-small" type="password" placeholder="Password" name="password">
       	<button class="btn" type="submit">Sign in</button>
      </form>
<?php } ?>
			<?php if( $membership->is_logged_in() ) { ?><ul class="nav secondary-nav"><li><a href="index.php?status=loggedout">Log out</a></ul><?php } ?>
    </div>
  </div>