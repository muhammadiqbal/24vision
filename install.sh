# This command/script is to be executed in linux environment
# Make sure that you have Python 3 and pip3 installed before executing the script.
# By default the latest version of ubuntu have Python and pip installed

# get update from repository
apt-get update

# install LAMPP stack
apt-get install git apache2 php7.0 libapache2-mod-php7.0 php7.0-opcache php-apcu

# install MySQL
# uncomment this line if you don't have MySQL installed
# apt-get -y install mysql-server mysql-client
# mysql_secure_installation

# Install composer as PHP dependancy maager 
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install anaconda for python dependancy manager
wget http://repo.continuum.io/archive/Anaconda3-5.1.0-Linux-x86_64.sh && bash Anaconda3-5.1.0-Linux-x86_64.sh

