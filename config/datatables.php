<?php

return array(

    'search' => array(
        'case_insensitive' => true,
        'use_wildcards' => false,
    ),
    'default' => array(
        'options' => array(
            'searchDelay' => 1000,
            'processing' => true,
            'serverSide' => true,
            'stateSave' => true,
            'responsive' => true,
            'autoWidth' => false,
        ),
        'callbacks' => array(),
    ),
    'views' => array(
        'template' => 'admin.views.datatable.template',
        'javascript' => 'admin.views.datatable.javascript',
        'statusButtons' => 'admin.views.datatable.status_buttons',
        'actionButtons' => 'admin.views.datatable.action_buttons',
    ),

);

