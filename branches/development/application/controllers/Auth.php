<?php
/**
 * 認証コントローラー サンプル
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends HSK_Controller
{

	public $common_db = NULL;

	// ログイン画面
	public function index( $redirect_uri = '' )
	{
		$this->load->helper( 'form' );

		// HTML置換用データ
		$replace = [];
		$replace[ 'redirect_uri' ] = $redirect_uri;
		$this->load->view( 'login', $replace );
	}

	// ログイン処理
	public function login()
	{
		$req = $this->input->post();																		// 外部パラメータは$reqで受け取る


		// HSKバリデーションを利用
		$this->load->library( 'HSK_validate' );
		if( $this->hsk_validate->auth_login() === FALSE )
		{
			log_message( 'INFO', 'auth/login: validation error! errors='.var_export( $this->form_validation->error_array(), TRUE ) );
			$replace = [];
			$replace[ 'redirect_uri' ] = $req[ 'redirect_uri' ];
			$this->load->view( 'login', $replace );
			$this->output->_display();
		exit();
		}

		// DBに接続																							// DB接続と
		$this->common_db = $this->load->database( 'common_db', TRUE );										// モデルのロードを
		if( $this->common_db === FALSE )																	// セットで行う様に
		{																									//
			log_message( 'ERROR', 'auth/login: DB connect error!! login_id='.$req[ 'login_id' ] );			//
		$this->contents_error( ERROR_DB_CONNECT_ERROR[ 'msg' ], ERROR_DB_CONNECT_ERROR[ 'code' ] );			//
		}																									//
		// モデルロード																						// ←ここで必要なモデルを
		$this->load->model('account_model');																// 全てロードする


		// ログインIDからアカウント情報を取得する
		$account_data = $this->account_model->get_account_data_by_loginid( $req[ 'login_id' ] );
		if( $account_data === FALSE )
		{
			// SQLエラー
			log_message( 'ERROR', 'auth/login: get_account_data error!! login_id='.$req[ 'login_id' ] );
		$this->contents_error( ERROR_DB_SQL_ERROR[ 'msg' ], ERROR_DB_SQL_ERROR[ 'code' ] );
		}

		if( $account_data === 0 )
		{
			// ログインIDが間違ってる
			log_message( 'INFO', 'auth/login: NOTICE login failed. login_id='.$req[ 'login_id' ] );

			// ログイン画面に戻す
			$replace = [];
			$replace[ 'redirect_uri' ] = $req[ 'redirect_uri' ];
			$replace[ 'error_msg' ] = ERROR_FORM_IDPASS_ILLEGAL;
			$this->load->view( 'login', $replace );
			$this->output->_display();
		exit();
		}

		// パスワード照合 DBにはpassword_hash( '12345678', PASSWORD_DEFAULT)で生成されたハッシュ値が入っている。
		if( !password_verify( $req[ 'login_pass' ], $account_data[ 'password' ] ) )
		{
			// パスが間違ってる
			log_message( 'INFO', 'auth/login: NOTICE login failed. login_id='.$req[ 'login_id' ] );

			// ログイン画面に戻す
			$replace = [];
			$replace[ 'redirect_uri' ] = $req[ 'redirect_uri' ];
			$replace[ 'error_msg' ] = ERROR_FORM_IDPASS_ILLEGAL;
			$this->load->view( 'login', $replace );
			$this->output->_display();
		exit();
		}

		$this->common_db->trans_begin();		// -------------------- トランザクションBEGIN

		// ラストログインを更新
		$res = $this->account_model->update_lastlogin( $account_data[ 'user_id' ] );
		if( !$res )
		{
			log_message( 'ERROR', 'auth/login: update lastlogin error!! user_id='.$account_data[ 'user_id' ] );
			$this->common_db->trans_rollback();		// -------------------- ロールバック

		$this->contents_error( ERROR_DB_SQL_ERROR[ 'msg' ], ERROR_DB_SQL_ERROR[ 'code' ] );
		}

		$this->common_db->trans_commit();		// -------------------- コミット

		// セッションにデータを格納
		$_SESSION[ 'user_name' ]	= $account_data[ 'name_1' ].$account_data[ 'name_2' ];
		$_SESSION[ 'user_id' ]		= $account_data[ 'user_id' ];
		$_SESSION[ 'kind_bit' ]		= $account_data[ 'kind_bit' ];
		$_SESSION[ 'department_name' ]	= $account_data[ 'department_name' ];
		$_SESSION[ 'login_regist_ym' ]	= date( 'Y-m' );	//ログイン時の年月（メニューに使用）
		$_SESSION[ 'last_access' ]	= time();


		$this->load->helper( 'url' );
		// リダイレクト先が指定されていれば
		if( $req[ 'redirect_uri' ] != '' )
		{
			$redirect_uri = urlsafe_base64_decode( $req[ 'redirect_uri' ] );
			redirect( $redirect_uri );
		}
		else
		{
			// ダッシュボードにリダイレクト
			redirect( '/dashboard/' );
		}
	}

	public function logout()
	{
		// ログアウト処理
		//if( isset( $_SESSION[ 'user_id' ] ) )
		//{
			log_message( 'INFO', 'auth/logout: >>> User Logout. user_id='.$_SESSION[ 'user_id' ] );
			session_destroy();
			header( 'Location: /' );
		exit;
		//}
	}
}
