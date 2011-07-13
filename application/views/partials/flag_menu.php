<div class="filter-holder">
    <ul class="filter_nav">
        <li><?=HTML::link('feedback/filter/all', 'SHOW ALL')?></li>
        <li><?=HTML::link('feedback/filter/positive', 'POSITIVE')?></li>
        <li><?=HTML::link('feedback/filter/negative', 'NEGATIVE')?></li>
        <li><?=HTML::link('feedback/filter/neutral', 'NEUTRAL')?></li>
        <li><?=HTML::link('feedback/filter/profanity', 'CONTAINS PROFANITY')?></li>
        <li><?=HTML::link('feedback/filter/flagged', 'FLAGGED')?></li>
        <li><?=HTML::link('feedback/filter/most', 'MOST CONTENT')?></li>
    </ul>
</div>

<div class="form-select-holder">
    <?=Form::select('form', Array('form1' => 'select form...'))?>
</div>

<div class="sort-by-holder">
    <ul class="filter_nav">
        <li>sort by <?=Form::select('form', Array('date' => 'date'))?></li>
        <li>rating <?=Form::select('form', Array('all' => 'all'))?></li>
        <li>category <?=Form::select('form', Array('all' => 'all'))?></li>
        <li>display <?=Form::select('form', Array(20 => 20))?></li>
    </ul>
</div>
