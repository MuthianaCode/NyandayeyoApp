<?php

$sessionId 	= $_REQUEST['sessionId'];
$telemovel 	= $_REQUEST['msisdn'];
$path		= $_REQUEST['path'];

$respondedMenu = $_REQUEST['menu'];

$value = $_REQUEST['input'];

$violence_type	="";
$phone_number	="";
$accept_deny	="";

$con = new PDO("mysql: host=localhost; dbname=vcm_app", "root", "12345");

switch($respondedMenu){
	// Menu inicial
	case "MENU-INICIAL";

	// Enviar uma alerta de emergencia
	if($value==1){
	$con->prepare("INSERT INTO denuncias(den_tipoviolencia, den_contacto, den_data) VALUES ('Urgencia','$telemovel',NOW())")->execute();
		showMessage("Uma mensagem solidaria!");
		break;

	//Cadastrar (introduzir nome, 3 numeros de telemovel de pessoas confiadas)
	}elseif($value==2){

		showMenu("Escolha a provincia \n\n1. Maputo\n2. Manica\n3. Nampula", "REGISTRAR", "NUMBER");
		//Informacoes
	}elseif($value==3){

		showMenu("Enviar agora\n\n1. Sim\n2. Nao", "INFORMACAO", "NUMBER");

	}elseif($value==4){

		session_destroy($_SESSION);
	}

	break;
	// escolher tipo de denuncia
	case 'REGISTRAR';

	if($value==1){
		showMessage("Registado com sucesso.\n" . $namw. "\n");
	break;
	}

	default:

	if($value == "*202#"){
		//showMenu("Bem Vindo ao Nyandayeyo \n Escolha sua opcao\n\n1. Denunciar\n2. Localizar Gabinete de Atendimento\n3. Assistencia\n4. Sair","MENU-INICIAL", "NUMBER");
		showMenu("Bem Vindo ao Nyandayeyo \n Escolha sua opcao\n\n1. Alertar\n2. Cadastrar\n3. Informacao\n4. Sair","MENU-INICIAL", "NUMBER");
	}else{
		showMessage("SWAP");
	}
}


function showMenu($screen,$menu,$inputType="TEXT"){
	$resp = array(
		'menu'=>$menu,
		'type'=>'FORM',
		'input'=>$inputType,
		'content'=>$screen,
		'sessionId' => $GLOBALS['sessionId']
	);

	header('Content-Type: application/json');
	echo json_encode($resp);
}


function showMessage($message){
	$resp = array(
		'type'=>'MESSAGE',
		'content'=>$message,
		'sessionId' => $GLOBALS['sessionId']
	);

	header('Content-Type: application/json');
	echo json_encode($resp);
}
