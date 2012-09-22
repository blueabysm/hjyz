<?


//引用前先定义参数$cs,$span_class,$link_class
//例：$cs="&item_id=".$item_id."&acticle_id=".$acticle_id;
//$span_class="blue12"	$link_class="red12"

$sFenyeFileName=substr(strrchr( $_SERVER["PHP_SELF"], "/" ), 1 );
?>



			<span class="<?=$span_class?>">共 <?echo $iCPage[0];?> 
            页　 第 <?echo $iCPage[1];?> 页　 <a href="<?=$sFenyeFileName?>?iPage=0<?=$cs?>" class="<?=$link_class?>">首页</A>　 
            <a href="<?=$sFenyeFileName?>?iPage=<?echo $iCPage[2];?><?=$cs?>" class="<?=$link_class?>">上页</A>　 <a href="<?=$sFenyeFileName?>?iPage=<?echo $iCPage[3];?><?=$cs?>" class="<?=$link_class?>">下页</A>　 <a href="<?=$sFenyeFileName?>?iPage=<?echo $iCPage[4];?><?=$cs?>" class="<?=$link_class?>">末页</A> </span>