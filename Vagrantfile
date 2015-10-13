# -*- mode: ruby -*-
# vi: set ft=ruby :

@script = <<SCRIPT
DOCUMENT_ROOT="/var/www/dotkernel.local/public"
DB_USER="root"
DB_PASS="1234"
sudo apt-get update
sudo apt-get install -y git curl

#install LAMP stack
echo "installing LAMP stack..."
sudo apt-get install -y apache2
debconf-set-selections <<< 'mysql-server mysql-server/root_password password 1234'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 1234'
sudo apt-get install -y mysql-server libapache2-mod-auth-mysql
sudo apt-get install -y php5 php5-mysql libapache2-mod-php5 php5-mcrypt php5-curl php5-cli php5-sqlite php5-intl

#install composer globally
sudo curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

#move our vhost conf file and enable it in apache2
sudo echo "
# If you just change the port or add more ports here, you will likely also
# have to change the VirtualHost statement in
# /etc/apache2/sites-enabled/000-default.conf

Listen 8888

<IfModule ssl_module>
        Listen 443
</IfModule>

<IfModule mod_gnutls.c>
        Listen 443
</IfModule>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
" > /etc/apache2/ports.conf

echo "enabling vhost..."
sudo echo "
<VirtualHost *:8888>
    ServerAdmin webmaster@localhost

    ServerName dotkernel.local
    ServerAlias www.dotkernel.local

    DocumentRoot $DOCUMENT_ROOT
    <Directory $DOCUMENT_ROOT>
      DirectoryIndex index.php
      AllowOverride All
      Order allow,deny
      Allow from all
    </Directory>
</VirtualHost>
" > /etc/apache2/sites-available/dotkernel.local.conf

sudo a2enmod rewrite
sudo a2dissite 000-default
sudo a2ensite dotkernel.local

sudo service apache2 restart

#ads vhost to hosts file to point to localhost
if ! grep -q "dotkernel.local" /etc/hosts; then
  echo "adding host to /etc/hosts..."
  sudo echo "127.0.0.1 dotkernel.local" >> /etc/hosts
fi

echo "installing composer dependencies..."
cd /var/www/dotkernel.local
composer install --no-progress

php public/index.php development enable

#setup database
mysqladmin -u$DB_USER -p$DB_PASS drop -f dotkernel
mysqladmin -u$DB_USER -p$DB_PASS create dotkernel
mysql -u$DB_USER -p$DB_PASS dotkernel < /vagrant/data/db/dotkernel.sql


#install jenkins
#install openjdk first
echo 'installing openjdk-7...'
sudo apt-get install -y openjdk-7-jre
sudo apt-get install -y openjdk-7-jdk

echo 'installing jenkins...'
wget -q -O - https://jenkins-ci.org/debian/jenkins-ci.org.key | sudo apt-key add -
sudo sh -c 'echo deb http://pkg.jenkins-ci.org/debian binary/ > /etc/apt/sources.list.d/jenkins.list'
sudo apt-get update
sudo apt-get install -y jenkins

echo 'installing varnish...'
sudo apt-get install apt-transport-https
sudo curl https://repo.varnish-cache.org/GPG-key.txt | sudo apt-key add -
sudo echo "deb https://repo.varnish-cache.org/ubuntu/ trusty varnish-4.1" >> /etc/apt/sources.list.d/varnish-cache.list
sudo apt-get update
sudo apt-get install -y varnish

sudo echo "
# Configuration file for Varnish Cache.
#
# /etc/init.d/varnish expects the variables $DAEMON_OPTS, $NFILES and $MEMLOCK
# to be set from this shell script fragment.
#
# Note: If systemd is installed, this file is obsolete and ignored.  You will
# need to copy /lib/systemd/system/varnish.service to /etc/systemd/system/ and
# edit that file.

# Should we start varnishd at boot?  Set to "no" to disable.
START=yes

# Maximum number of open files (for ulimit -n)
NFILES=131072

# Maximum locked memory size (for ulimit -l)
# Used for locking the shared memory log in memory.  If you increase log size,
# you need to increase this number as well
MEMLOCK=82000

DAEMON_OPTS="-a :80 \
             -T localhost:1234 \
             -f /etc/varnish/default.vcl \
             -S /etc/varnish/secret \
             -s malloc,256m"
" > /etc/default/varnish

echo "
#
# This is an example VCL file for Varnish.
#
# It does not do anything by default, delegating control to the
# builtin VCL. The builtin VCL is called when there is no explicit
# return statement.
#
# See the VCL chapters in the Users Guide at https://www.varnish-cache.org/docs/
# and https://www.varnish-cache.org/trac/wiki/VCLExamples for more examples.

# Marker to tell the VCL compiler that this VCL has been adapted to the
# new 4.0 format.
vcl 4.0;

# Default backend definition. Set this to point to your content server.
backend default {
    .host = "127.0.0.1";
    .port = "8888";
}

sub vcl_recv {
    # Happens before we check if we have this in cache already.
    #
    # Typically you clean up the request here, removing cookies you don't need,
    # rewriting the request, etc.
}

sub vcl_backend_response {
    # Happens after we have read the response headers from the backend.
    #
    # Here you clean the response headers, removing silly Set-Cookie headers
    # and other mistakes your backend does.
}

sub vcl_deliver {
    # Happens when we have all the pieces we need, and are about to send the
    # response to the client.
    #
    # You can do accounting or modifying the final object here.
}
" > /etc/varnish/default.vcl

sudo service varnish restart

SCRIPT

Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.synced_folder "./", "/var/www/dotkernel.local"

  config.vm.provision "shell", inline: @script

end
