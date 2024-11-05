<?php
return [
    'configuracoes_gerais' => [
        'title' => 'Configurações Gerais',
        'icon' => 'cogs',
        'route' => '',
        'sub_menu' => [

            // 'cadastro_de_perfis' => [
            //     'title' => 'Cadastro de Perfis',
            //     'icon' => 'caret-right',
            //     'sub_menu' => [],
            //     'page' => 'perfil'
            // ],
            'cadastro_de_usuarios' => [
                'title' => 'Cadastro de Usuários',
                'icon' => 'caret-right',
                'sub_menu' => [],
                'page' => 'app.usuario.index'
            ],
        ]
    ],
];
