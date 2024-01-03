<?php

return [

    /*
     *
     * Shared translations.
     *
     */
    'title' => 'Basma Resume Installer',
    'next' => 'Next Step',
    'back' => 'Previous',
    'finish' => 'Install',
    'forms' => [
        'errorTitle' => 'The Following errors occurred:',
    ],
    'validation' => [
        'required' => 'The field is required.',
        'string' => 'The must be a string.',
        'email' => 'The must be a valid email address.',
        'max' => 'The must not be greater than :max characters.',
        'numeric' => 'The must be a number.',
        'url' => 'The format is invalid.',
    ],

    /*
     *
     * Home page translations.
     *
     */
    'welcome' => [
        'templateTitle' => 'Welcome',
        'title'   => 'Basma Resume Installer',
        'message' => 'Easy Installation and Setup Wizard.',
        'next'    => 'Check Requirements',
    ],

    /*
     *
     * Requirements page translations.
     *
     */
    'requirements' => [
        'templateTitle' => 'Step 1 | Server Requirements',
        'title' => 'Server Requirements',
        'next'    => 'Check Permissions',
    ],

    /*
     *
     * Permissions page translations.
     *
     */
    'permissions' => [
        'templateTitle' => 'Step 2 | Permissions',
        'title' => 'Permissions',
        'next' => 'Configure Environment',
    ],

    /*
     *
     * Environment page translations.
     *
     */
    'environment' => [
        'menu' => [
            'templateTitle' => 'Step 3 | Environment Settings',
            'title' => 'Environment Settings',
            'desc' => 'Please select how you want to configure the apps <code>.env</code> file.',
        ],
        'wizard' => [
            'templateTitle' => 'Step 3 | Environment Settings | Guided Wizard',
            'title' => 'Guided <code>.env</code> Wizard',
            'tabs' => [
                'environment' => 'Environment',
                'database' => 'Database',
                'application' => 'Application',
            ],
            'form' => [
                'show_more' => 'Show More',
                'hide_more' => 'Hide More',
                'name_required' => 'An environment name is required.',
                'app_name_label' => 'App Name',
                'app_name_placeholder' => 'App Name',                
                'app_url_label' => 'App Url',
                'app_url_placeholder' => 'App Url',
                'app_lang_label' => 'Language',
                'db_connection_failed' => 'Could not connect to the database.',
                'db_connection_label' => 'Database Connection',
                'db_connection_label_mysql' => 'mysql',
                'db_connection_label_sqlite' => 'sqlite',
                'db_connection_label_pgsql' => 'pgsql',
                'db_connection_label_sqlsrv' => 'sqlsrv',
                'db_host_label' => 'Database Host',
                'db_host_placeholder' => 'Database Host',
                'db_port_label' => 'Database Port',
                'db_port_placeholder' => 'Database Port',
                'db_name_label' => 'Database Name',
                'db_name_placeholder' => 'Database Name',
                'db_username_label' => 'Database User Name',
                'db_username_placeholder' => 'Database User Name',
                'db_password_label' => 'Database Password',
                'db_password_placeholder' => 'Database Password',
                'app_license_label' => 'License Code',
                'app_license_placeholder' => 'Enter your purchase/license code',
                'app_client_label' => 'Envato Username',
                'app_client_placeholder' => 'Enter your name/envato username',
                'table_prefix_label' => 'Table Prefix',
                'table_prefix_placeholder' => 'Enter Table Prefix ex: phm_',
                'buttons' => [
                    'setup_database' => 'Setup Database',
                    'setup_application' => 'Setup Application',
                    'install' => 'Install',
                ],
            ],
        ],
        'success' => 'Your .env file settings have been saved.',
        'errors' => 'Unable to save the .env file, Please create it manually.',
    ],

    /*
     *
     * Admin page translations.
     *
     */
    'admin' => [
        'menu' => [
            'templateTitle' => 'Step 4 | Admin Settings',
            'title' => 'Admin Settings',
        ],
        'wizard' => [
            'templateTitle' => 'Step 4 | Administrator data',
            'title' => 'Administrator data',
            'tabs' => [
                'admin' => 'Admin',
            ],
            'form' => [
                'admin_username_label' => 'Admin Username',
                'admin_username_placeholder' => 'Enter Admin Username',
                'admin_email_label' => 'Admin Email',
                'admin_email_placeholder' => 'Enter Admin Email',
                'admin_password_label' => 'Admin Password',
                'admin_password_placeholder' => 'Enter Admin Password',
                'admin_pincode_label' => 'Admin PIN Code',
                'admin_pincode_placeholder' => 'Enter Admin PIN Code',
                'buttons' => [
                    'submit' => 'Submit'
                ],
            ],
        ]
    ],

    /*
     *
     * administrator Log translations.
     *
     */
    'administrator' => [
        'success_message' => 'The administrator has been added successfully.',
    ],

    /*
     *
     * Final page translations.
     *
     */
    'final' => [
        'title' => 'Installation Finished',
        'templateTitle' => 'Installation Finished',
        'finished' => 'Application has been successfully installed.',
        'website' => 'Web Site',
        'dashboard' => 'Dashboard'
    ],

    /*
     *
     * Update specific translations
     *
     */
    'updater' => [
        /*
         *
         * Shared translations.
         *
         */
        'title' => 'Laravel Updater',

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'welcome' => [
            'title'   => 'Welcome To The Updater',
            'message' => 'Welcome to the update wizard.',
        ],

        /*
         *
         * Welcome page translations for update feature.
         *
         */
        'overview' => [
            'title'   => 'Overview',
            'message' => 'There is 1 update.|There are :number updates.',
            'install_updates' => 'Install Updates',
        ],

        /*
         *
         * Final page translations.
         *
         */
        'final' => [
            'title' => 'Finished',
            'finished' => 'Application\'s database has been successfully updated.',
            'exit' => 'Click here to exit',
            'website' => 'Web Site',
            'admin' => 'Admin',
        ],

        'log' => [
            'success_message' => 'Installer successfully UPDATED on ',
        ],
    ],

    

    'licenses' => [
        'invalid_response' => 'Server returned an invalid response, please contact support.',
        'verified_response' => 'Verified! Thanks for purchasing.',
        'connection_failed' => 'Server is unavailable at the moment, please try again.',
        'preparing_main_download' => 'Preparing to download main update...',
        'main_update_size' => 'Main Update size:',
        'dont_refresh' => '(Please do not refresh the page).',
        'downloading_main' => 'Downloading main update...',
        'update_period_expired' => 'Your update period has ended or your license is invalid, please contact support.',
        'update_path_error' => 'Folder does not have write permission or the update file path could not be resolved, please contact support.',
        'main_update_done' => 'Main update files downloaded and extracted.',
        'update_extraction_error' => 'Update zip extraction failed.',
        'preparing_sql_download' => 'Preparing to download SQL update...',
        'sql_update_size' => 'SQL Update size:',
        'downloading_sql' => 'Downloading SQL update...',
        'sql_update_done' => 'SQL update files downloaded.',
        'update_with_sql_import_failed' => 'Application was successfully updated but automatic SQL importing failed, please import the downloaded SQL file in your database manually.',
        'update_with_sql_import_done' => 'Application was successfully updated and SQL file was automatically imported.',
        'update_with_sql_done' => 'Application was successfully updated, please import the downloaded SQL file in your database manually.',
        'update_without_sql_done' => 'Application was successfully updated, there were no SQL updates.',
    ],

    



];
