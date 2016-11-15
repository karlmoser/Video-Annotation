#
# Cookbook Name:: annotated.io
# Recipe:: default
#
# Copyright 2016, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#

include_recipe 'build-essential::default'
mysql2_chef_gem 'default' do
  action :install
end

# Configure the MySQL service.
mysql_service 'default' do
  initial_root_password 'peanutbutter'
  bind_address '0.0.0.0'
  port '3306'
  action [:create, :start]
end

# Add the Apache site configuration.
apache_conf 'annotated.io' do
  enable true
end

mysql_database 'annotations' do
  connection(
    :host => '127.0.0.1',
    :username => 'root',
    :password => 'peanutbutter'
    )
  action :create
end

cookbook_file '/tmp/create-tables.sql' do
  source 'create-tables.sql'
  owner 'root'
  group 'root'
  mode '0600'
end

cookbook_file '/tmp/open-database.sql' do
  source 'open-database.sql'
  owner 'root'
  group 'root'
  mode '0600'
end

execute 'open database' do
  command "mysql -h 127.0.0.1 -u root -ppeanutbutter < /tmp/open-database.sql"
end

execute 'initialize database' do
  command "mysql -h 127.0.0.1 -u root -ppeanutbutter -D annotations < /var/www/web/db/schema.sql"
end

# Seed the database with a table and test data.
# execute 'initialize database' do
#   command "mysql -h 127.0.0.1 -u root -ppeanutbutter -D annotations < templates/default/seed.db.sql"
# end

# Enable PHP5 Module
apache_module "php5" do
    filename "libphp5.so"
end

package "php-mysql" do
  action :install
end