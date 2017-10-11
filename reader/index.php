<?php
	include '../config.php';
	require '../assets/lib/picofeed/PicoFeed.php';
	use PicoFeed\Reader;
	
  if (isset($_GET['url']))
  {
	  $url = urldecode($_GET['url']);
    $number = $_GET['number'];
    $number = $number - 1;
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Get URL for a show</title>
	<meta name="robots" content="noindex,follow"> 
	<meta name="description" content=""> 
	<meta name="keywords" content=""> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
	<link rel="stylesheet" href="../assets/css/bootstrap.css"> 
	<link rel="stylesheet" href="../assets/css/font-awesome.css"> 
</head>
<body style="padding:10px;">
<div class="container col-md-4 col-md-offset-4">
	<div class="row">
		<div class="text-center">
			<h3>
				Here is the episode information:
			</h3>
		</div>
	</div>
	<div class="row">
		<form action="../post.php" method="get" role="form">
			<div class="form-group">
				<label for="title">Feed URL</label> 
				<div class="form-group col-xs-12">
					<input name="url" type="text" value="<?php echo $url ?>" class="form-control input-lg" readonly />
				</div>
			</div>
		</form>
	</div>
	<div class="row">
	  <div class="btn-group btn-group-justified btn-group-sm">
    <a class="btn btn-default btn-lg" href="<?php echo $address ?>/reader/"><span class="glyphicon glyphicon-refresh"></span> Another?</a>
    <a class="btn btn-default btn-lg" href="<?php echo $address ?>/post/"><span class="glyphicon glyphicon-edit"></span> Post</a>
  </div>
	</div>
	<hr />
	<?php
		$reader = new Reader;
    $reader->download($url);
    $parser = $reader->getParser();
    if ($parser !== false) {
      $feed = $parser->execute();
      if ($feed !== false) {
          for($i=0; $i<=$number; $i++) {
            $j = $i + 1;
            echo '<div class="form-group">';
              echo '<label for="feeditem-'. $i . '-title">Episode '. $j .'</label>';
              echo '<input name="feeditem-'. $i .'-title type="text"  class="form-control input-lg" value="'. $feed->items[$i]->getTitle() . '"/>';
            echo '</div>';
              echo '';
            echo '<div class="form-group">';
              echo '<label for="feeditem-'. $i . '-url">Episode URL</label>';
              echo '<div class="input-group"><span class="input-group-addon glyphicon glyphicon-link"></span><input name="feeditem-'.$i.'-url" type="text"  class="form-control input-lg"  value="'. $feed->items[$i]->getUrl() . '"/></div>';
            echo '</div>';
            echo '<div class="form-group">';
              echo '<label for="feeditem-'. $i . '-enclosure">File URL</label>';
              echo '<div class="input-group"><span class="input-group-addon glyphicon glyphicon-download"></span><input name="feeditem-'.$i.'-enclosure" type="text"  class="form-control input-lg"  value="'. $feed->items[$i]->getEnclosureUrl() . '"/></div>';
            echo '</div>';
            echo '<div class="btn-group btn-group-justified btn-group-sm"><a class="btn btn-default btn-success" href="' . $address . 'post/index.php?add&title='. urlencode($feed->items[$i]->getTitle()) . '&url='. urlencode($feed->items[$i]->getUrl()) . '&description=%20&enclosure=' . urlencode($feed->items[$i]->getEnclosureUrl()) . '"><span class="glyphicon glyphicon-ok"></span> Post this episode </a>';
            echo '<a class="btn btn-info" href="'. $feed->items[$i]->getUrl() . '" target="_blank"><span class="glyphicon glyphicon-share-alt"></span> Visit Site</a></div>';
            echo '<hr />';
          }
      }
    }
	?>	
<div class="row text-center">
  <div class="btn-group btn-group-justified btn-group-sm">
    <a class="btn btn-default btn-lg" href="<?php echo $address ?>reader/"><span class="glyphicon glyphicon-refresh"></span> Another?</a>
    <a class="btn btn-default btn-lg" href="<?php echo $address ?>post/"><span class="glyphicon glyphicon-edit"></span> Post</a>
    <a class="btn btn-default btn-lg" href="<?php echo $address ?>"><span class="glyphicon glyphicon-home"></span> Home</a>
  </div>
</div>	

</div>
<br /><br />

<br /><br />
</body>
</html>

<?php
 exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Get Feed Information</title>
	<meta name="robots" content="noindex,follow"> 
	<meta name="description" content=""> 
	<meta name="keywords" content=""> 
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
	<link rel="stylesheet" href="../assets/css/bootstrap.css"> 
	<link rel="stylesheet" href="../assets/css/font-awesome.css"> 
</head>
<body style="padding:10px;">
  <div class="container col-md-4 col-md-offset-4">
	<div class="row">
		<div class="text-center">
			<h3>
				Get Episode Information. 
			</h3>
		</div>
	</div>
	<div class="row">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" role="form">
			<div class="form-group">
				<label for="title">Podcast Feed URL</label> 
				<div class="form-group col-xs-12">
					<input name="url" type="text" value="" class="form-control input-lg" />
				</div>
			</div>
			<div class="form-group">
			  <label for="number">Number of Episodes</label>
			  <select class="form-control" name="number">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>4</option>
          <option>5</option>
        </select>
			</div>
			<div class="form-group text-center">
				<div class="btn-group ">
 				<button class="btn btn-primary" type="submit" name="mysubmit" value="Submit"><i class="glyphicon glyphicon-search"></i> Search Feed</button> 
				<a class="btn btn-default" href="<?php echo $address?>/post/"><i class="glyphicon glyphicon-edit"></i> Manually Post</a>
				</div>
			</div>
		</form>
	</div>
</div>
</body>
</html>
