<?php
require_once('define.php');
require_once('instagram.php');

$insta = new Instagram($client_id, $secret,$token );
switch($_POST['function'])
{
    case 1: case '1':  case 'M':   case 'm':
        $posts = $insta->getMyPosts();
        $v=0; $i=0;
        foreach($posts['data'] as $p)        {
            if($p["media_type"]==='VIDEO')
            {
                $v=$v+1;
            }
            else $i=$i+1;
        }
        echo json_encode(['Status'=>200,'videos'=>$v,'imagem'=>$i]); exit;
    break;
    case 2: case '2': case 'F':case 'f':
        echo json_encode(['Status'=>200,'msg'=>'Executar no Browser '. $insta->feed($token),'clip'=>$insta->feed($token)]); exit;
    break;
    case 3:	case '3':  case 'GF': case 'gf':
        $res = $insta->getFollowingTotal();
        echo json_encode(['Status'=>200,'follow'=>$res['data']['user']["edge_follow"]["count"]]); exit;
    break;
    case 4:case '4':  case 'E':  case 'e':
        $res= $insta->explorer($_POST['username'],$fbToken);
        echo json_encode(['Status'=>200,'msg'=>$res[1]]); exit;
    break;
    case 5: case '5':
         $res='https://www.instagram.com/web/search/topsearch/?query='.($_POST['username']);
         echo json_encode(['Status'=>200,'msg'=>'Executar no Browser '.$res,'clip'=>$res]);  exit;
    break;
    case 10: case '10':
        $res= (json_decode($insta->renewToken()));
            echo json_encode(['Status'=>200,'msg'=>'Token renovado para 30 dias']);  exit;
    break;
    default:
        echo json_encode(['Status'=>201,'msg'=>'Função não localizada']); exit;
    break;
}


?>