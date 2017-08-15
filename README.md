ripple-charts
=============

## 环境搭建

1. git clone https://github.com/ety001/ripple-single-chart.git
2. cd ripple-single-chart
3. composer update
4. php bin/console doctrine:database:create
5. php bin/console doctrine:schema:update --force

## 数据库结构

/src/AppBundle/Entity/Ripple.php

## 接口

/getdata/{addr}/{gateway}

* addr 是要抓取数据的钱包地址
* gateway 是网关地址，为了获取CNY价格，默认是ripplefox的