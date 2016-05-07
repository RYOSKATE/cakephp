<h1><?php echo __('Welcome to Visualize Tool');?></h1>

<h2>1.概要</h2>
<p>
	Visualize Tool(可視化ツール)は、<strong>メトリクス測定ツールの結果データ(CSV)を可視化するツール</strong>です。<br>
	全部で7種類の図・表・グラフを用いて由来・機能レイヤーなど様々な観点から測定されたメトリクスの可視化を行います。
</p>

<h2>2.利用手順</h2>
<h3>CSVファイルの準備</h3>
<p>
	本ツールは測定ツールの出力ファイル(CSV)を可視化します。<br>
	可視化にはCSVファイルのデータを必要としますが
	<ul>
		<li>全てのユーザーが利用できるようにデータベース(DB)に登録する</li>
		<li>各可視化ページでファイル選択を行い、一時的に可視化に利用する</li>
	</ul>
	といった二つの方法があります。
</p>
<p>
	CSVファイルをDBにアップロードする場合、まずヘッダーメニューより
	<?php 
	if($userData['role']!='reader') 
		echo $this->Html->link(__('アップロードフォームページ'),array('controller' => 'graphs', 'action' => 'upload'));
	else
		echo 'アップロードフォームページ';	
	?>
	へ移動してください。
	CSVファイルを選択、モデル名・日付を入力しアップロードボタンを押すことでDBへのアップロードが完了します。
	ただし権限が"閲覧者"のアカウントではアップロードはできません。
<p>
<h3>可視化対象の選択</h3>	
<p>
	左のメニューから各可視化のページに移動することができます。<br>
	各ページには上部に
	<ul>
		<li>モデル名(日付)</li>
		<li>開発グループ</li>
		<li>メトリクス</li>
		<li>ローカルCSVファイル</li>
	</ul>
	という選択項目があります。
	DBに登録されたデータは全てのユーザーに表示され選択が可能です。
	ローカルCSVファイルを選択した場合、モデル名=ファイル名、開発グループ=ファイル内に存在するグループ全て、として可視化を行います。
</p>	

<h2>3.ユーザー</h2>
<p>
	本ツールの利用にはユーザーごとに
	<ul>
		<li>ユーザー名</li>
		<li>パスワード</li>
		<li>所属開発グループ</li>
		<li>権限</li>
	</ul>
	を設定したアカウントを作成する必要があります。<br>
	
	<?php echo ($userData['role']=='admin') ?
	 $this->Html->link(__('新規アカウントの作成'),array('controller' => 'users', 'action' => 'add')):
	 __('新規アカウントの作成');
	 ?>	
	 はAdmin権限を持つユーザーのみ可能です。
</p>	
<h3>所属開発グループ</h3>
	<p>	
	個別のグループを選択する可視化を行う場合、ユーザーは設定された"所属開発グループ"のみ選択することが可能です。<br>
	(複数選択可)
	</p>
<h3>権限</h3>
<p>
	権限には
	<ol>
		<li>管理者(Admin)</li>
		<li>編集者(Author)</li>
		<li>閲覧者(Reader)</li>
	</ol>
	があります。各権限の機能一覧は以下のとおりです。
<table class="table table-hover table-condensed" id ="table">
        <thead>
        <tr>
            <th><?php echo __('機能');?></th>
            <th><?php echo __('閲覧者');?></th>
            <th><?php echo __('編集者');?></th>
            <th><?php echo __('管理者');?></th>
        </tr>
        </thead>
        <tbody>
<?php

	$userAuth = array(
		array(__('アップロードデータの可視化'),__('◯'),__('◯'),__('◯')),
		array(__('ローカルCSVデータの可視化'),__('◯'),__('◯'),__('◯')),
		array(($userData['role']!='reader')?
			$this->Html->link(__('ローカルCSVデータのアップロード'),array('controller' => 'graphs', 'action' => 'upload')):
			__('ローカルCSVデータのアップロード'),__(''),__('◯'),__('◯')),
		array($this->Html->link(__('アップロードデータ'),array('controller' => 'upload_data', 'action' => 'index')) . __('の一覧表示')
			,__('◯'),__('◯'),__('◯')),
		array(__('アップロードデータの削除'),__(''),__('△'),__('◯')),
		array(($userData['role']=='admin')?
			$this->Html->link(__('ユーザーの一覧表示'),array('controller' => 'users', 'action' => 'index')):
			__('ユーザーの一覧表示') .
			__('・追加・削除'),__(''),__(''),__('◯')),
		array(
		 $this->Html->link(__('開発グループ名'),array('controller' => 'group_names', 'action' => 'index'))
		 . '・'.
		 $this->Html->link(__('モデル名'),array('controller' => 'model_names', 'action' => 'index')) 
		 . __('の一覧表示'),__('◯'),__('◯'),__('◯')),
		array(
		 $this->Html->link(__('開発グループ名'),array('controller' => 'group_names', 'action' => 'index'))
		 . '・'.
		 $this->Html->link(__('モデル名'),array('controller' => 'model_names', 'action' => 'index')) 
		 . __('の編集・削除'),__(''),__('◯'),__('◯')),		 
	);
	foreach($userAuth as $row)
	{
		echo '<tr>';
			foreach($row as $col)
				echo '<td>' . $col . '</td>';
		echo '<tr>';
	}
