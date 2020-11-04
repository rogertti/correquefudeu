<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
    <?php
        switch($m) {
            case 1:
                echo'
                <li class="active"><a href="inicio" title="In&iacute;cio - Todas as postagens"><i class="fa fa-home"></i> <span>In&iacute;cio</span></a></li>
                <li><a href="novo-post" title="Nova postagem"><i class="fa fa-file-text"></i> <span>Novo Post</span></a></li>
                <li><a href="sobre" title="Edite o texto sobre voc&ecirc;"><i class="fa fa-sticky-note"></i> <span>Sobre</span></a></li>
                <li><a href="tag" title="Gerenciar as tags"><i class="fa fa-tag"></i> <span>Tag</span></a></li>
                <li><a href="social" title="Gerencie as redes sociais"><i class="fa fa-connectdevelop"></i> <span>Social</span></a></li>
                <li><a href="autor" title="Edite seu nome e seu login"><i class="fa fa-user"></i> <span>Autor</span></a></li>';
            break;

            case 2:
                echo'
                <li><a href="inicio" title="In&iacute;cio - Todas as postagens"><i class="fa fa-home"></i> <span>In&iacute;cio</span></a></li>
                <li class="active"><a href="novo-post" title="Nova postagem"><i class="fa fa-file-text"></i> <span>Novo Post</span></a></li>
                <li><a href="sobre" title="Edite o texto sobre voc&ecirc;"><i class="fa fa-sticky-note"></i> <span>Sobre</span></a></li>
                <li><a href="tag" title="Gerenciar as tags"><i class="fa fa-tag"></i> <span>Tag</span></a></li>
                <li><a href="social" title="Gerencie as redes sociais"><i class="fa fa-connectdevelop"></i> <span>Social</span></a></li>
                <li><a href="autor" title="Edite seu nome e seu login"><i class="fa fa-user"></i> <span>Autor</span></a></li>';
            break;

            case 3:
                echo'
                <li><a href="inicio" title="In&iacute;cio - Todas as postagens"><i class="fa fa-home"></i> <span>In&iacute;cio</span></a></li>
                <li><a href="novo-post" title="Nova postagem"><i class="fa fa-file-text"></i> <span>Novo Post</span></a></li>
                <li><a href="sobre" title="Edite o texto sobre voc&ecirc;"><i class="fa fa-sticky-note"></i> <span>Sobre</span></a></li>
                <li class="active"><a href="tag" title="Gerenciar as tags"><i class="fa fa-tag"></i> <span>Tag</span></a></li>
                <li><a href="social" title="Gerencie as redes sociais"><i class="fa fa-connectdevelop"></i> <span>Social</span></a></li>
                <li><a href="autor" title="Edite seu nome e seu login"><i class="fa fa-user"></i> <span>Autor</span></a></li>';
            break;

            case 4:
                echo'
                <li><a href="inicio" title="In&iacute;cio - Todas as postagens"><i class="fa fa-home"></i> <span>In&iacute;cio</span></a></li>
                <li><a href="novo-post" title="Nova postagem"><i class="fa fa-file-text"></i> <span>Novo Post</span></a></li>
                <li class="active"><a href="sobre" title="Edite o texto sobre voc&ecirc;"><i class="fa fa-sticky-note"></i> <span>Sobre</span></a></li>
                <li><a href="tag" title="Gerenciar as tags"><i class="fa fa-tag"></i> <span>Tag</span></a></li>
                <li><a href="social" title="Gerencie as redes sociais"><i class="fa fa-connectdevelop"></i> <span>Social</span></a></li>
                <li><a href="autor" title="Edite seu nome e seu login"><i class="fa fa-user"></i> <span>Autor</span></a></li>';
            break;

            case 5:
                echo'
                <li><a href="inicio" title="In&iacute;cio - Todas as postagens"><i class="fa fa-home"></i> <span>In&iacute;cio</span></a></li>
                <li><a href="novo-post" title="Nova postagem"><i class="fa fa-file-text"></i> <span>Novo Post</span></a></li>
                <li><a href="sobre" title="Edite o texto sobre voc&ecirc;"><i class="fa fa-sticky-note"></i> <span>Sobre</span></a></li>
                <li><a href="tag" title="Gerenciar as tags"><i class="fa fa-tag"></i> <span>Tag</span></a></li>
                <li class="active"><a href="social" title="Gerencie as redes sociais"><i class="fa fa-connectdevelop"></i> <span>Social</span></a></li>
                <li><a href="autor" title="Edite seu nome e seu login"><i class="fa fa-user"></i> <span>Autor</span></a></li>';
            break;

            case 6:
                echo'
                <li><a href="inicio" title="In&iacute;cio - Todas as postagens"><i class="fa fa-home"></i> <span>In&iacute;cio</span></a></li>
                <li><a href="novo-post" title="Nova postagem"><i class="fa fa-file-text"></i> <span>Novo Post</span></a></li>
                <li><a href="sobre" title="Edite o texto sobre voc&ecirc;"><i class="fa fa-sticky-note"></i> <span>Sobre</span></a></li>
                <li><a href="tag" title="Gerenciar as tags"><i class="fa fa-tag"></i> <span>Tag</span></a></li>
                <li><a href="social" title="Gerencie as redes sociais"><i class="fa fa-connectdevelop"></i> <span>Social</span></a></li>
                <li class="active"><a href="autor" title="Edite seu nome e seu login"><i class="fa fa-user"></i> <span>Autor</span></a></li>';
            break;

            default:
                echo'
                <li><a href="inicio" title="In&iacute;cio - Todas as postagens"><i class="fa fa-home"></i> <span>In&iacute;cio</span></a></li>
                <li><a href="novo-post" title="Nova postagem"><i class="fa fa-file-text"></i> <span>Novo Post</span></a></li>
                <li><a href="sobre" title="Edite o texto sobre voc&ecirc;"><i class="fa fa-sticky-note"></i> <span>Sobre</span></a></li>
                <li><a href="tag" title="Gerenciar as tags"><i class="fa fa-tag"></i> <span>Tag</span></a></li>
                <li><a href="social" title="Gerencie as redes sociais"><i class="fa fa-connectdevelop"></i> <span>Social</span></a></li>
                <li><a href="autor" title="Edite seu nome e seu login"><i class="fa fa-user"></i> <span>Autor</span></a></li>';
            break;
        }
    ?>
    </ul><!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
