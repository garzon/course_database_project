<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Music Online音乐分享平台</title>
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
    <link rel="stylesheet" href="/static/midikeyboard.css">

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
    
    <script src="/static/bower_components/requirejs/require.js"></script>
	<script>
		require.config({
			paths : {
				"MidiController" : ["/static/js/midicontroller"],
				"MidiData" : ["/static/js/mididata"],
				"MidiView" : ["/static/js/midiview"],
				"WebAudioChannel" : ["/static/js/webaudiochannel"],
				"WebAudioController" : ["/static/js/webaudiocontroller"],
				"WebAudioInstructmentNode" : ["/static/js/webaudioinstructmentnode"],
				"WebAudioMuyuNode" : ["/static/js/webaudiomuyunode"],
				"WebAudioPianoNode" : ["/static/js/webaudiopianonode"],
				"WebAudioSynth" : ["/static/js/webaudiosynth"],
				"WebAudioViolinNode" : ["/static/js/webaudioviolinnode"],
				"WebAudioHornNode": ["/static/js/webaudiohornnode"],
				"WebAudioFluidPianoNode": ["/static/js/webaudiofluidpianonode"],
				"WebMidiInstructmentNode": ["/static/js/webmidiinstructmentnode"],
				"OutputStream": ["/static/js/outputstream"],
				"MidiEvent": ["/static/js/midievent"],
				"jasmid-Stream": ["/static/js/jasmid/stream"],
				"jasmid-MidiFile": ["/static/js/jasmid/midifile"]
			}
		});
	</script>
</head>

<body {{'class="editor-body"' if request.url.find("/editor") != -1 else ''}}>

	<div class="row">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header col-md-2 col-sm-2 col-xs-12">
					<a href="/"><img class="navbar-header-logo" src="/static/logo.png" /></a>
				</div>

				<span class="col-md-7 col-sm-5 col-xs-8">
					Music Online
				</span>

				<span class="pull-right black">
					{% if session.get('username', None) %}
                        欢迎你，{{session.get('username', None)}}！
						<a href="/upload" class="btn btn-sm btn-success font-black">分享音乐</a>
						<a href="/login" class="btn btn-sm btn-default font-black">注销</a>
					{% else %}
						<a href="/login" class="btn btn-sm btn-primary font-black">注册/登录</a>
					{% endif %}
				</span>

			</div>
		</nav>
	</div>