?>		  
		 </tbody>
    </table>
		△：そのユーザーがアップロードしたデータについてのみ編集可能
</p>			
<h2>4.各可視化手法の概要</h2>
<p>
	<ul>
		<li>
			全開発グループ
			<ul>
				<dt><?php echo $this->Html->link(__('メトリクス散布図'),array('controller' => 'graphs', 'action' => 'alldevgroup'));?></dt>
				<dd>　横軸：ファイル数、縦軸：選択メトリクスとして開発グループ単位の円を散布図で表示します。円の大きさはファイル規模(総物理行数)になります。</dd>
			</ul>
		</li>
		<li>
			各開発グループ
			<ul>
				<dt><?php echo $this->Html->link(__('メトリクス遷移'),array('controller' => 'graphs', 'action' => 'onedevgroup'));?></dt>
					<dd>　横軸：日付、縦軸：選択メトリクスとしてメトリクスの変化を折れ線グラフで表示します。同時に4つのデータまで表示可能です。</dd>
				<dt><?php echo $this->Html->link(__('メトリクスファイルマップ'),array('controller' => 'graphs', 'action' => 'onedevgroup2'));?></dt>
					<dd>　各ディレクトリ以下のメトリクス合計値をブロックの大きさに対応させたツリーマップを表示します。またクリックしたディレクトリについてオプションで選択したメトリクスをレーダーチャートで表示します。</dd>
			</ul>			
		</li>
		<li>
			レイヤー
			<ul>
				<dt><?php echo $this->Html->link(__('メトリクスレーダーチャート'),array('controller' => 'graphs', 'action' => 'metrics'));?></dt>
					<dd>　KernelからAPPまでの各機能レイヤー毎にメトリクス値の合計をレーダーチャートで表示します。</dd>
			</ul>			
			
		</li>
		<li>
			由来
			<ul>
				<dt><?php echo $this->Html->link(__('メトリクス円グラフ'),array('controller' => 'graphs', 'action' => 'origin'));?></dt>
					<dd>　メトリクス値nのファイルの割合を由来毎の円グラフで表示します。</dd>
				<dt><?php echo $this->Html->link(__('メトリクス領域図'),array('controller' => 'graphs', 'action' => 'originCity'));?></dt>
					<dd>　由来毎のメトリクス値を面積に対応させた図形を表示します。</dd>
				<dt><?php echo $this->Html->link(__('OriginCity'),array('controller' => 'graphs', 'action' => 'originCity2'));?></dt>
					<dd>　由来毎のファイル数を面積、高さをメトリクス値、それを機能レイヤー毎に塗り分けた3Dオブジェクトを表示します。</dd>
			<br>
			<p>
				由来とは
				<ul>
					<li>o1をGoogle</li>
					<li>o2をQualcomm</li>
					<li>o3をFujitsu</li>
				</ul>
				が作成したファイルと定義し、
				o1にFujitsuが手を加えたファイルをo13,
				全ての組織が手を加えたファイルをo123のように表す概念のことです。
				全てのファイルはo1,o2,o3,o12,o13,o23,o123の7つのいずれかに分類されます。
			</p>
					
			</ul>			
		</li>
	</ul>
</p>
<h2>5.付箋機能</h2>
<p>
	各ページには左メニューの下部にあるフォームから付箋を登録することができます。
	付箋は全てのユーザーに対して表示されるため、簡易的なレポートのように利用することができます。
</p>	
<h2>6.ヘッダーメニュー</h2>
<p>
	ヘッダーメニューの各項目について説明します。
	<dl>
		<dt><?php echo $this->Html->link(__('Visualize Tool'),array('controller' => 'graphs', 'action' => 'index'));?></dt>
			<dd>　このページヘ移動します。</dd>
		<dt><?php echo $this->Html->link('日本語',array('controller' => 'graphs', 'action' => 'index/lang:jpn'));?>
		・
		<?php echo $this->Html->link('English',array('controller' => 'graphs', 'action' => 'index/lang:eng'));?>
		</dt>
			<dd>　表示言語を切り替えます。</dd>
		<dt><?php echo $this->Html->link('ユーザー名',array('controller' => 'users',  'action' => 'manage'));?></dt>
			<dd>　アカウントのパスワード変更・削除ページヘ移動します。</dd>
		<dt><?php if($userData['role']!='reader')
					echo $this->Html->link(__('Upload'),array('controller' => 'graphs', 'action' => 'upload'));
				else echo 'Upload';
		?></dt>
			<dd>　CSVデータのアップロードページヘ移動します。閲覧者権限のユーザーには表示されません。</dd>
		<dt><?php echo $this->Html->link(__('Data'),array('controller' => 'upload_data', 'action' => 'index'));?></dt>
			<dd>　DBに登録されたデータの一覧ページヘ移動します。編集者・管理者はこのページから各データの編集・削除が可能です。</dd>
		<dt><?php echo $this->Html->link(__('Logout'),array('controller' => 'users',  'action' => 'logout'));?></dt>
			<dd>　ログアウトしログイン画面へ移動します。</dd>
	</dl>
</p>	