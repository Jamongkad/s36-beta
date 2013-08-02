<? if ($dashboard_summary->dashscores != null): ?>
    <?= HTML::script('/js/jquery.flot.js'); ?>
    <?= HTML::script('/js/jquery.flot.pie.js'); ?>
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load('visualization', '1', {'packages': ['geochart']});
        google.setOnLoadCallback(drawRegionsMap);
          
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
                { label: "Positive",  data: <?=$dashboard_summary->dashscores->positivefeed?>, color: '#109ca5' },
                { label: "Negative",  data: <?=$dashboard_summary->dashscores->negativefeed?>, color: '#8f3215'},
                { label: "Neutral",  data: <?=$dashboard_summary->dashscores->neutralfeed?>, color: '#c1661c'},
            ];

            $.plot($("#chart_div"), data, {
                series: {
                    pie: { 
                        show: true
                      , radius: 1
                      , label: {
                           show: true
                         , radius: 1/2
                         , formatter: function(label, series) {
                           return '<div style="font-size:8pt;text-align:center;color:white">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
                         } 
                      }
                    }
                },
                grid: {
                     hoverable: true
                   , clickable: true
                },
                legend: {
                    show: false     
                },
            });

            $(document).delegate("#chart_div", "plotclick", function(e, pos, obj) {
                var href;
                if(obj.series.label === "Neutral") {
                    href = $('.neutral strong a').attr('href');;
                    window.location = href;
                }

                if(obj.series.label === "Positive") {
                    href = $('.positive strong a').attr('href');;
                    window.location = href;
                }

                if(obj.series.label === "Negative") { 
                    href = $('.negative strong a').attr('href');;
                    window.location = href;
                }
                //console.log(obj.series.label);
            });
        });
    </script>
    
    <div id="theReports" class="dashboard-page">
        <h1>Feedback received for the month of <?=date('F')?></h1>
        
        <div class="reports-stats grids">
            <div class="reports-stats-left">
                <div class="reports-border">
                    <div class="reports-block">
                        <span class="report-text new"><strong><?=HTML::link('inbox/all', $dashboard_summary->dashscores->newfeed." new entries")?></strong> are pending for your review</span>
                    </div>
                    <div class="reports-block">
                        <span class="report-text positive"><strong><?=HTML::link('inbox/published/all', $dashboard_summary->dashscores->positivefeed." entries")?></strong> are rated positively</span>
                    </div>
                    <div class="reports-block">
                        <span class="report-text neutral"><strong><?=HTML::link('inbox/neutral', $dashboard_summary->dashscores->neutralfeed." entries")?></strong> are rated neutral</span>
                    </div>
                    <div class="reports-block">
                        <span class="report-text negative"><strong><?=HTML::link('inbox/negative', $dashboard_summary->dashscores->negativefeed." entries")?></strong> are rated negatively</span>
                    </div>
                </div>
            </div>
            <div class="reports-stats-right">
                <div class="reports-chart">
                    <br/><br/><p align="center">Feedback Rating Distribution</p><br/>
                    <div id="chart_div" style="width: 200px; height: 200px; margin: 0 auto;"></div>
                </div>
            </div>
        </div>
        <div class="dashboard-splitter"></div>
        <div class="reports-blue-box">
            <div class="grids">
                <div class="report-box-left">
                    <div class="reports-pad">
                        <h4>Contacts</h4>
                        <p><strong><?=$dashboard_summary->dashscores->newfeed?> incoming</strong> entries from contacts</p>
                    </div>
                </div>
                <div class="report-box-center">
                    <div class="reports-pad">
                        <h4>Feedback Statistics</h4>
                        <p><strong><?=$dashboard_summary->dashscores->feedfeatured?></strong> featured entries</p>
                        <p><strong><?=$dashboard_summary->dashscores->feedpublished?></strong> published entries</p>
                    </div>
                </div>
                <div class="report-box-right">
                    <div class="reports-pad">                                
                        <h4>Feedback Submitters</h4>
                        <p>Top Country: <strong><?=$dashboard_summary->dashscores->topcountry?></strong></p>
                        <p>Unique submitters: <strong><?=$dashboard_summary->dashscores->contacttotal?></strong></p>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="dashboard-splitter"></div>
        <strong>GEO-DISTRIBUTION of Feedback</strong><br />
        <div class="reports-geo-heatmap">
            <div class="reports-geo-pad">
                <!-- insert map here -->
                <div id="map_canvas"></div>
            </div>
        </div>
    </div>
    
<?else:?> 
    <div class="woops">
        <h2>Woops. Since there's no feedback.</h2><br/><br/>
        <p>Invite some of your customers to send in feedback on https://<?=$company_info->name?>.fdback.com!</p>
    </div> 
<?endif?>
