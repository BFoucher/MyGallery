<?php
require_once('functions/global.php');
require_once('functions/configuration.php');
require_once('nbPage.php');

function nbPageUrl($nb){
    if(isset($_GET['page'])){
        return ' ?page=' . $_GET['page'] . '&nbPage='.$nb;
        }
    return '?nbPage='.$nb;
}

?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">MyGallery</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="?p=list"><i class="fa fa-align-justify"></i> Liste des fichiers </a></li>
                <li><a href="?p=gallery"><i class="fa fa-th-large"></i> Gallerie d'images</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Nbr par page: <?=nbItem(); ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= nbPageUrl(5);?>">5</a></li>
                        <li><a href="<?= nbPageUrl(10);?>">10</a></li>
                        <li><a href="<?= nbPageUrl(20);?>">20</a></li>
                    </ul>
                </li>
            </ul>
            <?php if (isUser()){
                    echo '<ul class="nav navbar-nav navbar-right alert-danger"><li class="succes"><a href="?p=auth&action=logout"><i class="fa fa-power-off"></i></a></li></ul>';
            }else{ ?>
            <form method="POST" action="?p=auth&action=check" class="navbar-form navbar-right" role="login">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="foo" name="username">
                    <input type="password" class="form-control" placeholder="bar" name="password">
                </div>
                <button type="submit" class="btn btn-info"><i class="fa fa-power-off"></i></button>
            </form>
            <?php } ?>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>