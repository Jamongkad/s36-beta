<?
$user = new S36Auth;
if($user->check()):
?>
            <!-- end of feedback list -->
            <div class="admin-sorter-bar">
            	<div class="sorter-bar">
                    <div class="left">
                    	<input type="checkbox" />
                    </div>
                    <div class="right">
                    	<div class="g1of3">
                        	<label>WITH SELECTED</label>
                            <select>
                            	<option>Delete</option>
                            </select>
                        </div>
                        <div class="g1of3">
                        	<div class="pagination-text"><a href="#">prev</a> Displaying feedbacks 1-12 of 25 <a href="#">next</a></div>
                        </div>
                        <div class="g1of3">
                        	<div class="pagination">
                            	Page <input type="text" style="width: 30px;" class="pagination-input" value="1" /> of 59
                            </div>
                        </div>
                    </div>
                    <div class="c"></div>
                </div>
            </div>
        </div> 
        <div class="c"></div>
    </div>
    <div id="footer">
        <h4>Feedback & Customer Satisfaction Simplified.</h4>
        <h4>36Stories © 2011. </h4>
        <p>Keep in touch by following us on <a href="#">Facebook</a>, <a href="#">Twitter</a>, subscribing to our <a href="#">blog's feed</a> and joining our <a href="#">email newsletter</a>.</p>
    </div>
<?endif?>
</div>
</body>
</html>
