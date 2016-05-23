<script>
	angular.module('login_dialog', []).controller('dialog_controller', function($scope) {
        $scope.msg = '';
		$scope.isLogin = false;
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
                    if(data['redirect'])
                        window.location = data['redirect'];
                }
                $scope.$apply();
            }
        });
	});
</script>


		<nav class="navbar navbar-default navbar-bottom {{'hidden' if request.url.find("/editor") != -1 else ''}}">
			<div class="container">
				<div class="row">
					<div class="navbar-header col-md-2 col-sm-2 col-xs-12">
						<a href="/"><img class="navbar-header-logo" src="/static/logo.png" /></a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-8 grey">
						<p>Music Online</p>
						<p class="small">Copyright. <a href="mailto:garzonou@gmail.com">garzon</a></p>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 grey">
						<p>time</p>
						<p class="small">100 ms</p>
					</div>
				</div>
			</div>
		</nav>

</body>
</html>
