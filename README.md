# exchange

How to execute it:

1) clone the repository:

git clone git@github.com:uilhamello/exchange.git

2) move to docker folder:
cd exchange/docker

3) rename sample.env to .env:
mv sample.env .env

4)
sudo chmod 755 -R logs data/mysql

5) execute composer install inside webservice folder
composer install

5) execute npm install inside website folder
composer install

4) execute docker-compose
docker-compose up -d

