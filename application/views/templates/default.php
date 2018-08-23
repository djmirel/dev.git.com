<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <html lang="RO">
<?php foreach($meta as $name=>$content): ?>
	<meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
<?php endforeach; ?>
<?php if(count($rdf) > 0): ?>
<!--
	<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:ddc="http://purl.org/net/ddc#">
		<rdf:Description rdf:about="<?php echo base_url(); ?>">
<?php foreach($rdf as $name=>$content): ?>
			<<?php echo $name; ?>><?php echo $content; ?></<?php echo $name; ?>>
<?php endforeach;?>
		</rdf:Description>
	</rdf:RDF>
-->
<?php endif;?>
<?php foreach($js as $js_file): ?>
	<script type="text/javascript" src="<?php echo base_url() . $js_file; ?>"></script>
<?php endforeach; ?>
<?php foreach ($css as $css_file): ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() . $css_file; ?>" />
<?php endforeach; ?>
<?php if (isset($fav_icon)) :?>
	<link rel='shortcut icon' type="image/x-icon" href='<?php echo base_url() . $fav_icon; ?>' />
<?php endif; ?>

<?php echo $inline_scripting ?>

</head>
<body>
<div>
    <div id="main">
    <?php echo $output; ?>
    </div>
</div>
<div id="bottom"><?php
//If we had to display some extra modules (views). This will display all the modules that have
//loaded at the "bottom" position. But first we should propably register the postion inside
//the MY_Controller construct (or whatever) using the $this->_register_module_potion() method.
//eg: $this->_load_module("bottom", "modules/my_module_view", $data);

    foreach ($modules->bottom as $mod ){
        echo $mod;
    }
?>
</div>
</body>
</html> 
