<div class="container-fluid">
    <div class="row row-no-padding">
        <div class="col-sm-12">
            <div id="myCarousel" class="carousel slide carousel-fade text-center" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active">&nbsp;</li>
                    <li data-target="#myCarousel" data-slide-to="1">&nbsp;</li>
                    <li data-target="#myCarousel" data-slide-to="2">&nbsp;</li>
                    <li data-target="#myCarousel" data-slide-to="3">&nbsp;</li>
                    <li data-target="#myCarousel" data-slide-to="4">&nbsp;</li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <div class="carousel-container" id="first">
                        </div>
                    </div>

                    <div class="item">
                        <div class="carousel-container" id="second">
                        </div>
                    </div>

                    <div class="item">
                        <div class="carousel-container" id="third">
                        </div>
                    </div>

                    <div class="item">
                        <div class="carousel-container" id="fourth">
                        </div>
                    </div>

                    <div class="item">
                        <div class="carousel-container" id="fifth">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container text-center">
    <div class="site-info-container">
        <div class="row site-info">
            <div class="col-sm-12">
                <div class="textHolder">
                    <div class="genColor textHolderInside">
                        <?php getLocalizedText("site_info")?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-center">
    <div class="instagram-feed-container">
        <div class="row instagram-feed">
            <div class="col-sm-12">
                <div id="instagram-user-info" class="instagram-user-info-container">
                    <a href="https://www.instagram.com/sellinofos/" target="_blank" title="Sellinofos @ Instagram">
                        <img class="instagram-avatar" src="" />
                        <div class="instagram-user-info">
                            <div class="instagram-name">
                                <div class="instagram-fullname"></div>
                                &nbsp;&nbsp;&nbsp;
                                <div class="instagram-username"></div>
                            </div>
                            <div class="instagram-bio"></div>
                        </div>
                    </a>
                </div>
                <div id="instagram-feed-items" class="instagram-feed-items"></div>
                <button class="btn btn-block btn-default instagram-feed-load-more" id="instagram-feed-load-more"><?php echo getLocalizedText("instagram_more");?></button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid text-center">
    <div class="row row-no-padding">
        <div class="col-sm-12">
            <div class="parallaxImage">
                <div class="motoCreation img-circle">
                    <div class="motoContainer">
                        <?php echo getLocalizedText("parallax_quote");?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $.getJSON('https://api.instagram.com/v1/users/3155843580/?access_token=3155843580.d3d78ae.1885ed7fc5054c9ab1f886fd6843f092', function(data) {
        if (data != null && data !== ''){
            $('.instagram-avatar').attr('src', data.data.profile_picture);
            $('.instagram-fullname').html(data.data.full_name);
            $('.instagram-username').html('@' + data.data.username);
            $('.instagram-bio').html(data.data.bio);
        }
    });

    var userFeed = new Instafeed({
        target: 'instagram-feed-items',
        get: 'user',
        userId: '3155843580', //sellinofos
        clientId: 'd3d78aee11b34df9afad20ae289f5e23',
        accessToken: '3155843580.d3d78ae.1885ed7fc5054c9ab1f886fd6843f092',
        resolution: 'thumbnail',
        template: '<div class="instagram-image-container"><a href="{{link}}" target="_blank" id="{{id}}"><img src="{{image}}" /></a></div>',
        sortBy: 'most-recent',
        limit: 10,
        links: true,
        after: function() {
            if (!this.hasNext()) {
                btnInstafeedLoad.setAttribute('disabled', 'disabled');
            }
        }
    });
    userFeed.run();

    var btnInstafeedLoad = document.getElementById("instagram-feed-load-more");
    btnInstafeedLoad.addEventListener("click", function() {
        userFeed.next()
    });
</script>