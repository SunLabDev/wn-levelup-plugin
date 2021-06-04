<?php return [
    'settings' => [
        'experience_increasers' => [
            'name' => "Multiplicateur d'expérience",
            'description' => "Configurez quand et de combien les utilisateurs gagne de l'expérience",
        ],
        'levels' => [
            'name' => 'Niveaux',
            'description' => 'Configurez les niveaux à franchir',
        ]
    ],
    'fields' => [
        'level' => 'Niveau',
        'experience_needed' => 'Expérience nécessaire',
        'measure_name' => 'Nom de la mesure',
        'points' => 'Points',
    ],
    'components' => [
        'nb_users_to_display' => "Nb d'utilisateur à afficher",
        'leaderboard_description' => 'Affiche le top utilisateur',
        'experience_gauge' => "Barre d'expérience",
        'experience_gauge_description' => "Affiche la barre d'expérience d'un utilisateur",
        'user_id' => 'ID utilisateur',
        'user_id_description' => "Doit correspondre au paramètre de l'url",
        'logged_user' => "Pour l'utilisateur connecté",
        'logged_user_description' => "Affiche la barre d'expérience de l'utilisateur connecté",
    ],
    'errors' => [
        'conflictual_level' => "Sauvegarde impossible car le niveau :level nécessite :experience_needed points d'expérience",
        'level_one_cant_be_deleted' => "Le niveau un ne peut pas être supprimé"
    ]
];
