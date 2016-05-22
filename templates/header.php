<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>音乐分享平台</title>
	<script src="/static/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="/static/bower_components/jquery-form/jquery.form.js"></script>
	<script src="/static/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="/static/bower_components/angular/angular.min.js"></script>
	<script src="/static/bower_components/jquery-ui/jquery-ui.min.js"></script>
	<script src="/static/util_pc.js"></script>

	<script src="/static/bower_components/webcomponentsjs/webcomponents.min.js"></script>
	<script src="/static/bower_components/angular-ui/build/angular-ui.min.js"></script>

	<link rel="import" href="/static/bower_components/polymer/polymer.html">

	<link rel="import" href="/static/bower_components/iron-flex-layout/iron-flex-layout.html">

	<link rel="import" href="/static/bower_components/paper-styles/color.html">
	<link rel="import" href="/static/bower_components/paper-styles/typography.html">
	<link rel="import" href="/static/bower_components/paper-styles/shadow.html">

	<link rel="import" href="/static/bower_components/iron-flex-layout/classes/iron-flex-layout.html">
	<link rel="import" href="/static/bower_components/paper-toolbar/paper-toolbar.html">
	<link rel="import" href="/static/bower_components/paper-tabs/paper-tabs.html">
	<link rel="import" href="/static/bower_components/paper-tabs/paper-tab.html">

	<link rel="import" href="/static/bower_components/paper-item/paper-item.html">
	<link rel="import" href="/static/bower_components/iron-collapse/iron-collapse.html">
	<link rel="import" href="/static/bower_components/paper-menu/paper-menu.html">
	<link rel="import" href="/static/bower_components/paper-menu/paper-submenu.html">

	<link rel="stylesheet" href="/static/bower_components/jquery-ui/themes/smoothness/jquery-ui.min.css">
	<link rel="stylesheet" href="/static/bower_components/angular-ui/build/angular-ui.min.css">
	<link rel="stylesheet" href="/static/bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="/static/base.css">

	<style is="custom-style">
		.horizontal-section-container {
		@apply(--layout-horizontal);
		@apply(--layout-center-justified);
		@apply(--layout-wrap);
		}

		.horizontal-section {
			background-color: white;
			padding: 24px;
			margin-right: 24px;
			min-width: 200px;
		@apply(--shadow-elevation-2dp);
		}

		:root {
			--paper-tabs-selection-bar-color: rgb(43, 162, 226);
		}
	</style>
</head>

<body>

	<div class="row">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header col-md-2 col-sm-2 col-xs-12">
					<a href="/index.php"><img class="navbar-header-logo" src="/static/logo.png" /></a>
				</div>

				<span class="col-md-7 col-sm-5 col-xs-8">
					<paper-tabs noink class="blue col-md-9 col-xs-12">
						aaa
					</paper-tabs>
				</span>

				<span class="pull-right">
					{% if session.get('username', None) %}
						<a href="/pc_new_publish.php" class="btn btn-sm btn-success font-black">发布职位</a>
						<a href="/login" class="btn btn-sm btn-default font-black">注销</a>
					{% else %}
						<a href="/login" class="btn btn-sm btn-primary font-black">注册/登录</a>
					{% endif %}
				</span>

			</div>
		</nav>
	</div>
