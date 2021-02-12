<body>
<aside id="menu_aside">
	<link rel="stylesheet" type="text/css" href="../css/style.css">

	<h2> Меню </h2>
	<hr />
	<?php
		//echo "228";
		//echo $_SESSION['access'];
		//print_r($_SESSION);
		$menu_top = R::find('aside_top', "`access` <= ?", array(isset($_SESSION['access']) ? $_SESSION['access'] : 0));
		foreach ($menu_top as $i) {
			?>
			<p> <a href="<?php echo $i['link']; ?>" class="<?php echo $i['class']; ?>" > <?php echo $i['name']; ?> </a> </p>
			<?php
		}	
		?>

		<?
			if($_SESSION['access'] < 3){
				echo '<br /><br />';
			}
		?>

		<?php
		$menu_down = R::find('aside_down', "`access` <= ?", array(isset($_SESSION['access']) ? $_SESSION['access'] : 0));
		foreach ($menu_down as $i) {
			if($_SESSION['access'] >= 3){
				if($i['id'] == 5)echo '<a href="edit_about" class="menu2"> ред. </a>';
				if($i['id'] == 4)echo '<a href="edit_help" class="menu2"> ред. </a>';
				if($i['id'] == 3)echo '<a href="edit_rules" class="menu2"> ред. </a>';
			}
			?>
			<a href="<?php echo $i['link']; ?>" class="<?php echo $i['class']; ?>" > <?php echo $i['name']; ?> </a><br /><br />
			<?php
		}
	?>
</aside>