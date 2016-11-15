create user 'root'@'10.0.2.2' identified by 'peanutbutter';
grant all privileges on *.* to 'root'@'10.0.2.2' with grant option;
flush privileges;