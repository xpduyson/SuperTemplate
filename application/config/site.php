<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Site (by CI Bootstrap 3)
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views when calling 
| MY_Controller's render() function. 
|
| Each of them can be overrided from child controllers.
|
*/

$config['site'] = array(

    // Site name
    'name' => 'CMR System',

    // Default page title
    // (set empty then MY_Controller will automatically generate one based on controller / action)
    'title' => '',

    // Default meta data (name => content)
    'meta' => array(
        'author' => 'xpduyson',
        'description' => 'Course Monitor Report'
    ),

    // Default scripts to embed at page head / end
    'scripts' => array(
        'head' => array(
            'assets/dist/adminlte.min.js',
            'assets/dist/admin.min.js'
        ),
        'foot' => array(),
    ),

    // Default stylesheets to embed at page head
    'stylesheets' => array(
        'screen' => array(
            'assets/dist/adminlte.min.css',
            'assets/dist/admin.min.css'
        )
    ),

    // Multilingual settings (set empty array to disable this)
    'multilingual' => array(),

    // AdminLTE settings
    'adminlte' => array(
        'webmaster' => array('skin' => 'skin-black'),
        'PVC' => array('skin' => 'skin-green-light'),
        'DLT' => array('skin' => 'skin-blue-light'),
        'CL' => array('skin' => 'skin-red-light'),
        'CM' => array('skin' => 'skin-pink-light'),
        'guest' => array('skin' => 'skin-yellow-light')
    ),

    // Menu items which support icon fonts, e.g. Font Awesome
    // (or directly update view file: /application/modules/admin/views/_partials/sidemenu.php)
    'menu' => array(
        'home' => array(
            'name' => 'Home',
            'url' => '',
            'icon' => 'fa fa-home',
        ),
        'faculties' => array(
            'name' => 'Faculty',
            'url' => 'faculty',
            'icon' => 'glyphicon glyphicon-list-alt',
        ),
        'course' => array(
            'name' => 'Course',
            'url' => 'course',
            'icon' => 'glyphicon glyphicon-book',
        ),

        'cmr' => array(
            'name' => 'CMR',
            'url' => 'CMR',
            'children' => array(
                'View CMR' => 'cmr',
                'Add CMR' => 'cmr/Add',
            )
        ),
        'panel' => array(
            'name' => 'Admin Panel',
            'url' => 'panel',
            'icon' => 'fa fa-cog',
            'children' => array(
                'Admin Users' => 'panel/admin_user',
                'Create Admin User' => 'panel/admin_user_create',
                'Admin User Groups' => 'panel/admin_user_group',
            )
        ),
        'logout' => array(
            'name' => 'Sign Out',
            'url' => 'panel/logout',
            'icon' => 'fa fa-sign-out',
        )
    ),

    // default page when redirect non-logged-in user
    'login_url' => 'login',

    // restricted pages to specific groups of users, which will affect sidemenu item as well
    // pages out of this array will have no restriction (except required admin user login)
    'page_auth' => array(
        'panel' => array('webmaster'),
        'panel/admin_user' => array('webmaster'),
        'panel/admin_user_create' => array('webmaster'),
        'panel/admin_user_group' => array('webmaster'),
        'course' => array('PVC'),
        'cmr/Add' => array('CL'),
        'CMR' => array('PVC', 'DLT', 'CM', 'guest', 'CL'),
        'cmr' => array('PVC', 'DLT', 'CM', 'guest', 'CL')


    ),

    // Useful links to display at bottom of sidemenu (e.g. to pages outside Admin Panel)
    'useful_links' => array(
        array(
            'auth' => array('webmaster', 'PVC', 'DLT', 'CL', 'CM', 'guest'),
            'name' => 'Frontend Website',
            'url' => '',
            'target' => '_blank',
            'color' => 'text-aqua'
        ),

        array(
            'auth' => array('webmaster', 'PVC', 'DLT', 'CL', 'CM', 'guest'),
            'name' => 'Github Repo',
            'url' => CI_BOOTSTRAP_REPO,
            'target' => '_blank',
            'color' => 'text-green'
        ),
    ),

    // For debug purpose (available only when ENVIRONMENT = 'development')
    'debug' => array(
        'view_data' => FALSE,    // whether to display MY_Controller's mViewData at page end
        'profiler' => FALSE,    // whether to display CodeIgniter's profiler at page end
    ),
);