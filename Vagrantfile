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
echo "enabling vhost..."
echo "
<VirtualHost *:80>
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
SCRIPT

Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.synced_folder "./", "/var/www/dotkernel.local"

  config.vm.provision "shell", inline: @script

end
