<div id="carousel-welcome" class="carousel slide template-content-wide" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php
            if(count($images) > 0 ){
                foreach($images as $index => $img){ ?>
                    <div class="item <?php if($index == 0) echo 'active'; ?>">
                        <img src="http://imagestore.nomadespot.com/1200x550/<?=$img->uri?>" alt="<?=$img->name?>">
                        <div class="carousel-caption">
                            <h3><?=$img->name?></h3>
                            <p><?=$img->name?></p>
                        </div>
                    </div>
                <?php }
            }
        ?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-welcome" role="button" data-slide="prev">
        <i class="glyphicon glyphicon-chevron-left"></i>
    </a>
    <a class="right carousel-control" href="#carousel-welcome" role="button" data-slide="next">
        <i class="glyphicon glyphicon-chevron-right"></i>
    </a>
</div>

<h1>Bem vindo ao <?=$this->session->userdata('client_name')?></h1>

<div class="row">
    <div class="col-sm-8">
    <div class="well well-mini">
            <div class="row">
                <div class="col-sm-4">
                    <img src="http://imagestore.nomadespot.com/50">
                </div>
                <div class="col-sm-18">
                    <h5><a href="#">Venue Name</a></h5>
                    <h6 class="subheader show-for-small">Doors at 00:00pm</h6>
                </div>
            </div>
        </div>
        <div class="well well-mini">
            <div class="row">
                <div class="col-sm-4">
                    <img src="http://imagestore.nomadespot.com/50">
                </div>
                <div class="col-sm-18">
                    <h5><a href="#">Venue Name</a></h5>
                    <h6 class="subheader show-for-small">Doors at 00:00pm</h6>
                </div>
            </div>
        </div>
        <div class="well well-mini">
            <div class="row">
                <div class="col-sm-4">
                    <img src="http://imagestore.nomadespot.com/50">
                </div>
                <div class="col-sm-18">
                    <h5><a href="#">Venue Name</a></h5>
                    <h6 class="subheader show-for-small">Doors at 00:00pm</h6>
                </div>
            </div>
        </div>
        <div class="well well-mini">
            <div class="row">
                <div class="col-sm-4">
                    <img src="http://imagestore.nomadespot.com/50">
                </div>
                <div class="col-sm-18">
                    <h5><a href="#">Venue Name</a></h5>
                    <h6 class="subheader show-for-small">Doors at 00:00pm</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="flex-video widescreen"><iframe src="//player.vimeo.com/video/36519586?color=ff9933" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>
        <p><a href="http://vimeo.com/36519586">a story for tomorrow.</a> from <a href="http://vimeo.com/gnarlybay">gnarly bay</a> on <a href="https://vimeo.com">Vimeo</a>.</p>
    </div>
    <div class="col-sm-8">
        <h4>Blog</h4><hr>
        <div class="">
            <h5><a href="#">Post Title 1</a></h5>
            <h6 class="subheader">
                Risus ligula, aliquam nec fermentum vitae, sollicitudin eget urna. Suspendisse ultrices ornare tempor...
            </h6>
            <h6><a href="#">Read More »</a></h6>
        </div>
        <div class="">
            <h5><a href="#">Post Title 2 »</a></h5>
        </div>
        <div class="">
            <h5><a href="#">Post Title 3 »</a></h5>
        </div>
        <a href="#" class="right">Go To Blog »</a>
    </div>
</div>