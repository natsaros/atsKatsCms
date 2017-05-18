<head>
    <title>Fitness House</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="mobile-web-app-capable" content="yes">
    <meta name="description" content="Fitness house by Penny,Fitness-House-by-Penny">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="keywords"
          content="pilates,aerial,yoga,fitness house,fitness,elliniko,glyfada,peny,kasfiki,personal trainer,Fitness-House-by-Penny,penny,Penny,Kasfiki,Fitness House">

    <?php if ($pageId == "blogpost" && isset($_GET["post_friendly_url"])) {
        $post = PostHandler::getPostByFriendlyTitleWithDetails($_GET["post_friendly_url"]);
    } else {
        $post = null;
    } ?>
    <?php if (!is_null($post)) { ?>
        <meta property="og:url" content="http://fitnesshousebypenny.gr/blog/<?php echo $post->getFriendlyTitle()?>" >
        <meta property="og:type" content="article"/>
        <meta property="og:title" itemprop="name" content="<?php echo $post->getTitle()?>" >
        <meta property="og:image" content="<?php echo $post->getImage()?>" >
    <?php } else { ?>
        <meta property="og:url" content="http://fitnesshousebypenny.gr" >
        <meta property="og:type" content="website"/>
        <meta property="og:title" itemprop="name" content="Fitness House by Penny" >
        <meta property="og:image" content="http://fitnesshousebypenny.gr/img/gallery3.jpg" >
    <?php } ?>
    <meta property="og:site_name" content="fitnesshousebypenny.gr" >
    <meta property="og:description" content="Fitness house by Penny - a place to start your new life!" >
    <meta property="og:image:type" content="image/jpeg" >
    <meta property="og:image:width" content="1444" >
    <meta property="og:image:height" content="960" >


    <link rel="image_src" href="http://fitnesshousebypenny.gr/img/gallery3.jpg" />

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300italic,300,100italic&subset=latin,greek,greek-ext'
          rel='stylesheet' type='text/css'>

    <link rel="shortcut icon" href="<?php echo ASSETS_URI ?>img/favicon.png"/>
    <link rel="icon" type="image/png" href="<?php echo ASSETS_URI ?>img/favicon.png"/>
    <link rel="icon" sizes="192x192" href="<?php echo ASSETS_URI ?>img/favicon.png">

    <link rel="apple-touch-icon" href="<?php echo ASSETS_URI ?>ios/Icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo ASSETS_URI ?>ios/Icon-Small-50.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo ASSETS_URI ?>ios/Icon-72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo ASSETS_URI ?>ios/Icon@2x.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo ASSETS_URI ?>ios/Icon-72@2x.png" />

    <link rel="stylesheet" href="<?php echo ASSETS_URI ?>css/bootstrap.min.css">
    <?php if (!is_null($post)) { ?>
        <link rel="stylesheet" href="<?php echo ASSETS_URI ?>font-awesome/css/font-awesome.min.css">
    <?php } ?>
    <link rel="stylesheet" href="<?php echo ASSETS_URI ?>css/custom.css">
    <script src="<?php echo ASSETS_URI ?>js/jquery.min.js"></script>
    <script src="<?php echo ASSETS_URI ?>js/bootstrap.min.js"></script>
    <?php if ($pageId == "contact") { ?>
        <script src="http://maps.googleapis.com/maps/api/js"></script>
    <?php } ?>
    <script src="<?php echo ASSETS_URI ?>js/custom.js"></script>
</head>