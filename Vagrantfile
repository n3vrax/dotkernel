# -*- mode: ruby -*-
# vi: set ft=ruby :

@script = <<SCRIPT
SHARED_DOCUMENT="/var/www/dotkernel.local"
DOCUMENT_ROOT="/var/www/dotkernel.local/public"
DB_USER=root
DB_PASS=1234
sudo apt-get update
sudo apt-get install -y git curl httpie autoconf libcurl4-openssl-dev python-docutils
sudo apt-get install -y libt1-dev libgmp-dev bison
sudo apt-get install -y libxml2-dev libssl-dev libbz2-dev libjpeg-dev libpng-dev libfreetype6-dev
sudo apt-get install -y libpspell-dev librecode-dev libmcrypt-dev

sudo ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/include/gmp.h

#install LAMP stack
echo "installing LAMP stack..."
sudo apt-get install -y apache2-mpm-prefork apache2-prefork-dev

wget http://ro1.php.net/get/php-7.0.0.tar.gz/from/this/mirror
mv mirror php7.0.0.tar.gz
tar -xvzf php7.0.0.tar.gz
cd php-7.0.0

sh -c "./configure --enable-mbstring --enable-zip --enable-bcmath --enable-pcntl --enable-ftp --enable-exif --enable-calendar --enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-wddx --with-curl --with-mcrypt --with-iconv --with-gmp --with-pspell --with-gd --with-jpeg-dir --with-png-dir --with-zlib-dir --with-xpm-dir --with-freetype-dir --enable-gd-native-ttf --enable-gd-jis-conv --with-openssl --with-pdo-mysql --with-gettext --with-zlib --with-bz2 --with-recode --with-apxs2"

make
sudo make install

sudo cp php.ini-development /usr/local/lib/php.ini
sudo sed -i "s/;opcache.enable=.*/zend_extension=opcache.so\\nopcache.enable=1/" /usr/local/lib/php.ini
sudo sed -i "s/;opcache.enable_cli=.*/opcache.enable_cli=1/" /usr/local/lib/php.ini

debconf-set-selections <<< 'mysql-server mysql-server/root_password password 1234'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password 1234'

sudo apt-get install -y mysql-server mysql-client

#setup database
mysqladmin -u$DB_USER -p$DB_PASS drop -f dotkernel
mysqladmin -u$DB_USER -p$DB_PASS create dotkernel
mysql -u$DB_USER -p$DB_PASS dotkernel < /vagrant/data/db/dotkernel.sql

sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

sudo touch /etc/apache2/mods-enabled/php7.conf
sudo cat > /etc/apache2/mods-enabled/php7.conf <<EOF
<FilesMatch ".+\.ph(p[345]?|t|tml)$">
    SetHandler application/x-httpd-php
</FilesMatch>
<FilesMatch ".+\.phps$">
    SetHandler application/x-httpd-php-source
    # Deny access to raw php sources by default
    # To re-enable it's recommended to enable access to the files
    # only in specific virtual host or directory
    Order Deny,Allow
    Deny from all
</FilesMatch>
# Deny access to files without filename (e.g. '.php')
<FilesMatch "^\.ph(p[345]?|t|tml|ps)$">
    Order Deny,Allow
    Deny from all
</FilesMatch>

# Running PHP scripts in user directories is disabled by default
#
# To re-enable PHP in user directories comment the following lines
# (from <IfModule ...> to </IfModule>.) Do NOT set it to On as it
# prevents .htaccess files from disabling it.
<IfModule mod_userdir.c>
    <Directory /home/*/public_html>
        php_admin_flag engine Off
    </Directory>
</IfModule>
EOF

#install composer globally
sudo curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

#move our vhost conf file and enable it in apache2
sudo cp $SHARED_DOCUMENT/provisioning/ports.conf /etc/apache2/ports.conf

echo "enabling vhost..."
sudo cp $SHARED_DOCUMENT/provisioning/dotkernel.local.conf /etc/apache2/sites-available/dotkernel.local.conf

sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf

sudo a2enmod rewrite
sudo a2dismod mpm_event
sudo a2enmod mpm_prefork
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

#install redis
echo 'installing redis-server...'
sudo apt-get install -y redis-server
sudo service redis-server restart

#install jenkins
#install openjdk first
echo 'installing openjdk-7...'
sudo apt-get install -y openjdk-7-jre
sudo apt-get install -y openjdk-7-jdk

#echo 'installing jenkins...'
wget -q -O - https://jenkins-ci.org/debian/jenkins-ci.org.key | sudo apt-key add -
sudo sh -c 'echo deb http://pkg.jenkins-ci.org/debian binary/ > /etc/apt/sources.list.d/jenkins.list'
sudo apt-get update
sudo apt-get install -y jenkins

#echo 'installing varnish...'
sudo apt-get install apt-transport-https
sudo curl https://repo.varnish-cache.org/GPG-key.txt | sudo apt-key add -
sudo echo "deb https://repo.varnish-cache.org/ubuntu/ trusty varnish-4.1" >> /etc/apt/sources.list.d/varnish-cache.list
sudo apt-get update
sudo apt-get install -y varnish

sudo cp $SHARED_DOCUMENT/provisioning/varnish /etc/default/varnish

sudo cp $SHARED_DOCUMENT/provisioning/default.vcl /etc/varnish/default.vcl

#echo 'installing vagent2...'
sudo apt-get install -y libvarnishapi-dev libmicrohttpd-dev pkg-config
mkdir /home/vagrant/vagent2
git clone https://github.com/varnish/vagent2.git /home/vagrant/vagent2

cd /home/vagrant/vagent2

./autogen.sh
./configure
make
sudo make install

sudo ln -s /usr/local/bin/varnish-agent /usr/bin/varnish-agent

sudo mkdir -p /usr/local/etc/varnish
echo 'admin:1234' | sudo tee /usr/local/etc/varnish/agent_secret > /dev/null
sudo cp /home/vagrant/vagent2/debian/init /etc/init.d/varnish-agent
sudo chmod +x /etc/init.d/varnish-agent

sudo update-rc.d varnish-agent defaults

sudo service varnish restart
sudo service varnish-agent start

SCRIPT

Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"
  
  config.vm.provider "virtualbox" do |vb|
     # Display the VirtualBox GUI when booting the machine
     vb.gui = false
  
     # Customize the amount of memory on the VM:
     vb.memory = "1024"
   end

  config.vm.network "private_network", ip: "192.168.34.10"

  config.vm.synced_folder "./", "/var/www/dotkernel.local"

  config.vm.provision "shell", inline: @script

end
