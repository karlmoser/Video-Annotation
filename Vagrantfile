# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://atlas.hashicorp.com/search.
 
  config.vm.box = "bento/centos-7.1"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  
  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  
  config.vm.network "private_network", ip: "192.168.33.10"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  config.vm.synced_folder "web/", "/var/www/web"

  config.vm.provision "chef_solo" do |chef|
    chef.version = "12.10.40"
    chef.roles_path = "roles"
    chef.cookbooks_path = ["cookbooks", "site-cookbooks"]
    chef.add_role("web")
  end
end
