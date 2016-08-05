<div role="navigation" class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target=".navbar-collapse" class="navbar-toggle"><span
                    class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span
                    class="icon-bar"></span></button>
            <a href="../index.php" class="navbar-brand">xolf - Verwaltung</a></div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <?php foreach ($navigationElements as $name => $dropdown) : ?>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo $name ?> <i class="fa fa-caret-down"></i></a>
                        <ul role="menu" class="dropdown-menu dropdown-menu-right">
                            <?php foreach ($dropdown as $li) : ?>
                                <li><a href="<?php echo $li['link'] ?>"><i class="fa fa-<?php echo $li['icon'] ?> fa-fw"></i> <?php echo $li['text'] ?></a></li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>
            <ul class="nav navbar-nav navbar-right">
            </ul>
        </div>
    </div>
</div>