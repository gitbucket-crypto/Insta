<?php 
require_once('define.php');
require_once('instagram.php');

$insta = new Instagram($client_id, $secret,$token );

if(isset($_POST['userIn']) & $_POST['userIn']!='')
{
    $response= $insta->explorer($_POST['userIn'],$fbToken);
    echo  json_encode(['Status'=>200,'msg'=>$response]); exit;
}
else echo json_encode(['Status'=>201,'msg'=>'Nome de usuario inválido']); exit;

?>