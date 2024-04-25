# config valid for current version and patch releases of Capistrano
lock "~> 3.18.1"

set :application, "imaratv-dash"
set :repo_url, "git@github.com:anselmelly/imaraTV_v1.git"

# Default branch is :main
ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, "/var/www/imaratv-dash"

set :ssh_options, { 
  forward_agent: true, 
  keys: "~/.ssh/id_rsa" 
}

set :stages, ["staging", "production"]

# Shared paths/files
set :linked_dirs, [
    "storage/app",
    "storage/framework/cache",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/framework/laravel-excel",
    "storage/logs"
]

set :keep_releases, 2

namespace :deploy do
    
    desc "Build"
    after :updated, :build do
        on roles(:app) do
            within release_path  do
		stage = fetch(:stage)
                execute :composer, "update --no-dev" # install dependencies
		execute :chmod, "u+x artisan" # make artisan executable
		upload! ".env.#{stage}", "#{release_path}/.env"
		execute :php, "artisan migrate --force --env=#{fetch(:stage)}"
		execute :php, "artisan storage:link"
		execute :php, "artisan cache:clear"
		execute :php, "artisan route:clear"
		execute :php, "artisan view:clear"
		execute :php, "artisan optimize:clear"
		execute :chown, "-R www-data:www-data #{deploy_to}"
            end
        end
    end
    desc "Restart"
    task :restart do
        on roles(:app) do
            within release_path  do
		execute :chmod, "-R 777 shared/storage/cache"
                execute :chmod, "-R 777 shared/storage/logs"
                execute :chmod, "-R 777 shared/storage/meta"
                execute :chmod, "-R 777 shared/storage/sessions"
                execute :chmod, "-R 777 shared/storage/views"
            end
        end
    end
end