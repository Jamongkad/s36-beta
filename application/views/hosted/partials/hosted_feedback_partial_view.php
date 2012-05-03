<?foreach($collection as $coll):?>
    <?if(property_exists($coll, 'head')):?>
        <h2><?=$coll->head?></h2>
    <?endif?>
    <?foreach($coll->children as $child):?>
        <p><?=$child?></p>
    <?endforeach?>
<?endforeach?>
