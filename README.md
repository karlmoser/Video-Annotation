# Annotated.io Capstone Project

## Installation
This project uses Vagrant, a virtual machine management tool, and Chef, a provisioning tool, to create its development environment. To begin using this project, you will need to install Vagrant and Chef separately. Chef is installed as a Ruby gem, and Vagrant requires that Virtualbox is installed, which is a free virtual machine program. You may download these here:
```
https://www.vagrantup.com/downloads.html
https://www.virtualbox.org/wiki/Downloads
```

### OSX
OSX comes with Ruby pre-installed, which makes it easy to download the chef and librarian gems. Simply use the following commands:
```
gem install knife-solo --no-ri --no-rdoc
gem install librarian-chef --no-ri --no-rdoc
```

Then, to install the Chef cookbooks:
```
cd /path/to/root/of/project
librarian-chef install
```

Finally, to bring the VM up:
```
vagrant up
```

### Windows
Windows is more complicated than OSX because Ruby doesn't come pre-installed, but it isn't that much more difficult. You will need to first download and install Ruby and the Ruby Development Kit (if you don't already have them) from http://rubyinstaller.org/downloads/.

Then, install chef and librarian-chef by the commands:
```
gem install knife-solo --no-ri --no-rdoc
gem install librarian-chef --no-ri --no-rdoc
```

Next, install the Chef cookbooks:
```
cd \path\to\root\of\project
librarian-chef install
```
Finally, bring up the VM with:
```
vagrant up
```

## Using the Development Environment
To check if your development environment is working, go to a web browser and load the address 192.168.33.10. You should see a phpinfo() page to confirm that the VM is up and running.

### Grunt
This project uses NPM + Grunt to manages its packages and workflow automation. Currently, the project only uses Grunt for Sass, but in the future it will likely be used for JavaScript minification as well. To begin with Grunt, navigate to the `/web` directory, and issue the command:

``` sudo npm install ```

This will install all of the packages and their dependencies. Then, to start grunt-watch, type:

```grunt watch```

This will watch your .scss files for changes, and re-compile the .css files on saves.
