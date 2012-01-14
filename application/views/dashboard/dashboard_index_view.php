<script type="text/javascript">
    google.load('visualization', '1', {'packages': ['geochart']});
    google.setOnLoadCallback(drawRegionsMap);
	 
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Task');
        data.addColumn('number', 'Hours per Day');
        data.addRows(3);

        data.setValue(0, 0, 'Positive');
        data.setValue(0, 1, 2);

        data.setValue(1, 0, 'Neutral');
        data.setValue(1, 1, 2);

        data.setValue(2, 0, 'Negative');
        data.setValue(2, 1, 2);

        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, {
            width: 220, height: 220,legend:'bottom', chartArea:{top:20},title:'Overall Feedback Score',
            titleTextStyles:{color: '#343434', fontSize: 12,fontWeight:'bold'},
            colors:['#00bf9b','#81cf40','#df0d0d']
        });
    }
	  
    function drawRegionsMap() {
        var data = new google.visualization.DataTable();
        data.addRows(6);
        data.addColumn('string', 'Country');
        data.addColumn('number', 'Feedback Density');
        data.addRows(<?=$dashboard_summary->geoscores?>);

        var options = {};

        var container = document.getElementById('map_canvas');
        var geochart = new google.visualization.GeoChart(container);
        geochart.draw(data, options);
    };

    $(function() {
        
        var data = [
            { label: "Positive",  data: 50, color: '#109ca5' },
            { label: "Negative",  data: 30, color: '#8f3215'},
            { label: "Neutral",  data: 20, color: '#c1661c'},
        ];

        $.plot($("#chart_div"), data, {
            series: {
                pie: { 
                    show: true
                  , radius: 1
                  , label: {
                       show: true
                     , radius: 3/4
                     , background: {
                        opacity: 0.5     
                      , color: '#000'
                     }
                     , formatter: function(label, series) {
                       return '<div style="font-size:8pt;text-align:center;padding:2px;color:white">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
                     } 
                  }
                }
            },
            grid: {
                hoverable: true,
                clickable: true
            },
            legend: {
                show: false     
            },
        });
    });
</script>

<div class="block noborder">
    <h3>News from 36Stories: <span style="font-weight:normal">We've reached a new milestone today!</span></h3>
</div> 
<div class="block noborder grids">
    <div class="dashboard-updates">
        <div class="dashboard-updates-title"><strong>New Incoming Feedback</strong> </div>
        <div class="dashboard-updates-list pending"><strong><?=$dashboard_summary->dashscores->newfeed?> new entries</strong> are pending your review </div>
        <div class="dashboard-updates-list positive"><strong><?=$dashboard_summary->dashscores->positivefeed?> new entries</strong> are rated positively </div>
        <div class="dashboard-updates-list neutral"><strong><?=$dashboard_summary->dashscores->neutralfeed?> entries</strong> are rated neutral </div>
        <div class="dashboard-updates-list negative"><strong><?=$dashboard_summary->dashscores->negativefeed?> entries</strong> are rated negatively </div>
        <!--<div class="dashboard-updates-list ignored"><strong>5 entries</strong> have been ignored </div>-->
    </div>
    <div class="dashboard-pie-chart">
        <!--
        <div id="chart_div">
        </div>
        -->
        <!--<div class="overall">Overall 4.5/5 <span class="rating excellent">EXCELLENT</span></div>-->
        <h3 style="text-align:center">Feedback Rating Distribution</h3>
        <div id="chart_div" style="width:200px;height:200px"></div>
    </div>
</div>
<div class="block grids">
    <div class="dashboard-graybox">
        <div class="g1of3">
            <h3>Contacts</h3>
            <p><strong><?=$dashboard_summary->dashscores->newfeed?> incoming</strong> entries from contacts </p>
            <!--<p><strong>3 of your contacts</strong> have not yet responded to your feedback requests</p>-->
        </div>
        <div class="g1of3">
            <h3>Feedback Statistics</h3>
            <p><strong><?=$dashboard_summary->dashscores->feedfeatured?></strong> featured entries </p>
            <p><strong><?=$dashboard_summary->dashscores->feedpublished?></strong> published entries </p>
            <!--
            <p><strong>800</strong> feedback requests  </p>
            <p><strong>372,824</strong> impressions </p>
            <p><strong>239,493</strong> clicks</p>
            -->
        </div>
        <div class="g1of3">
            <h3>Feedback Submitters</h3>
            <p>Top country:<strong><?=$dashboard_summary->dashscores->topcountry?></strong> </p>
            <!--<p>Average time on site: <strong>2:93</strong> </p>-->
            <p>Unique submitters: <strong> <?=$dashboard_summary->dashscores->contacttotal?> </strong> </p>
        </div>
    </div>
</div>
<div class="block">
    <h3>GEO-DISTRIBUTION OF FEEDBACK</h3>
    <div id="map_canvas">
    </div>
</div>
<div class="block">
    <table width="100%" class="regular-table" cellpadding="0" cellspacing="0">
        <thead>                        
            <tr><td class="align-left">#</td><td>Category</td><td>% of total feedback</td><td>Entry page</td></tr>
        </thead>
        <tbody>
            <tr><td>1</td><td>Usability<td>12%</td><td>http://36stories.com/featuredcustomers/?q=best%20books%20fo…eurs</td></tr>
            <tr><td>2</td><td>Usability<td>12%</td><td>http://36stories.com/featuredcustomers/?q=best%20books%20fo…eurs</td></tr>
            <tr><td>3</td><td>Usability<td>12%</td><td>http://36stories.com/featuredcustomers/?q=best%20books%20fo…eurs</td></tr>
        </tbody>
        <tfoot>
            <tr><td colspan="4"></td></tr>
        </tfoot>
    </table>
</div>
