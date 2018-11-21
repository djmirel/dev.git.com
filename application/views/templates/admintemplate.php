<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>public/css/bootstrap.min.css"; ?>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">

    <link rel="stylesheet" href="<?php echo base_url('public/css/mireladmin.css?v=2'); ?>">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
    <script
            src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
            integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ivans.ro/public/js/jquery.ui.touch-punch.min.js"></script>

    <?php foreach($meta as $name=>$content): ?>
        <meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" />
    <?php endforeach; ?>
    <?php foreach($js as $js_file): ?>
        <script type="text/javascript" src="<?php echo $js_file; ?>"></script>
    <?php endforeach; ?>
    <?php foreach ($css as $css_file): ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . $css_file; ?>" />
    <?php endforeach; ?>
    <?php if (isset($fav_icon)) :?>
        <link rel='shortcut icon' type="image/x-icon" href='<?php echo base_url() . $fav_icon; ?>' />
    <?php endif; ?>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-light bg-alb fixed-top">
    <span class="navbar-brand mb-0 h1"><a href="<?php echo base_url('admin'); ?>" class="navbar-brand"><?php echo $site->title; ?></a></span>
    <button class="navbar-toggler toggleSidebar" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<div id="wrapper">
    <div id="sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin'); ?>"><i class="fas fa-chart-pie"></i> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/categorii'); ?>"><i class="fas fa-utensils"></i> Editare produse</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/galerii'); ?>"><i class="fas fa-camera-retro"></i> Galerii poze</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="far fa-question-circle"></i> Instructiuni</a>
            </li>
        </ul>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('admin/logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>

    <div id="content" class="p-3">
        <!-- As a heading -->
        <div id="container">
            <?php echo $output; ?>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.toggleSidebar').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
        $('#container').on('click', function (){
            if ($( "#sidebar" ).hasClass( "active" )){
                $('#sidebar').removeClass('active');
            }
        })
    });
</script>

</body>
</html>