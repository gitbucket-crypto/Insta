<?php

if($_GET['ps']==100)
{
    $path = 'feed.json';
    //========determine-filesize==/
    $size= filesize($path); echo ' '.$size;
    //========open file============/
    if((int)$size==0)
    {
        $file=fopen('feed.json',"w");
		$array_data=array();
        $feed=array(
            'name'=>$_GET['nome'],
            'email'=>$_GET['email'],
            'text'=>$_GET['text']
        );
        $array_data[] = $feed;
        $final_data = json_encode($array_data);
        //var_dump($array_data);
        $i = fwrite($file, $final_data);
        fclose($file);
        echo $i;
    }
    if((int)$size>0)
    {
        $current_data = file_get_contents('feed.json');
        $array_data = json_decode($current_data);
        $feed=array(
            'name'=>$_GET['nome'],
            'email'=>$_GET['email'],
            'text'=>$_GET['text']
        );
        $array_data[] = $feed;
        $final_data = json_encode($array_data);
        unlink($path);
        $file = fopen($path,"w+");
        $i = fwrite($file, $final_data);
        fclose($file);
        echo $i;

    }
}
else
{
    $current_data = file_get_contents('feed.json');
    $array_data = json_decode($current_data);


}

?>