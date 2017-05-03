<!DOCTYPE html>
<html lang="<?= Data::_('lang_ident') ?>">
<head>
    <title><?= $page_title ?> - <?= $title ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?= $meta_description ?>" />
    <meta name="keywords" content="<?= $meta_keywords ?>" />
	
	<link rel="shortcut icon" href="/favicon.ico?v=4" />
	<!--<link rel="apple-touch-icon-precomposed" href="/images/icon.png" />-->
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    
	<?php foreach ($styles as $style): ?>
		<link href="<?= URL::base() ?><?= $style ?>.css?v=11" rel="stylesheet" type="text/css" />
	<?php endforeach; ?>
	
    <!-- Use google font -->
    <link href="http://fonts.googleapis.com/css?family=Lato:100,300,400,700,300italic,400italic,700italic|Lustria" rel="stylesheet" type="text/css" />
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	
	<?php if($scripts_header AND !empty($scripts_header)): ?>
		<?php foreach ($scripts_header as $script): ?>
			<script type="text/javascript" src="<?= URL::base() ?><?= $script ?>.js?v=10"></script>
		<?php endforeach; ?>
	<?php endif; ?>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="<?= $page_class ?>"> <!-- class = background-clouds -->
	<!--[if lt IE 9]><p class="chromeframe"><?= $text_old_browser_warning ?></p><![endif]-->
	<?= $site_counter ?>
	
	<div id="nav-wrapper" class="background-white color-black">
	
		<nav id="mainMenu" class="navbar navbar-fixed-top" role="navigation">
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-3">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
								<span class="sr-only">Меню</span>
								<span class="icon-bar background-lead"></span>
								<span class="icon-bar background-lead"></span>
								<span class="icon-bar background-lead"></span>
								<span class="icon-bar background-lead"></span>
							</button>
							<?= $logo ?>
						</div>
						<div class="col-sm-6 col-md-3">
							<div class="address"><?= $address ?></div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3">
							<div class="tel"><a href="tel:<?= preg_replace('~[^+0-9]+~','', $tell) ?>"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> <?= $tell ?></a></div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-3">
							<a href="#recall" class="recall-button fancybox"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> Задать&nbsp;вопрос</a>
						</div>
					</div>
				</div>
			</div>
			<div class="background-belize-hole color-black">
				<div class="menu-block container">
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav navbar-right">
						
							<?= $menu ?>
							
							<!--<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-search"></span></a>
								<ul class="dropdown-menu">
									<li>
										<?//= Search::get_search_block() ?>
									</li>
								</ul>
							</li>-->
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
			</div>
		</nav>
		
		<?php if(Request::current()->controller() == 'front'):?>
			<?= Banners::get() ?>
		<?php endif;?>
    </div>
	
	<?php //if(Request::current()->controller() == 'front'):?>
		<!--<section class="background-white color-black main-banner">
			<div class="container">
				<?//= Services::services_block() ?>
			</div>
		</section>-->
	<?php //endif;?>

	<?= $content ?>

	<footer class="background-midnight-blue color-white">
		<div class="container">
			<div class="row">
				<!--<div class="col-md-3">
					<?//= $footer_menu ?>
				</div>-->
				<div class="col-md-7">
					<?= Infoblock::get_page_block('footer_info1') ?>
					<div class="map">
						<?= $site_map ?>
					</div>
				</div>
				<div class="col-md-5">
					<h4>Обратная связь</h4>
					<form method="post" role="form" id="feedback_form">
						<div class="form-group">
							<input type="text" name="name" class="form-control" placeholder="Ваше имя">
						</div>
						<div class="form-group">
							<input type="text" name="phone" class="form-control phone" placeholder="Номер Вашего телефона для связи">
						</div>
						<div class="form-group">
							<input type="email" name="email" class="form-control" placeholder="Ваш Email">
						</div>
						<div class="form-group">
							<label for="text" class="control-label">Текст сообщения</label>
							<textarea name="text" class="form-control" rows="5" placeholder="Текст вашего сообщения .."></textarea>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-lead btn-lg"><img src="/images/admin/loader.gif" class="loading" style="border-radius:20px;display:none;"> Отправить</button>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<hr>
					<div class="row">
						<div class="col-md-8">
							<?= $copyright ?> <?= date('Y')?> г.<?//= $prodigy ?>
						</div>
						<div class="col-md-4">
							<?= $social_menu ?>
						</div>
					</div>
				</div>
			</div>
		</div>
    </footer>
    
    <?php if($scripts_footer AND !empty($scripts_footer)): ?>
		<?php foreach ($scripts_footer as $script): ?>
			<script type="text/javascript" src="<?= URL::base() ?><?= $script ?>.js?v=10"></script>
		<?php endforeach; ?>
	<?php endif; ?>
    
    <script type="text/javascript">
    $(document).ready(function() {
		$('#mixit').mixitup();
    });

    $(window).load(function(){
      if ($(window).width() > 767) {
        matchHeight($('.info-thumbnail .caption .description'), 3);
      }

      $(window).on('resize', function(){
        if ($(window).width() > 767) {
          $('.info-thumbnail .caption .description').height('auto');
          matchHeight($('.info-thumbnail .caption .description'), 3);
        }
      });
    });
    </script>
</body>
<?//= $login_block ?>
<?//= preg_replace('~[^+0-9]+~','', $tell) ?><?//= $tell ?>
<?= $recall_block ?>
<?= $order_block ?>
</html>
<?//= $bottom_script // Код LiteEdit ?>