<?foreach($collection as $coll):?>
    <h2><?=$coll->head?></h2>
    <?foreach($coll->children as $child):?>
        <?=$child?><br/>
    <?endforeach?>
<?endforeach?>
