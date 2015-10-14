# -*- mode: ruby -*-
# vi: set ft=ruby :

@script = <<SCRIPT
SHARED_DOCUMENT="/var/www/dotkernel.local"
DOCUMENT_ROOT="/var/www/dotkernel.local/public"
DB_USER="root"
DB_PASS="1234"
sudo apt-get update
sudo apt-get install -y git curl httpie autoconf libcurl4-openssl-dev python-docutils

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
sudo cp $SHARED_DOCUMENT/provisioning/ports.conf /etc/apache2/ports.conf

echo "enabling vhost..."
sudo cp $SHARED_DOCUMENT/provisioning/dotkernel.local.conf /etc/apache2/sites-available/dotkernel.local.conf

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

sudo cp $SHARED_DOCUMENT/provisioning/varnish /etc/default/varnish

sudo cp $SHARED_DOCUMENT/provisioning/default.vcl /etc/varnish/default.vcl

echo 'installing vagent2...'
sudo apt-get install -y libvarnishapi-dev libmicrohttpd-dev pkg-config
mkdir /home/vagrant/vagent2
git clone https://github.com/varnish/vagent2.git /home/vagrant/vagent2

cd /home/vagrant/vagent2

./autogen.sh
./configure
make
sudo make install

sudo ln -s /usr/local/bin/varnish-agent /usr/bin/varnish-agent

echo 'admin:1234' | sudo tee /etc/varnish/agent_secret > /dev/null
sudo cp /home/vagrant/vagent2/debian/init /etc/init.d/varnish-agent
sudo chmod +x /etc/init.d/varnish-agent

sudo update-rc.d varnish-agent defaults

sudo service varnish restart
sudo service varnish-agent start

SCRIPT

Vagrant.configure(2) do |config|

  config.vm.box = "ubuntu/trusty64"

  config.vm.network "private_network", ip: "192.168.34.10"

  config.vm.synced_folder "./", "/var/www/dotkernel.local"

  config.vm.provision "shell", inline: @script

end
