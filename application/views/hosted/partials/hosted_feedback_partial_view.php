<?foreach($collection as $coll):?>
    <?if(property_exists($coll, 'head')):?>
        <h2><?=$coll->head?></h2>
    <?endif?>
    <ul>
    <?foreach($coll->children as $child):?>
        <li><?=$child?></li>
    <?endforeach?>
    </ul>
<?endforeach?>
