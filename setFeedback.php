<?php
require_once('feedback.php');

$feed = new FeedBack();

// var_dump($_POST);
// exit;
//nction addFeedback($text,$nome,$mail)
if($feed->addFeedback($_POST['w3review'],$_POST['nome'],$_POST['email'])>0)
{
    echo json_encode(['Status'=>200,'msg'=>'Feedback cadastrado com sucesso.']); exit;
}

// $c = ['name'=>$name, 'email'=>$mail, 'text'=> $text];
// $path = 'feed.json';
// $myfile = fopen($path, "r") ;

// $dat = fread($myfile,8192);
// fclose($myfile);

// var_dump($dat);
// // echo fwrite($myfile, json_encode($c));
// // fclose($myfile);

?>