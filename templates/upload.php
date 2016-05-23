
<div class="container main-block block-page"  ng-app="login_dialog" ng-controller="dialog_controller">
	<h3>分享音乐</h3>
	<h4><small>Sharing is great!</small></h4>

	<form method="post" enctype="multipart/form-data" class="form-horizontal" ng-app="" ng-submit="submit()" role="form" action="/api/upload">

		<div class="form-group">
			<div class="row">
				<label for="midiData" class="col-md-1-2 control-label">选择上传的mp3/midi：</label>
				<div class="col-md-10 row">
					<div class="col-md-6">
						<span class="btn btn-primary btn-lg btn-file fabu-form-button">
							<span>点此选择文件</span>
							<input type="file" id="midiData" name='music_file' accept=".mid,.midi,.mp3" required="required" />
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<label for="category" class="col-md-1-2 control-label">音乐类别：</label>
				<div class="row col-md-10">
					<div class="col-md-6">
						<input class="form-control form-category-selector myHidden" name='type' required="required" type="text" />
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle fabu-form-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                请选择一个类目 <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="fabu-form-category" data-category="folk">folk</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="pop">pop</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="jazz">jazz</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="electrical">electrical</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="soundtrack">soundtrack</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="newage">newage</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="classical">classical</a></li>
                            </ul>
                        </div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="row">
				<label for="name" class="col-md-1-2 control-label">音乐名称：</label>
				<div class="row col-md-10">
					<div class="col-md-6">
						<input class="form-control" id="name" name='name' required="required" type="text" />
					</div>
				</div>
			</div>
		</div>
        
        <div class="form-group">
			<div class="row">
				<label for="introduction" class="col-md-1-2 control-label">音乐简介：</label>
				<div class="row col-md-10">
					<div class="col-md-6">
						<textarea class="form-control" id="introduction" name='introduction'></textarea>
					</div>
				</div>
			</div>
			<div class="col-md-offset-1-2 row">
				<span class="fabu-form-hint grey"></span>
			</div>
		</div>
        
        <div class="form-group">
			<div class="row">
				<label for="author" class="col-md-1-2 control-label">作者名字：</label>
				<div class="row col-md-10">
					<div class="col-md-6">
						<input class="form-control" id="author" name='author' required="required" type="text" />
					</div>
				</div>
			</div>
		</div>
        
        <div class="form-group">
			<div class="row">
				<label for="category" class="col-md-1-2 control-label">作者流派：</label>
				<div class="row col-md-10">
					<div class="col-md-6">
						<input class="form-control form-category-selector myHidden" name='genre' required="required" type="text" />
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle fabu-form-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                请选择一个流派 <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a href="#" class="fabu-form-category" data-category="folk">folk</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="pop">pop</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="jazz">jazz</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="electrical">electrical</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="soundtrack">soundtrack</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="newage">newage</a></li>
                                <li><a href="#" class="fabu-form-category" data-category="classical">classical</a></li>
                            </ul>
                        </div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-offset-2">
				<input type="submit" class="btn btn-success btn-lg fabu-form-button" value="Submit!" />
			</div>
		</div>
	</form>
</div>
