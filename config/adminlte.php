<?php

use function PHPSTORM_META\type;




return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'AdminLTE 3',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],


    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>MPPPST</b>',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/logompppst.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 300,
            'height' => 300,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => 'sidebar-collapse',
    'classes_brand' => 'bg-primary',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'inicio',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,
    'disable_darkmode_routes' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Asset Bundling
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Asset Bundling option for the admin panel.
    | Currently, the next modes are supported: 'mix', 'vite' and 'vite_js_only'.
    | When using 'vite_js_only', it's expected that your CSS is imported using
    | JavaScript. Typically, in your application's 'resources/js/app.js' file.
    | If you are not using any of these, leave it as 'false'.
    |
    | For detailed instructions you can look the asset bundling section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'laravel_asset_bundling' => false,
    'laravel_css_path' => 'css/app.css',
    'laravel_js_path' => 'js/app.js',


    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */



    'menu' => [
        // Navbar items:
        [
            'type' => 'navbar-search',
            'text' => 'search',
            'topnav_right' => true,
        ],
        [
            'type' => 'fullscreen-widget',
            'topnav_right' => true,
        ],

        // Sidebar items:
        [
            'type' => 'sidebar-menu-search',
            'text' => 'search',
        ],
        [
            'text' => 'blog',
            'url' => 'admin/blog',
            'can' => 'manage-blog',
        ],
        /*  [
            'text' => 'pages',
            'url' => 'admin/pages',
            'icon' => 'far fa-fw fa-file',
            'label' => 4,
            'label_color' => 'success',
        ], */
        /* ['header' => 'account_settings'], */
        [
            'text' => 'profile',
            'icon' => 'fas fa-fw fa-user',
            'url' => 'perfil',

        ],

        /* [
            'text' => 'multilevel',
            'icon' => 'fas fa-fw fa-share',
            'submenu' => [
                [
                    'text' => 'level_one',
                    'url' => '#',
                ],
                [
                    'text' => 'level_one',
                    'url' => '#',
                    'submenu' => [
                        [
                            'text' => 'level_two',
                            'url' => '#',
                        ],
                        [
                            'text' => 'level_two',
                            'url' => '#',
                            'submenu' => [
                                [
                                    'text' => 'level_three',
                                    'url' => '#',
                                ],
                                [
                                    'text' => 'level_three',
                                    'url' => '#',
                                ],
                            ],
                        ],
                    ],
                ],
                [
                    'text' => 'level_one',
                    'url' => '#',
                ],
            ],
        ], */
        ['header' => 'MODULOS'],

        [
            'text' => 'Recibos y Constancias',
            'url' => '/recibosconstancias',
            'icon' => 'fas fa-fw bi-receipt-cutoff',
        ],

        [
            'text' => 'Constancia de Trabajo',
            'topnav' => true,
            'classes' => 'opciones-recibos', // Clase única para tu filtro
            'submenu' => [
                [
                    'text' => 'Simple Con Sueldo',
                    'url'  => '/recibosconstancias/simple-sueldo',
                    'target' => '_blank',
                ],
                [
                    'text' => 'Egreso',
                    'url'  => '/recibosconstancias/egresado',
                ],
                [
                    'text' => 'Faov',
                    'url'  => '/recibosconstancias/faov',
                ],
                [
                    'text' => 'Simple con Sueldo por Trabajador',
                    'url'  => '/recibosconstancias/buscar-sueldo',
                ],
                [
                    'text' => 'Jubilados',
                    'url'  => '/recibos/jubilados',
                ],
            ],
        ],

        [
            'text' => 'Recibos de Pago',
            'topnav' => true,
            'classes' => 'opciones-recibos',
            'submenu' => [
                [
                    'text' => 'Año Actual',
                    'url'  => '#',
                    'submenu' => [
                        [
                            'text' => 'Ordinario',
                            'url'  => '/recibos-pagos/ordinarios',
                        ],
                        [
                            'text' => 'Especial',
                            'url'  => '/recibos-pagos/especiales',
                        ],
                    ],
                ],
                [
                    'text' => 'Jubilados',
                    'url'  => '/recibos-jubilados',
                ],
                [
                    'text' => 'Mensual por Trabajador',
                    'url'  => '/recibos/mensual-trabajador',
                ],
            ],
        ],

        [
            'text'    => 'Mantenimiento',
            'topnav'  => true,
            'classes' => 'opciones-recibos',
            'submenu' => [
                [
                    'text'    => 'Tickets de Alimentación',
                    'url'     => '/mantenimiento/tickets-alimentacion',
                ],
                [
                    'text'    => 'Usuarios',
                    'url'  => '/recibos-constancias/mantenimiento/usuarios',
                ],
            ]


        ],

        [
            'text' => 'Procesos',
            'topnav' => true,
            'classes' => 'opciones-recibos',
            'submenu' => [
                [
                    'text' => 'Actualizar Personal',
                    'url'  => '/procesos/actualizar-personal',
                ],
                [
                    'text' => 'Consultar Datos',
                    'url'  => '/procesos/consultar-datos',
                ],
                [
                    'text' => 'Nómina Funcionarios',
                    'url'  => '/procesos/funcionarios',
                ],
                [
                    'text' => 'Nómina Obreros',
                    'url'  => '/procesos/obreros',
                ],
            ],
        ],

        [
            'text' => 'Roraima',
            'url' => '/roraima',
            'icon' => 'fas fa-fw fa-cogs',
        ],

       [
            'text' => 'Proyectos',
            'topnav' => true,
            'classes' => 'opciones-roraima',
            'submenu' => [
                [
                    'text' => 'Proyectos',
                    'url'  => 'roraima/proyectos',
                ],
                [
                    'text' => 'Acción Centralizada',
                    'url'  => 'roraima/acciones-centralizadas',
                ],
            ]
        ],


       [
            'text' => 'Asignar Usuarios',
            'topnav' => true,
            'classes' => 'opciones-roraima',
            'submenu' => [
                [
                    'text' => 'Asignar a Proyectos',
                    'url'  => 'roraima/asignar-proyectos',
                ],
                [
                    'text' => 'Asignar a Accion Centralizada',
                    'url'  => 'roraima/asignar-acciones',
                ],
            ]
        ],

       [
            'text' => 'Solicitudes',
            'topnav' => true,
            'classes' => 'opciones-roraima',
            'submenu' => [
                [
                    'text' => 'Proyectos Requerimientos',
                    'url'  => 'roraima/proyectos-requerimientos',
                ],
                [
                    'text' => 'ACC Requerimientos',
                    'url'  => 'roraima/acc-requerimientos',
                ],
            ]
        ], 

       [
            'text' => 'Variables',
            'topnav' => true,
            'classes' => 'opciones-roraima',
            'submenu' => [
                [
                    'text' => 'Proyecto',
                    'url'  => 'roraima/variables/proyectos',
                ],
                [
                    'text' => 'Accion Centralizada',
                    'url'  => 'roraima/variables/acciones',
                ],
                [
                    'text' => 'Reportes Planificación',
                    'url'  => 'roraima/variables/reportes',
                ],
            ]
        ], 

       





        [
            'text' => 'Formatos',
            'url' => '/formatos',
            'icon' => 'fas fa-fw bi-aspect-ratio',
        ],

        [
            'text' => 'Notificación de Ausencia',
            'topnav' => true,
            'url' => '/formatos/notificacion-ausencia',
            'classes' => 'opciones-formatos',
        ],

        [
            'text' => 'Solicitud de Permiso',
            'topnav' => true,
            'url' => '/formatos/solicitud-permiso',
            'classes' => 'opciones-formatos',
        ],
        
        [
            'text' => 'Solicitud de Vacaciones',
            'topnav' => true,
            'url' => '/formatos/solicitud-vacaciones',
            'classes' => 'opciones-formatos',
        ],



        
        [
            'text' => 'Registrar',
            'topnav' => true,
            'icon' => 'fas fa-fw',
            'classes' => 'opciones-ccombatiente',
            'url'  => '/ccombatiente/registrar',
            //     /* 'submenu' => [
            //         [
            //             'text' => 'Registrar',
            //             'url'  => '/ccombatiente/registrar',
            //         ],
            //         [
            //             'text' => 'Reportes',
            //             'url'  => 'ccombatiente-reportes',
            //         ],
            //     ], */
        ],
        [
            'text' => 'Reportes',
            'topnav' => true,
            'icon' => 'fas fa-fw',
            'classes' => 'opciones-ccombatiente',
            'url'  => '/ccombatiente/reporte',
        ],
        [
            'text' => 'Mantenimiento',
            'topnav' => true,
            'url' => '#ccombatiente-mantenimiento',

            'icon' => 'fas fa-fw',
            'classes' => 'opciones-ccombatiente',
            'submenu' => [
                [
                    'text' => 'Catalogos',
                    'icon' => 'fas fa-fw',
                    'classes' => 'opciones-ccombatiente',
                    'submenu' => [
                        [
                            'text' => 'Comuna',
                            'url'  => '/ccombatiente/mantenimiento/catalogos/comunas',
                            'icon' => 'fas fa-fw',
                        ],
                        [
                            'text' => 'Rango',
                            'url'  => '/ccombatiente/mantenimiento/catalogos/registro-rango',
                            'icon' => 'fas fa-fw',
                        ],
                    ],
                ],
                [
                    'text' => 'Usuarios',
                    'url'  => '/ccombatiente/mantenimiento/usuarios',
                    'icon' => 'fas fa-fw',
                ],
            ]
        ],
        //PERFIL
        [
            'text' => 'Actualizar Datos',
            'topnav' => true,
            'url'  => '/perfil/actualizar-datos',
        ],
        [
            'text' => 'Cambiar Contraseña',
            'topnav' => true,
            'url'  => '/perfil/contrasena-3',
        ],
        [
            'text' => 'Preguntas Seguridad',
            'topnav' => true,
            'url'  => '/perfil/preguntas-seguridad',
        ],


        /*  [
            'text' => 'Almacén',
            'url' => '/almacen',
            'icon' => 'fas fa-fw fa-lock',
        ], */
        /*  [
            'text' => 'important',
            'icon_color' => 'red',
            'url' => '#',
        ],
        [
            'text' => 'warning',
            'icon_color' => 'yellow',
            'url' => '#',
        ],
        [
            'text' => 'information',
            'icon_color' => 'cyan',
            'url' => '#',
        ], */

        // [
        //     'text' => 'C.N. Constituyente',
        //     'url' => '/cnconstituyente',
        //     'icon' => 'bi bi-buildings-fill',
        // ],

        // [
        //     'text' => 'Registrar',
        //     'topnav' => true,
        //     'icon' => 'fas fa-fw',
        //     'classes' => 'opciones-cnconstituyente',
        //     'url'  => '/cnconstituyente/registrar',
        //     /* 'submenu' => [
        //         [
        //             'text' => 'Registrar',
        //             'url'  => '/ccombatiente/registrar',
        //         ],
        //         [
        //             'text' => 'Reportes',
        //             'url'  => 'ccombatiente-reportes',
        //         ],
        //     ], */
        // ],

        [
            'text'    => 'Cerrar Sesión',
            'icon'    => 'fas fa-fw fa-sign-out-alt',
            'url'     => 'salir',
            'topnav_right' => true,

        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
        App\Menu\Filters\ModulosFilter::class,
        App\Menu\Filters\ModulosPagosFilter::class,
        App\Menu\Filters\PerfilFilter::class,
        App\Menu\Filters\RoraimaFilter::class,
        App\Menu\Filters\FormatosFilter::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */
    // config/adminlte.php



    'extra_css' => [
        // La ruta es la única cadena necesaria aquí
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
        'iconos/bootstrap-icons.min.css',
        'css/estilos.css',

        // Si tuvieras otro archivo, simplemente añades otra cadena:
        // 'vendor/otro_plugin/otro.css', 
    ],

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                ['type' => 'js', 'asset' => false, 'location' => 'https://cdn.datatables.net/2.0.7/js/dataTables.min.js'],
                ['type' => 'js', 'asset' => false, 'location' => 'https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.min.js'],
                ['type' => 'css', 'asset' => false, 'location' => 'https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.min.css'],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@11',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Custom' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'css/custom.css',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
