<?php return [
    'settings' => [
        'experience_increasers' => [
            'name' => 'Experience Increasers',
            'description' => 'Configure how and how many users win experience',
        ],
        'levels' => [
            'name' => 'Levels',
            'description' => 'Configure levels cap',
        ]
    ],
    'fields' => [
        'level' => 'Level',
        'experience_needed' => 'Experience needed',
        'measure_name' => 'Measure name',
        'points' => 'Points',
    ],
    'components' => [
        'nb_users_to_display' => 'Nb users to display',
        'leaderboard_description' => 'Displays the most experienced users',
        'experience_gauge' => 'Experience Gauge',
        'experience_gauge_description' => "Displays a user's experience gauge",
        'user_id' => 'User id',
        'user_id_description' => 'Should match the url parameter',
        'logged_user' => 'On logged-in user',
        'logged_user_description' => 'Displays the logged-in user data',
    ],
    'errors' => [
        'conflictual_level' => "Can't save level because level :level needs :experience_needed",
        'level_one_cant_be_deleted' => "The level one can't be deleted"
    ]
];
