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
Windows is more complicated than OSX because Ruby doesn't come pre-installed. You will need to first download and install Ruby and the Ruby Development Kit (if you don't already have them) from http://rubyinstaller.org/downloads/. Both Ruby and the Ruby Development Kit should be for the same version of Windows. We recommend using the 32-bit Ruby-2.2.X installers for both. Additionally the instructions for installing the Ruby Development Kit can be found at https://github.com/oneclick/rubyinstaller/wiki/Development-Kit.

After installing Ruby and the Ruby Development Kit, make sure that Ruby is correctly linked to the PATH variables of your Windows command prompt, which is found within your Windows environment variables. Additionally, to be able to install the Ruby gems necessary for our project, such as Chef, you will need a valid OpenSSL certificate for Ruby which is not included with Windows, so we must download it. The OpenSSL certificate we used can be found at https://curl.haxx.se/ca/cacert.pem. Your Windows environment variables should have the correct PATH user variable for your ruby install, as well as the SSL\_CERT\_FILE user variable which points to the cacert.pem OpenSSL certificate. The following screenshot shows how to include the PATH and SSL certificate to your Windows environment variables.

![ScreenShot](https://raw.github.com/karlmoser/Video-Annotation/master/screenshots/1.png)

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
To check if your development environment is working, go to a web browser and load the address 192.168.33.10. You should see the homepage of our website. To be able to navigate past the homepage you must modify your computer's host file as described in the following section.

### Host File Setup
For both Windows and OSX, the application thinks that it lives at the domain "annotated.io". Using your computer's hosts file, you can spoof this domain for your localhost. Add the following entry into your computer's hosts file:
```
192.168.33.10		annotated.io
```


### Grunt
This project uses NPM + Grunt to manages its packages and workflow automation. Currently, the project only uses Grunt for Sass, but in the future it will likely be used for JavaScript minification as well. To begin with Grunt, navigate to the `/web` directory, and issue the command:
```
sudo npm install 
```
This will install all of the packages and their dependencies. Then, to start grunt-watch, type:
```
grunt watch
```
This will watch your .scss files for changes, and re-compile the .css files on saves.

## Website Screenshots
todo
