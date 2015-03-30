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
            'stateSave' => false,
            'responsive' => true,
            'autoWidth' => false,
        ),
        'callbacks' => array(),
    ),
    'views' => array(
        'template' => 'admin::datatables.template',
        'javascript' => 'admin::datatables.javascript',
        'statusButtons' => 'admin::datatables.status_buttons',
        'actionButtons' => 'admin::datatables.action_buttons',
        'transButtons' => 'admin::datatables.trans_buttons',
    ),

);

