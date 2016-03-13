#!/bin/bash
function install_db(){
	echo "Deseja criar/substituir o banco ? [s/n]"
	read -r option
	if [ "$option" = "s" ] || [ "$option" = "S" ]
	then
		. ./scripts/db.sh reload
	fi
}

function config_db(){
	echo "Deseja abrir o arquivo de configuração do banco agora ? [s/n]"
	read -r option
	if [ "$option" = "s" ] || [ "$option" = "S" ]
	then
		nano ./config/database_config.php
	fi
}

function install(){
	. ./scripts/setup.sh
	install_db
	config_db
}

install
