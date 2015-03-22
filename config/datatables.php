<?php

return array(

    'search' => array(
        'case_insensitive' => true,
        'use_wildcards' => false,
    ),
    'default' => array(
        'options' => array(
            'searchDelay' => 1000,
            'processing' => false,
            'serverSide' => true,
            'stateSave' => true,
            'responsive' => true,
            'autoWidth' => false,
        ),
        'callbacks' => array(),
    ),
    'views' => array(
        'template' => 'admin::datatable.template',
        'javascript' => 'admin::datatable.javascript',
        'statusButtons' => 'admin::datatable.status_buttons',
        'actionButtons' => 'admin::datatable.action_buttons',
    ),

);

