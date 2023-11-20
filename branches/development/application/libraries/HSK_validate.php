<?php
defined('BASEPATH') OR exit('No direct script access allowed');


// バリデーションチェック
//
class HSK_validate
{
	public function __construct()
	{
		get_instance()->load->library( 'form_validation' );
		get_instance()->load->helper( 'hsk_validate_error' );
		get_instance()->form_validation->set_error_delimiters('', '');
	}

	// HSKでバリデーションチェックを行う
	private function set_rules( $key, $rule_msg )
	{
		get_instance()->form_validation->set_rules( $key, '', $rule_msg[ 0 ], $rule_msg[ 1 ] );
	}


	// ----------- 以下フォーム毎のバリデーション処理を記述
	// ----------- メソッド命名規則 [ 呼び出し側Class名_呼び出し側メソッド名 ]

/* サンプル
	public function hr_add()
	{
		// HSKでのバリデーション
		$this->set_rules( 'company_id', HSK_RULE_REQ_over1 );

		// POST値の条件よってバリデーションを行う場合
		if( get_instance()->input->post( 'middlename_chk' ) == 1 )
		{
			$this->set_rules( 'middlename', HSK_RULE_REQ_maxlen100 );
		}

		// CodeIgniterでのバリデーション
		get_instance()->form_validation->set_rules( 'password', '', 'required|alpha_numeric', [ 'required' => '入力してください','alpha_numeric' => '半角英数記号で入力してください' ] );


		// バリデーションエラー
		if( get_instance()->form_validation->run() === FALSE )
		{
			return FALSE;
		}

	return TRUE;
	}
*/

	public function auth_login()
	{
		$this->set_rules( 'login_id', HSK_RULE_REQ_alpha_num );
		$this->set_rules( 'login_pass', HSK_RULE_REQ_alpha_num );

		// バリデーションエラー
		if( get_instance()->form_validation->run() === FALSE )
		{
			return FALSE;
		}

	return TRUE;
	}
}
