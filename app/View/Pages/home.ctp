<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Full - Start Bootstrap Template</title>
	
    <!-- Bootstrap core CSS
    <link href="<?php //echo SITE_URL; ?>/bootstrap/bootstrap.min.css" rel="stylesheet">-->	
	<?php echo $this->Html->css('bootstrap/bootstrap.min');?>
    <!-- Custom styles for this template -->
    <?php echo $this->Html->css('custom');?>
  </head>

  <body>
 <!-- Page Content -->
    <div class="container">	
	  <?php 
	  if(empty($instagram_feed_data))
	  {	
	  ?>	
		
		<!--<h1 class="mt-5"><a href="https://api.instagram.com/oauth/authorize/?client_id=	116e1d46b05844579e4dcdc2323e7757&redirect_uri=http://localhost/instagram_app&response_type=code&scope=public_content" class="btn btn-success">Login With Instagram</a></h1>-->
		<div class="LogMidBlock">			
			<div class="LogMidBlockIn">
				<div class="LogMidLeft">
					<?php echo $this->Form->create('Contact', array('url' => array('controller' => 'pages', 'action' => 'home'))); ?>
					<div class="LogMidLeftFrm">
						<div>
							<?php echo $this->Form->input("Contact.username", array("div" => false, "label" => 'Instagram User Name:<span>*</span>',"class"=>"textboxc",'required')); ?>
						</div>
						<div>
							<?php echo $this->Form->submit("Submit", array('type' => 'submit', 'div' => false, 'class' => 'btn')); ?>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				 </div>
				<div class="Clear"></div>
			</div>
			<div class="Clear"></div>
		</div>
		
	  <?php }else{ ?>
		 <div>
			<?php 
				if(isset($instagram_feed_data))
				{	
					foreach($instagram_feed_data as $item)
					{
						$link = $item['link'];
						$img_url = $item['image'];// image URLs in multiple formats: thumbnail, low_resolution, and standard_resolution
						$caption = isset($item['text']) ? $item['text'] : '';
			?>				
				<div class="gallery">
				  <a target="_blank" href="<?php echo $link; ?>">
					<img src="<?php echo $img_url; ?>" alt="instagram-post">
				  </a>
				  <div class="desc"><?php echo $caption; ?></div>
				</div>
			<?php			
					}
				}		
			?>
		 </div>
	<?php } ?>
    </div>
    <!-- /.container -->
    <!-- Bootstrap core JavaScript -->
	<?php echo $this->Html->script(array('jquery/jquery.min'));?>
	<?php echo $this->Html->script(array('bootstrap_js/bootstrap.bundle.min'));?>
  </body>
</html>
