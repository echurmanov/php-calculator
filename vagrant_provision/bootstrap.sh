if [ -f "/.bootstrap.done" ]; then
    exit
fi

## Ставим необходимые пакеты

apt-get -y install php5 php5-json

rm /etc/apache2/sites-enabled/*
ln -s /vagrant/vagrant_provision/app.conf /etc/apache2/sites-enabled/app.conf

touch /.bootstrap.done