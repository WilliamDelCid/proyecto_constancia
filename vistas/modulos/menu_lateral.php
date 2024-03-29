<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main" style="background-color: #004A98;height: 120px;display:flex; flex-direction: row; align-items: center; justify-content: center; ">
        <div class="container-fluid">
            <!-- Logo container-->
            <div class="logo">
                <a href="index.php" class="logo">
                    <img src="<?= url_base(); ?>/archivos/imagenes/Logo_Universidad.png" alt="" style="display: flex;object-fit: contain; margin: 0 auto ; " width="90%" height="100">
                </a>

            </div>
        </div> <!-- end container -->
        <!-- <div class="menu-extras topbar-custom"> -->
        <ul class="list-inline float-right mb-0">
            <li class="menu-item list-inline-item">
                <!-- Mobile menu toggle-->
                <a class="navbar-toggle nav-link">
                    <div class="lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </a>
                <!-- End mobile menu toggle-->
            </li>
        </ul>
        <!-- </div> -->
    </div>
    <!-- end topbar-main -->
    <!-- MENU Start -->
    <div class="navbar-custom" style="background-color: #fff;">
        <div class="container-fluid">
            <div id="navigation" style="top: unset; z-index: 1; ">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <li class="has-submenu">
                        <a href="<?= url_base(); ?>" style="color: #004A98;"><i class="mdi mdi-view-dashboard"></i>Inicio</a>

                    </li>

                    <li class="has-submenu">
                        <a href="#" style="color: #004A98;"><i class="mdi mdi-buffer"></i>Mantenimiento</a>
                        <ul class="submenu">
                            <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Usuarios'])) { ?>
                                <li class="">
                                    <a href="<?= url_base(); ?>/usuarios" class=" <?php if ($datos_vista['nombre_pagina'] == 'usuarios') {
                                                                                        echo 'active';
                                                                                    } ?>">
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Roles'])) { ?>
                                <li class="">
                                    <a href="<?= url_base(); ?>/roles" class=" <?php if ($datos_vista['nombre_pagina'] == 'roles') {
                                                                                    echo 'active';
                                                                                } ?>">
                                        <p>Roles</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Participacion'])) { ?>
                                <li class="">
                                    <a href="<?= url_base(); ?>/participacion" class=" <?php if ($datos_vista['nombre_pagina'] == 'participacion') {
                                                                                            echo 'active';
                                                                                        } ?>">
                                        <p>Tipo de Participacion</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Evento'])) { ?>
                                <li class="">
                                    <a href="<?= url_base(); ?>/evento" class=" <?php if ($datos_vista['nombre_pagina'] == 'evento') {
                                                                                    echo 'active';
                                                                                } ?>">
                                        <p>Evento</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Cargo'])) { ?>
                                <li class="">
                                    <a href="<?= url_base(); ?>/cargos" class=" <?php if ($datos_vista['nombre_pagina'] == 'cargos') {
                                                                                    echo 'active';
                                                                                } ?>">
                                        <p>Cargos</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Empleado'])) { ?>
                                <li class="">
                                    <a href="<?= url_base(); ?>/empleados" class=" <?php if ($datos_vista['nombre_pagina'] == 'empleados') {
                                                                                        echo 'active';
                                                                                    } ?>">
                                        <p>Empleados</p>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Tipo Documento'])) { ?>
                                <li class="">
                                    <a href="<?= url_base(); ?>/tipo_documento" class=" <?php if ($datos_vista['nombre_pagina'] == 'Tipo de Documento') {
                                                                                            echo 'active';
                                                                                        } ?>">
                                        <p>Tipo de Documento</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Crear Formulario'])) { ?>

                        <li class="has-submenu">


                            <a href="#" style="color: #004A98;"><i class="mdi mdi-book"></i>Formulario</a>

                            <ul class="submenu">
                                <li class="">

                                    <a href="<?= url_base(); ?>/crearformulario" class=" <?php if ($datos_vista['nombre_pagina'] == 'crearformulario') {
                                                                                                echo 'active';
                                                                                            } ?>">
                                        Crear formulario

                                    </a>
                                </li>
                                <?php if (isset($_SESSION['todos_permisos_' . nombreproyecto()]['Ver Formulario'])) { ?>
                                    <li class="">
                                        <a href="<?= url_base(); ?>/formulario" class=" <?php if ($datos_vista['nombre_pagina'] == 'formulario') {
                                                                                            echo 'active';
                                                                                        } ?>">
                                            Ver formularios
                                        </a>
                                    </li>
                                <?php } ?>




                            </ul>
                        </li>
                    <?php } ?>

                    <li>
                        <a style="color: #004A98;" href="<?= url_base(); ?>/logout" class="dropdown-item">
                            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                        </a>
                    </li>
                    <!-- <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?= url_base(); ?>/Horizontal/public/assets/images/users/avatar-1.jpg" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <a class="dropdown-item" href="#"><i class="dripicons-user text-muted"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="dripicons-wallet text-muted"></i> My Wallet</a>
                            <a class="dropdown-item" href="#"><span class="badge badge-success pull-right m-t-5">5</span><i class="dripicons-gear text-muted"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="dripicons-lock text-muted"></i> Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#"><i class="dripicons-exit text-muted"></i> Logout</a>
                        </div>
                    </li> -->
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->