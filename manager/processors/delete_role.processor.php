<?php
if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
if(!$modx->hasPermission('delete_role')) {	
	$modx->webAlertAndQuit($_lang["error_no_privileges"]);
}

$id=$_GET['id'];

if($id==1){
	$modx->webAlertAndQuit("The role you are trying to delete is the admin role. This role cannot be deleted!");
}

$rs = $modx->db->select('COUNT(*)', $modx->getFullTableName('user_roles'), "role='{$id}'");
$count=$modx->db->getValue($rs);
if($count>0){
	$modx->webAlertAndQuit("There are users with this role. It can't be deleted.");
}

// delete the attributes
$modx->db->delete($modx->getFullTableName('user_roles'), "id='{$id}'");

// Set the item name for logger
$name = $modx->db->getValue($modx->db->select('name', $modx->getFullTableName('user_roles'), "id='{$id}'"));
$_SESSION['itemname'] = $name;

$header="Location: index.php?a=86";
header($header);
?>