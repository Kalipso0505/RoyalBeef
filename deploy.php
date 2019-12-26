<?php
namespace Deployer;

require 'recipe/symfony4.php';

// Project name
set('application', 'RoyalBeef');

set('http_user', 'hosting133954');

set('writable_mode', 'chmod');

// Project repository
set('repository', 'https://github.com/Kalipso0505/RoyalBeef.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', ['public/gallery', 'public/zip', 'games']);

// Writable dirs by web server
add('writable_dirs', ['games']);
set('allow_anonymous_stats', false);

// Hosts

host('netcup')
    ->set('deploy_path', '/httpdocs/{{application}}')
    ->stage('production');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

task('prodEnv', function () {
    run('cd {{release_path}} && mv .env.prod .env');
});

after('deploy:shared', 'prodEnv');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

//before('deploy:symlink', 'database:migrate');

