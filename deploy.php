<?php
namespace Deployer;

require 'recipe/laravel.php';
require 'contrib/php-fpm.php';
require 'contrib/npm.php';

set('composer_options', '--verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');
set('php_fpm_version', '8.0');
set('git_tty', true);

host('production')
    ->set('remote_user', 'forge')
    ->set('application', 'appointment')
    ->set('repository', 'git@github.com:k0nstantin777/appointment.git')
    ->set('hostname', 'appointment.knoskov.ru')
    ->set('deploy_path', '/var/www/{{hostname}}');

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:view:clear',
    'artisan:config:clear',
    'artisan:migrate',
    'npm:install',
    'npm:run:prod',
    'testdb:create',
    'deploy:publish',
]);

task('rollback', [
    'artisan:migrate:rollback',
]);

task('refresh:environment', [
    'artisan:queue:restart',
    'php-fpm:reload'
]);

task('npm:run:dev', function () {
    cd('{{release_or_current_path}}');
    run('npm run dev');
});

task('npm:run:prod', function () {
    cd('{{release_or_current_path}}');
    run('npm run prod');
});

task('testdb:create', function () {
    cd('{{release_or_current_path}}');
    run('touch database/test.sqlite');
});

after('deploy:failed', 'deploy:unlock');

after('deploy', 'refresh:environment');

after('rollback', 'refresh:environment');
