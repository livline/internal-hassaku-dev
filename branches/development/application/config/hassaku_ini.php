<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| HASSAKU constant
|--------------------------------------------------------------------------
|
*/


// サイトタイトル <title></title>で使用
define('SITE_TITLE', 'ONEシステム' );
// Copyright表記 フッターで表示
define('COPYRIGHT', 'Copyright&copy; xxxxxx All Rights Reserved.' );

// vendorディレクトリパス
define('VENDOR_DIR', __DIR__.'/../vendor');

/*
	ログイン処理クラス・メソッド
*/
define('LOGIN_CLASS', 'auth' );						// ログイン処理をするコントローラークラス名
define('LOGINFORM_METHOD', 'index' );				// ログイン画面のコントローラーメソッド名
define('LOGIN_METHOD', 'login' );					// ログイン処理をするコントローラーメソッド名
define( 'LOGINFORM_LOGINID_NAME', 'login_id' );		// ログインIDのname属性
define( 'LOGINFORM_PASSWORD_NAME', 'login_pass' );	// ログインパスワードのname属性


/*
	コンプリート画面クラス
*/
define('COMPLETE_CLASS', 'complete' );	// 完了画面表示コントローラークラス名



/*
	セッション外クラス・メソッド

	セッションが無くてもアクセスできるコントローラークラス名とメソッド名を連想配列で指定。
	method にはワイルドカート「*」指定可。その場合、指定されたclassの全methodが対象となる。
*/
$no_session = [
		[ 'class' => 'api', 'method' => '*' ],
];
define('NO_SESSION', $no_session );


/*
	セッションの有効期限を無視するクラス・メソッド

	セッションの有効期限が切れていてもアクセスできるコントローラークラス名とメソッド名を連想配列で指定。
	method にはワイルドカート「*」指定可。その場合、指定されたclassの全methodが対象となる。

	上のNO_SESSIONと違い、
	有効期限が切れていても期限切れとしないだけで、ログインし、セッションを開始している必要がある。
*/
$no_limit = [
		[ 'class' => 'ajaxapi', 'method' => '*' ],
		[ 'class' => 'modal', 'method' => '*' ],
];
defined('NO_LIMIT')      OR define('NO_LIMIT', $no_limit );


/*
	チャットワーク設定
*/
$chatwork_token = '';
$room_id = '';
switch (ENVIRONMENT)
{
	case 'development':
		$chatwork_token = '';
		$room_id = 0;
	break;
	case 'staging':
		$chatwork_token = '';
		$room_id = 0;
	break;
	case 'production':
		$chatwork_token = '';
		$room_id = 0;
	break;
}
define('CHATWORK_TOKEN', $chatwork_token );
define('CHATWORK_ROOM_ID', $room_id );

define('METHOD_POST', 1 );
define('METHOD_GET', 2 );
define('METHOD_PUT', 3 );

/*
	セッション
	PHPのセッションは有効期限を長く設定し、HSKセッションで実際のセッション有効期限を決める。
*/
// PHPクッキー設定
define('COOKIE_LIFETIME', 2678400 );	// 31日
define('GC_MAXLIFETIME', 2678400 );		// 31日
define('SESS_COOKIE_NAME', 'hassaku_cookie' );
// HSKセッション有効時間
define('HSK_SESS_LIFETIME', 7200 );	// 2時間

/*
---------------------------
*/



/*
---------------------------
*/


/*
	コンテンツエラー
	エラーメッセージ・エラーコード
*/

// サーバーエラー
const ERROR_SERVER_MAINTENANCE =	[ 'code' => -90010, 'msg' => 'メンテナンス中です' ];
const ERROR_SERVER_ERROR =			[ 'code' => -90020, 'msg' => '致命的なサーバーエラーが発生しました' ];
// セッション系エラー
const ERROR_SESSION_NOTFOUND =		[ 'code' => -90100, 'msg' => '通信エラーが発生しました' ];
const ERROR_SESSION_TIMEOUT =		[ 'code' => -90101, 'msg' => 'セッションタイムアウト' ];
// リクエスト系エラー
const ERROR_REQUEST_NOTFOUND =		[ 'code' => -91000, 'msg' => '404 Not Found.' ];
const ERROR_REQUEST_ILLEGAL =		[ 'code' => -91001, 'msg' => '不正なリクエストです' ];
// DB系エラー
const ERROR_DB_CONNECT_ERROR =		[ 'code' => -92000, 'msg' => 'データベースに接続できませんでした' ];
const ERROR_DB_SQL_ERROR =			[ 'code' => -92001, 'msg' => 'SQLエラー' ];
// メール送信エラー
const ERROR_MAIL_SEND_ERROR =		[ 'code' => -93000, 'msg' => 'メールの送信が出来ませんでした<br>管理者に問い合わせてください' ];



define('ERROR_FORM_IDPASS_ILLEGAL', 'ログインIDかパスワードが間違っています。');