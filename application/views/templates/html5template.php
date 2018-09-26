<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title><?php echo $title; ?></title>
		
	<?php foreach($meta as $name=>$content): ?>
		<meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
	<?php endforeach; ?>
	<?php foreach($js as $js_file): ?>
		<script type="text/javascript" src="<?php echo base_url() . $js_file; ?>"></script>
	<?php endforeach; ?>
	<?php foreach ($css as $css_file): ?>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() . $css_file; ?>" />
	<?php endforeach; ?>
	<?php if (isset($fav_icon)) :?>
		<link rel='shortcut icon' type="image/x-icon" href='<?php echo base_url() . $fav_icon; ?>' />
	<?php endif; ?>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

</head>
<body>

	<div id="main">
    <?php echo $output; ?>
    </div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>