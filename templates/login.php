
<body class="body-index">
<div class="container main-block"  ng-app="login_dialog" ng-controller="dialog_controller">
    <div class="col-sm-11 box alert" ng-class="msg_type" ng-show="msg != ''" ng-bind="msg">
        
    </div>
	<div class="col-sm-11 box block-page">
		<div class="col-sm-7 login-dialog-intro">
			<div class="col-sm-12">
				<p><img src="/static/logo.png" /></p>
				<p class="blue">音乐分享平台</p>
				<p></p>
				<p></p>
				<p></p>
			</div>
		</div>
		<div class="col-sm-5 login-dialog-box">
			<div class="col-sm-12">
				<paper-tabs noink selected="0" class="blue col-sm-12">
					<paper-tab link><a href="#" class="horizontal center-center layout" ng-click="isLogin = false;">注册</a></paper-tab>
					<paper-tab link><a href="#" class="horizontal center-center layout" ng-click="isLogin = true;">登录</a></paper-tab>
				</paper-tabs>
			</div>

			<form method="post" class="form-horizontal" ng-show="isLogin" action="/api/login">
				<div class="form-group">
					<label for="username" class="control-label">用户名</label>
					<div>
						<input class="form-control" id="username" name='username' placeholder="用户名">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="control-label">密码</label>
					<div>
						<input name='password' type="password" class="form-control" id="password" placeholder="密码">
					</div>
				</div>
				<input type='hidden' name='type' value="login">
				<div class="form-group">
					<div>
						<button type="submit" class="col-sm-12 btn btn-primary">登录</button>
						<br />
						<!--a class="pull-right" href="/forget_password.php">忘记密码?</a-->
					</div>
				</div>
			</form>

			<form method="post" class="form-horizontal" ng-show="!isLogin" action="/api/register">
				<div class="form-group">
					<label for="username" class="control-label">用户名</label>
					<div>
						<input class="form-control" id="username" name='username' placeholder="用户名">
					</div>
				</div>
                <div class="form-group">
					<label for="password" class="control-label">密码</label>
					<div>
						<input name='password' type="password" class="form-control" id="password" placeholder="设定密码">
					</div>
				</div>
				<div class="form-group">
					<label for="mail" class="control-label">Email</label>
					<div>
						<input class="form-control" id="mail" name='mail' placeholder="邮箱">
					</div>
				</div>
				<input type='hidden' name='type' value="register">
				<div class="form-group">
					<input type="submit" class="col-sm-12 btn btn-primary" value="注册" />
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	angular.module('login_dialog', []).controller('dialog_controller', function($scope) {
        $scope.msg = '';
		$scope.isLogin = false;
        $('form').ajaxForm({
            dataType: 'json',
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

