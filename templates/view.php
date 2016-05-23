<div class="container main-block" style="margin-bottom: 100px;"  ng-app="resumeSidebar" ng-controller="resumeSidebarController" >
	<div class="row col-md-12">
		<div class="resume-view block-page col-md-8">
			<div class="row">
				<ul class="nav nav-tabs">
					<li role="presentation" class="active">
						<a href="#">Introduction</a>
					</li>
					<li role="presentation"><a href="#comment-history">Comments([[data.comments.length]])</a></li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
                    <h3 class="orange bold"> [[data.score]] / 5.0</h3>
                    <p>名字：[[data.name]] <h6 class="inline-block label label-primary">[[music.type]]</h6></p>
                    <p>作者：[[data.author]] <h6 class="inline-block label label-primary">[[music.genre]]</h6></p>
					<p>简介：[[data.introduction]]</p>
				</div>
			</div>
			<br />
            <audio controls ng-show="data.file_path.substr(-3) == 'mp3'">
              <source src="/api/get_music/{{music_id}}" type='audio/mp3' />
              Your browser does not support the audio element.
            </audio>
            <a class="btn btn-primary btn-lg"  ng-show="data.file_path.substr(-3) != 'mp3'" href="/editor/{{music_id}}">Play!</a>
			<a class="btn btn-default btn-lg" href="/api/get_music/{{music_id}}">下载</a>
			<br /><br /><br />
			<div id="comment-history" class=".resume-comment">
				<h3>Comments:</h3>
				<hr />
				<div ng-repeat="comment in data.comments">
						<div class="row">
							<div class="col-md-7">
								<h4>[[comment.username]]评了[[comment.score]]分，评论道：</h4>
							</div>
						</div>
						<div>
							[[comment.feedback]]
						</div>
						<hr />
				</div>
			</div>
		</div>
		<div class="col-md-4 resume-sidebar block-page">
			<div>
				<hr />
                <div class="row resume-userinfo">
                    <div class="col-md-12">
                        <h4>
                            [[data.username]]
                        </h4>
                        <h5 class="grey">
                        </h5>
                    </div>
                </div>
                <hr />
			</div>

            <div id="resume-comment" class="row">
                <h3>评论：</h3>
                <h4 ng-class="msg_type" class="alert" ng-show="msg != ''" ng-bind="msg"></h4>
                <form method="post" action="/api/comment/{{music_id}}">
                    <div class="form-group">
                        <label for="score">评分（最高5，最低1）：</label>
                        <input class="form-control" type="number" name="score" id="score" min="1" max="5" />
                    </div>
                    <div class="form-group">
                        <label for="feedback">留言：</label>
                        <textarea class="form-control" rows="6" name="feedback" id="feedback"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default opbtn-submit-comment">Submit</button>
                </form>
            </div>
		</div>
	</div>
</div>

<script>
	var app = angular.module('resumeSidebar', []);
    app.config(['$interpolateProvider', function($interpolateProvider) {
      $interpolateProvider.startSymbol('[[');
      $interpolateProvider.endSymbol(']]');
    }]);
    app.controller('resumeSidebarController', function($scope, $http) {
        $scope.data = {};
        
        var loadDetails = function() {
            $http.get('/api/detail/{{music_id}}').then(function(resp) {
                $scope.data = resp.data;
                $scope.$applyAsync();
            }, function() {});
        };
        
        loadDetails();
        
        $scope.msg = '';
        $('form').ajaxForm({
            dataType: 'json',
            cache: false,
            beforeSubmit: function() {
                $scope.msg = '正在提交...';
                $scope.msg_type = 'alert-warning';
            },
            success: function(data) {
                $scope.msg = data['msg'];
                if(data['failed']) {
                    $scope.msg_type = 'alert-danger';
                } else {
                    $scope.msg_type = 'alert-success';
                    $scope.$applyAsync();
                    loadDetails();
                }
            }
        });
	});
</script>
