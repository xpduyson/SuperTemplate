<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">	
	<base href="<?php echo $base_url; ?>" />

	<title><?php echo $page_title; ?></title>

	<?php
		foreach ($meta_data as $name => $content)
		{
			echo "<meta name='$name' content='$content'>".PHP_EOL;
		}

		foreach ($stylesheets as $media => $files)
		{
			foreach ($files as $file)
			{
				$url = starts_with($file, 'http') ? $file : base_url($file);
				echo "<link href='$url' rel='stylesheet' media='$media'>".PHP_EOL;	
			}
		}
		
		foreach ($scripts['head'] as $file)
		{
			$url = starts_with($file, 'http') ? $file : base_url($file);
			echo "<script src='$url'></script>".PHP_EOL;
		}
	?>
	
</head>
<body class="<?php echo $body_class; ?>">