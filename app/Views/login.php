<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.0.2-dist/css/bootstrap.min.css') ?>">

	<style>
	body{
		max-height: 100vh;
		margin: 100px auto;
		background-color: #2f2e41;
	}


</style>
</head>
<body>

<form action="/authenticate" method="post">


	<div class="container bg-light rounded-3 p-5">
		<div class="row justify-content-center align-items-center">
			<div class="col-lg">
				<img src="images/HarmonyLogo.jpg" alt="Logo" class="img-fluid rounded-3" >
			</div>
			
			<div class="col-lg">
				<div class="mb-3">
					<h3>Admin Login</h3>
				</div>
				<?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
				<div class="mb-3">
					<input type="text" name="username" class="form-control" placeholder="Username" autofocus="true">
				</div>

				<div class="mb-3">
					<input type="password" name="password" class="form-control" placeholder="Password">
				</div>

				<div class="mb-3">
					
					
					<button type="submit" class="btn btn-primary w-100">Login</button>
					
			
				</div>
			</div>
		</div>
	</div>


</form>

<script src="assets/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

	
</body>
</html>









