<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php bloginfo('name');?></title>
    <!-- Le styles -->
    <link href="<?php bloginfo('stylesheet_url');?>" rel="stylesheet">
	  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php wp_head(); ?>
  </head>
  <body id="contenu-site">
    <!--  -->
    <nav id="navbar-parenthese" class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          </button>
          <a id="logo" class="navbar-brand" href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <div class="menu-navigation navbar-right">
            <?php /* Primary navigation */
            wp_nav_menu( array(
            'top_menu',
            'depth' => 2,
            'container' => false,
            'menu_class' => 'nav navbar-nav',
            //Process nav menu using our custom nav walker
            'walker' => new wp_bootstrap_navwalker())
            );
            ?>
              <form id="custom-search-input" class="navbar-form navbar-right" role="search" method="post" action="<?php bloginfo('url'); ?>/programmation">
                <div class="input-group add-on">
                  <input type="text" class="form-control" placeholder="" name="srch-term" id="srch-term">
                  <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                  </div>
                </div>
              </form>
              <p class="telephone-header">Téléphone: 418 123 4567</p>
            </div>
          </div><!--/.nav-collapse -->
        </div>
      </nav>