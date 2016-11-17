<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<title><?php
	$title = "";
	switch($Url->whereAmI()) {
		case 'post':
			$title = $Post->title().' | '.$Site->title();
			break;

		case 'page':
			if($Page->key() == "home") {
				$title = $Site->title() . ' | ' . $Site->slogan();
			} else {
				$title = $Page->title().' | '.$Site->title();
			}
			break;

		case 'blog':
			$title = "Blog | " . $Site->title();
			break;

		case 'tag':
			$title = "Tag: " . $dbTags->db["postsIndex"][$Url->slug()]["name"].' | '.$Site->title();
			break;

		default:
			$title = $Site->title() . ' | ' . $Site->slogan();
			break;
	}
	echo $title;
	?></title>
<?php
Theme::css("style.css");
Theme::description();
?>

<style>
	#footer-top {
		background-image: url(<?php echo HTML_PATH_THEME_IMG . 'bg.jpg'; ?>);
		-webkit-background-size: cover;
		background-size: cover;
		background-position: top center;
	}
</style>

<!-- Plugins site head -->
<?php Theme::plugins('siteHead') ?>
<?php
$icon = HTML_PATH_UPLOADS_PROFILES.'admin.png';
if($Url->whereAmI() == 'page' && $Page->parentKey() == "album") { $icon = $Page->coverImage(); }
?>
<link rel="icon" type="image/png" href="<?php echo $icon; ?>">
</head>
<body>
	<header class="cf">
		<div class="container">
			<div id="site-title">
				<?php $site_logo = HTML_PATH_UPLOADS_PROFILES.'admin.png'; ?>
				<img id="site-logo" src="<?php echo $site_logo; ?>" alt="<?php echo $Site->title(); ?>">
				<h1><a href="<?php echo $Site->url(); ?>"><?php echo $Site->title(); ?></a></h1>
				<p id="site-slogan"><?php echo $Site->slogan(); ?></p>
			</div>
		</div>
		<div id="menu-btn" class=""><span></span></div>
	</header>
	<nav id="top-level-nav" role="navigation">
		<div class="container cf">
			<ul id="main-menu">
				<?php
				$html = '';
				
				// Uncomment if you want a link to the home page but don't already have one.
				// $html = '<li><a href="'.$Site->homeLink().'">'.$Language->get('Home').'</a></li>';

				$parents = $pagesParents[NO_PARENT_CHAR];
				foreach($parents as $parent)
				{
					// Check if the parent is published
					if( $parent->published() )
					{
						// Print the parent
						$hasChildren = isset($pagesParents[$parent->key()]);
						$html .= '<li' . ( ($hasChildren)?' class="dropdown"':'') . '>';
						$html .= '<a href="'.$parent->permalink().'">'.$parent->title().'</a>';
						// Check if the parent has children
						if($hasChildren)
						{
							$html .= '<span class="dropdown-btn"></span>';
							$children = $pagesParents[$parent->key()];
		
							// Print children
							$html .= '<ul class="submenu">';
							foreach($children as $child)
							{
								// Check if the child is published
								if( $child->published() )
								{
									$html .= '<li>';
									$html .= '<a href="'.$child->permalink().'">'.$child->title().'</a>';
									$html .= '</li>';
								}
							}
							$html .= '</ul>';
						}
					}
				}
				
				echo $html;

				?>
			</ul>
		</div>
	</nav>
	<section id="content">
		<div class="container"><?php
		switch ($Url->whereAmI()) {
			case 'home':
			case 'blog':
			case 'tag':
				foreach($posts as $Post) {
					echo '<article>';
					if($Post->coverImage()) {
						echo '<a href="' . $Post->permalink() . '"><img src="' . $Post->coverImage() . '" class="featured" alt="' . $Post->title() . '" /></a>';
					}
					echo '<h2 class="post-title"><a href="' . $Post->permalink() . '">' . $Post->title() . '</a></h2>';
					echo '<time datetime="' . $Post->dateRaw(DATE_W3C) . '">' . $Post->date() . "</time>";
					echo '<div class="page-content"><p>' . $Post->description() . '</p><p><a class="btn" href="' . $Post->permalink() . '">Continue Reading</a></p></div></article>';
				}
				// Pagination
				echo '<article class="pagination">';
				$pg = Paginator::get('showNewer') || Paginator::get('showOlder');
				if ($pg) echo '<ul class="cf">';
				if( Paginator::get('showNewer') ) {
					echo '<li><a href="'.Paginator::urlPrevPage().'" class="pg-new">Newer Posts</a></li>';
				}
				if( Paginator::get('showOlder') ) {
					echo '<li><a href="'.Paginator::urlNextPage().'" class="pg-old">Older Posts</a></li>';
				}
				if ($pg) echo '</ul>';
				echo '</article>';
				break;
			case 'post':
				echo '<article>';
				if($Post->coverImage()) {
					echo '<img src="' . $Post->coverImage() . '" class="featured" alt="' . $Post->title() . '" />';
				}
				echo '<h2 class="post-title">'.$Post->title().'</h2>';
				echo '<time datetime="' . $Post->dateRaw(DATE_W3C) . '">' . $Post->date() . "</time>";
				echo '<p class="excerpt">' . $Post->description() . '</p>';
				echo '<div class="page-content">'.$Post->content().'</div>';
				echo '</article>';
				echo '<article>';
				Theme::plugins('postEnd');
				echo '</article>';
				break;
			case 'page':
				echo '<article>';
				echo '<h2 class="post-title">'.$Page->title().'</h2>';
				if($Page->coverImage()) {
					echo '<img src="' . $Page->coverImage() . '" class="featured page" alt="' . $Page->title() . '" />';
				}
				echo '<p class="excerpt">' . $Page->description() . '</p>';
				echo '<div class="page-content'.(($Page->parentKey() != "")?' '.$Page->parentKey():'').'">'.$Page->content().'</div>';
				echo '</article>';
				echo '<article>';
				Theme::plugins('pageEnd');
				echo '</article>';
				break;
			
			default:
				# code...
				break;
		}
		?>
		</div>
	</section>
	<footer id="footer-top">
		<div class="container">
			<div id="widgets" class="cf">
				<?php Theme::plugins('siteSidebar') ?>
			</div>
		</div>
	</footer>
	<footer id="footer-bottom">
		<div class="container cf">
			<span id="copyright-info"><?php echo $Site->footer() ?></span>
			<nav role="navigation">
				<ul id="footer-menu">
					<?php

						// Uncomment if you want a link to the home page but don't already have one.
						// echo "<li><a href="'.$Site->homeLink().'">'.$Language->get('Home').'</a></li>";

						$parents = $pagesParents[NO_PARENT_CHAR];
						foreach($parents as $Parent) {
							echo '<li><a href="'.$Parent->permalink().'">'.$Parent->title().'</a></li>';
						}
					?>
					<li><a href="<?php echo $Site->url() ?>sitemap.xml">Sitemap</a></li>
					<li><a href="<?php echo $Site->url() ?>rss.xml">RSS Feed</a></li>
				 </ul>
			</nav>
		</div>
		<div class="invisiblock"></div>
	</footer>
	<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "WebSite",
			"name": "<?php echo $Site->title(); ?>",
			"url": "<?php echo $Site->url(); ?>"
		}
	</script>
	<script src="https://code.jquery.com/jquery-3.1.0.min.js" type="text/javascript"></script>
	<?php Theme::javascript('main.js') ?>
	<?php Theme::plugins('siteBodyEnd'); ?>
</body>
</html>