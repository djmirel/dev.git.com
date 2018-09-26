<div class="container text-center">
<div class="col-md-4 ml-auto mr-auto mt-5">
    <h1 class="h3 mb-3 font-weight-normal"><?php echo $site->title; ?> - Login</h1>

    <?php if ($this->session->flashdata('nelogat')): ?>
    <p class=" card-text alert alert-danger">
      Combinatie user / parola gresite!
    </p>
    <?php endif; ?>

  <?php echo form_open('admin/dologin'); ?>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="text" id="username" name="username" placeholder="User" class="form-control mb-2" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="password" name="password" placeholder="Parola" class="form-control mb-2" required>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
  <?php echo form_close(); ?>
    <p class="mt-5 text-muted"><?php echo $site->footer; ?> &copy; <?php echo date("Y"); ?></p>
    <p class="text-muted"><a href="<?php echo base_url(); ?>">Inapoi la site</a></p>
    
  </div>
</div>