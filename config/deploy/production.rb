server '143.198.197.60', user: 'root', roles: %w{web app laravel composer}

set :app_version, "#{fetch(:svn_revision)}"
set :current_revision, "#{fetch(:svn_revision)}"

# set :nvm_custom_path, "/home/deploy/.nvm/versions/node"
# set :default_env, 'PATH' => "/home/deploy/.nvm/versions/node/v20.6.1/bin:$PATH"
# set :nvm_path, "/home/deploy/.nvm"
# set :ssh_options, {:forward_agent => true}
set :php_version, "php8.3"