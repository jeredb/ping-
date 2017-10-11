<?php

  require '../functions.php';
  if (isset($_GET['add']))
  {
    $url = urldecode($_GET['url']);
    $title = urldecode($_GET['title']);
    $description = urldecode($_GET['description']);
    $enclosure = '';
    if (isset($_GET['enclosure']))
    {
      $enclosure = urldecode($_GET['description']);
    } else {
      $enclosure = '';
    }
    
    include ('../assets/templates/_header.php');
?>

		<div class="text-center">
			<h3>
				Add this one to Ping! feed. 
			</h3>
		</div>
	</div>
	<div class="row">
		<form action="../index.php?post" method="get" role="form">
			<div class="form-group">
				<label for="title">Podcast Title</label> 
				<div class="form-group col-xs-12">
					<input name="title" type="text" value="<?php echo $title ?>" class="form-control input-lg" />
				</div>
			</div>
			<div class="form-group">
				<label for="url">Show Notes URL</label> 
				<div class="form-group col-xs-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span> 
						<input name="shownotes" type="text" value="" class="form-control  input-lg" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="url">Podcast URL</label> 
				<div class="form-group col-xs-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span> 
						<input name="url" type="text" value="<?php echo $url ?>" class="form-control  input-lg" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="enclosure">Download URL</label> 
				<div class="form-group col-xs-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span> 
						<input name="enclosure" type="text" class="form-control input-lg" value=""/>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="description">Description</label> 
				<div class="form-group col-xs-12">
					<textarea name="description" value="" class="form-control input-lg" row="5">
<?php echo $description ?>
					</textarea>
				</div>
			</div>	
			<div class="form-group text-center">
			<div class="btn-group">
				<button class="btn btn-primary" type="submit" name="mysubmit" value="Submit"><i class="glyphicon glyphicon-plus-sign"></i> Submit</button> 
	  			<a class="btn btn-default" href="<?php echo $address ?>reader/index.php"><span class="glyphicon glyphicon-search"></span> Search</a> 
				<a class="btn btn-info" href="<?php echo $url; ?>" target="_blank"><span class="glyphicon glyphicon-share-alt"></span> Visit Site</a>
			</div>
			</div>	
		</form>
	</div>

<?php
      include ('../assets/templates/_footer.php');


 exit;
}

    include ('../assets/templates/_header.php');

?>

		<div class="text-center">
			<h3>
				Add this one to Ping! feed. 
			</h3>
		</div>
	</div>
	<div class="row">
		<form action="../index.php?post" method="get" role="form">
			<div class="form-group">
				<label for="title">Podcast Title</label> 
				<div class="form-group col-xs-12">
					<input name="title" type="text" value="" class="form-control input-lg" />
				</div>
			</div>
			<div class="form-group">
				<label for="url">Show Notes URL</label> 
				<div class="form-group col-xs-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span> 
						<input name="shownotes" type="text" value="" class="form-control  input-lg" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="url">Podcast URL</label> 
				<div class="form-group col-xs-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span> 
						<input name="url" type="text" value="" class="form-control  input-lg" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="enclosure">Download URL</label> 
				<div class="form-group col-xs-12">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-link"></i></span> 
						<input name="enclosure" type="text" class="form-control input-lg" placeholder="download URL" />
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="description">Description</label> 
				<div class="form-group col-xs-12">
					<textarea name="description" value="" class="form-control input-lg" row="5"></textarea>
				</div>
			</div>
			<div class="form-group text-center">
			<div class="btn-group">
				<button class="btn btn-primary" type="submit" name="mysubmit" value="Submit"><i class="glyphicon glyphicon-plus-sign"></i> Submit</button> 
	  			<a class="btn btn-default" href="<?php echo $address ?>/reader/index.php"><span class="glyphicon glyphicon-search"></span> Search</a> 
				<a class="btn btn-info" href="<?php echo $url; ?>" target="_blank"><span class="glyphicon glyphicon-share-alt"></span> Visit Site</a>
			</div>
			</div>
		</form>
	</div>
<?php
  include ('../assets/templates/_footer.php');
?>