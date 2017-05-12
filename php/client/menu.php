<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= REQUEST_URI ?>home">
                <img src="<?= ASSETS_URI ?>img/logo.png" alt="Fitness House" class="img-responsive">
            </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php if($pageId == "home"){ ?>active<?php } ?>"><a href="<?= REQUEST_URI ?>home">Αρχική</a></li>
                <li class="<?php if($pageId == "about"){ ?>active<?php } ?>"><a href="<?= REQUEST_URI ?>about">Το Studio</a></li>
                <li class="<?php if($pageId == "program"){ ?>active<?php } ?>"><a href="<?= REQUEST_URI ?>program">Πρόγραμμα</a></li>
                <li class="<?php if($pageId == "blog"){ ?>active<?php } ?>"><a href="<?= REQUEST_URI ?>blog">Blog</a></li>
<!--                <li><a href="#blog">Blog</a></li>-->
                <li class="<?php if($pageId == "contact"){ ?>active<?php } ?>"><a href="<?= REQUEST_URI ?>contact">Επικοινωνία</a></li>
                <!--<li><a href="#bookNow">Book Now</a></li>-->
            </ul>
        </div>
    </div>
</nav>