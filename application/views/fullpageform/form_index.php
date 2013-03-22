<h1>Hello Muthafuckas!</h1>
<div ng-controller="FormCtrl">
    <p><input type="text" value="" name="firstname" ng-model="data.firstname" /></p>
    <p><input type="text" value="" name="lastname" ng-model="data.lastname" /></p>
</div>
<a href="../<?=Config::get('application.subdomain')?>/submit/#/profile">Next</a>
