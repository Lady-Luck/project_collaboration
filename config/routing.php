<?php

    # Home
    \App\src\core\Router::add('DefaultController', 'home', '');
    \App\src\core\Router::add('DefaultController', 'home', 'home');

    # Login and logout
    \App\src\core\Router::add('SecurityController', 'login',  'login');
    \App\src\core\Router::add('SecurityController', 'logout',  'logout');
    \App\src\core\Router::add('SecurityController', 'register',  'register');

    \App\src\core\Router::add('SecurityController', 'registerMessage',  'register/success');

    # Verify email
    \App\src\core\Router::add('SecurityController', 'verify', 'verify/[a-z0-9+]');
    \App\src\core\Router::add('SecurityController', 'recovery', 'recovery/[a-z0-9+]');

    # Create Project
    \App\src\core\Router::add('ProjectController', 'newProject', 'project');

    \App\src\core\Router::add('ProjectController', 'myProjects', 'my_projects');

    # Create Job
    \App\src\core\Router::add('JobController', 'newJob', 'job/[\d]+');

    \App\src\core\Router::add('JobController', 'applyToJob', 'jobApply/[\d]+');

    # Project page
    \App\src\core\Router::add('ProjectController', 'project', 'project/[\d]+');

    \App\src\core\Router::add('ProjectController', 'inviteUserToCollaborateForm', 'inviteUserForm/[\d]+');
    \App\src\core\Router::add('ProjectController', 'inviteUserToCollaborate', 'inviteUser');

    # Upload video
    \App\src\core\Router::add('ProjectController', 'video', 'video');

    \App\src\core\Router::add('ApiController', 'invitationAcceptance', 'invitationAccept/[\d]+');





