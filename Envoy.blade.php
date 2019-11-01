@servers(['web' => 'deployer@njujb.com'])

@setup
    $repository = 'git@git.doowzs.com:doowzs/jb-online.git';
    $releases_dir = '/var/www/app/releases';
    $app_dir = '/var/www/app';
    $release = date('YmdHis');
    $new_release_dir = $releases_dir .'/'. $release;
@endsetup

@story('deploy')
    clone_repository
    update_symlinks
    run_composer
    run_webpack_mix
    finish_up
@endstory

@task('clone_repository')
    echo 'Cloning repository'
    [ -d {{ $releases_dir }} ] || mkdir {{ $releases_dir }}
    git clone --depth 1 {{ $repository }} {{ $new_release_dir }}
    cd {{ $new_release_dir }}
    git reset --hard {{ $commit }}
@endtask

@task('update_symlinks')
    echo "Linking storage directory"
    rm -rf {{ $new_release_dir }}/storage
    ln -nfs {{ $app_dir }}/storage {{ $new_release_dir }}/storage

    echo 'Linking .env file'
    ln -nfs {{ $app_dir }}/.env {{ $new_release_dir }}/.env

    echo 'Linking assets folders'
    ln -nfs {{ $app_dir }}/assets/css {{ $new_release_dir }}/public/css
    ln -nfs {{ $app_dir }}/assets/js {{ $new_release_dir }}/public/js
    ln -nfs {{ $app_dir }}/assets/webfonts {{ $new_release_dir }}/public/webfonts
@endtask

@task('run_composer')
    echo "Starting deployment ({{ $release }})"
    cd {{ $new_release_dir }}
    composer install --no-interaction --prefer-dist --no-progress -o
@endtask

@task('run_webpack_mix')
    echo "Generating stylesheets and scripts ({{ $release }})"
    cd {{ $new_release_dir }}
    yarn install
    yarn run prod
@endtask

@task('finish_up')
    echo 'Linking current release ({{ $release }})'
    ln -nfs {{ $new_release_dir }} {{ $app_dir }}/current
@endtask
