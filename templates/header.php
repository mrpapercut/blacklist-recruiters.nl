<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

	<meta name="description" content="De plek waar de absurde werkwijzes van IT recruiters in Nederland worden verzameld.">

	<base href="<?php echo BASE_URL; ?>">

	<meta property="fb:admins" content="758023081" />
	<meta property="og:title" content="Blacklist IT Recruiters Nederland" />
	<meta property="og:url" content="<?php echo BASE_URL; ?>" />
	<meta property="og:image" content="http://blacklist-recruiters.nl/img/touch-icon.png" />
	<meta property="og:description" content="De plek waar de absurde werkwijzes van IT recruiters worden verzameld" />

	<link href="dist/bundle.css" rel="stylesheet">

	<title>Blacklist IT Recruiters Nederland</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="header">
	<h1 id="title">
		<a href="<?php echo BASE_URL; ?>">Blacklist IT Recruiters Nederland</a>
	</h1>
    <div class="icons">
        <?php if (!isset($_GET['cat'])) { ?>
        <button id="opensearch" type="button">
            <svg version="1.1"xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="25px" height="25px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve">
                <path d="M35.525,31.228l-8.88-8.882c1.444-2.238,2.298-4.895,2.298-7.752c0-7.909-6.438-14.343-14.346-14.343
                c-7.911,0-14.343,6.434-14.343,14.343c0,7.911,6.433,14.344,14.343,14.344c2.856,0,5.513-0.849,7.752-2.294l8.88,8.88
                c0.295,0.297,0.782,0.297,1.076,0l3.22-3.221C35.824,32.008,35.824,31.523,35.525,31.228z M4.81,14.593
                c0-5.396,4.391-9.788,9.788-9.788c5.398,0,9.787,4.392,9.787,9.788c0,5.398-4.389,9.789-9.787,9.789
                C9.2,24.382,4.81,19.991,4.81,14.593z"/>
            </svg>
        </button>
        <?php } ?>
        <div id="search"><input id="input"></div>
    </div>
    <div class="navbtns">
        <a class="navbtn" id="makereport" href="<?php echo URL_SUBMIT; ?>">Maak een melding</a>
        <a class="navbtn" href="<?php echo URL_COMPANIES; ?>">Bedrijven</a>
    </div>
</div>
<div id="content">
