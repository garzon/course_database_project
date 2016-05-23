

	<div class="container main-block"  ng-app="mainListing" ng-controller="listingController">
        
        <div class="listing-block">
            <p>按评分排序：<a href="#" class="opbtn-filter" data-prop="score" data-val="0">全部</a> <a href="#" class="opbtn-filter" data-prop="score" data-val="1">1+</a> <a href="#" class="opbtn-filter" data-prop="score" data-val="2">2+</a> <a href="#" class="opbtn-filter" data-prop="score" data-val="3">3+</a> <a href="#" class="opbtn-filter" data-prop="score" data-val="4">4+</a> </p>
        </div>
    
        <blockquote class="listing-block" ng-repeat="music in data">
            <div class="col-md-7 listing-block-info">
                <h4 class="inline-block"><a class="black" href="/view/[[music.music_id]]">[[music.name]]</a></h4><h6 class="inline-block label label-primary">[[music.type]]</h6>
                <p>[[music.introduction.substr(0, 30) + '...']]</p>
                <p><span class="mySmall">作者：[[music.author]] - 由[[music.username]]上传</span></p>
            </div>
            <div class="col-md-5 listing-block-sidebar">
                <a href="/view/[[music.music_id]]">查看</a><span ng-show="[[username == music.username]]"> | </span>
                <a href="#" data-mid="[[music.music_id]]" data-mname="[[music.name]]" onclick="opbtn_delete_click.apply(this)" ng-show="[[username == music.username]]">删除此项</a>
            </div>
        </blockquote>
	</div>

<script>
	var app = angular.module('mainListing', []);
    app.config(['$interpolateProvider', function($interpolateProvider) {
      $interpolateProvider.startSymbol('[[');
      $interpolateProvider.endSymbol(']]');
    }]);
    app.controller('listingController', function($scope, $http) {
        $scope.username = findMidStr(document.cookie, 'username=', ';');
        $scope.data = {};
        $scope.isSiderbarShown = true;
        reloadListing = function() {
            $http.get('/api/list?{{request.query_string}}').then(function(resp) {
                $scope.data = resp.data;
                $scope.$applyAsync();
            }, function() {
            
            });
        };
        reloadListing();
	});
    $(function() {
        opbtn_delete_click = function() {
            if(confirm('确定要删除“'+$(this).data('mname')+'”么？'))
                $.post('/api/delete/' + $(this).data('mid'), {}, function(data) {
                    if(data['failed']) {
                        alert('删除失败，原因：' + data['msg']);
                    } else {
                        alert('删除成功');
                        reloadListing();
                    }
                }, 'json');
        };
        $(".opbtn-filter").on('click', function(e) {
            e.preventDefault();
            var $this = $(this);
            window.location = buildNewUrlQuery($this.data('prop'), $this.data('val'));
        });
    });
</script>