<h1>INSTALL PROJECT</h1>


<h2>PHP INSTALL</h2>

```
sudo install php
sudo apt install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update
sudo apt install php8.1
```


<h2>PHP EXTENSION INSTALL</h2>

```
sudo apt install php8.1-common php8.1-mysql php8.1-xml php8.1-xmlrpc php8.1-curl php8.1-gd php8.1-imagick php8.1-cli php8.1-dev php8.1-imap php8.1-mbstring php8.1-opcache php8.1-soap php8.1-zip php8.1-redis php8.1-intl -y
```


<h2>Composer Install</h2>

```
sudo apt install php-cli unzip
cd ~
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
HASH=`curl -sS https://composer.github.io/installer.sig`
php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
sudo php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
composer -V
cd uphold
composer install
composer update
```

<h2>Install Postgres</h2>

```
sudo apt install postgresql postgresql-contrib
```

Verificar se o serviço do Postgres está rodando:
```sudo systemctl status postgresql```

Setar senha para o usuário postgres:
```sudo passwd postgres```

Logar com o usuário postgres para que o console possa ser utilizado:
`sudo su - postgres`

psql -c "ALTER USER postgres WITH PASSWORD 'secure_password_here';" 
exit

`sudo systemctl restart postgresql`

Logar com o usuário postgres para que o console possa ser utilizado:
`sudo su - postgres`

`psql -f nome_do_arquivo_.sql`


<h2>Rodar as migrações</h2>


<p>Para rodar as migrações, é necessario abrir o arquivo dentro de app/Providers/AuthServiceProvider e comentar o foreach que esta dentro do metodo boot. Depois de comentar as linhas, executar dentro de ./uphold :
</p>

`php artisan migrate`

<p>Depois de rodar o comando, descomentar as linhas comentadas</p>

<h2>Rodar os seeds</h2>

`php artisan db:seed`

<h2>Configurar .ENV</h2>

<p>Renomear o arquivo .env.example para .env e configurar a conexão com o banco de dados</p>


<h2>Subir o Servidor</h2>

`php artisan serve`
