<?php
$cats = $db->select("select * from category ");
foreach($cats as $r)
{
	?>
    <div><a href="index.php?mod=book&ac=list&id=<?php echo $r["id"];?>">
    		<?php echo $r["name"];?></a>
    </div>
    <?php	
}

?>