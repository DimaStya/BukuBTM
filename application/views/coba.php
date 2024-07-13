<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
	<main class="main">

		<div class="content">
			<h1>Upload Avatar</h1>

			<form action="<?php echo base_url('login/proses'); ?>" method="POST" enctype="multipart/form-data">
				<div>
					<label for="avatar">Pilih Gambar Avatar</label>
					<input type="file" name="avatar" id="avatar" accept="image/png, image/jpeg, image/jpg, image/gif">
				</div>

				<div>
					<button type="submit" name="save" class="button button-primary">Upload</button>
				</div>
			</form>

		</div>
	</main>
</body>

</html>