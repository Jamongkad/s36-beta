<?foreach($collection as $coll):?>
    <?if(property_exists($coll, 'head')):?>
        <h2><?=$coll->head?></h2>
    <?endif?>
    <?foreach($coll->children as $child):?>
        <?=$child?><br/>
    <?endforeach?>
<?endforeach?>
