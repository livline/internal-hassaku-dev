<?php

class HSK_Controller extends CI_Controller
{
	public $redis = NULL;

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 画面HTMLを組み立てる
	 *
	 * @param string $contents_tpl		コンテンツエリアテンプレート
	 * @param array $contents_data		コンテンツ置換データ
	 * @param array $header_data		ヘッダー置換データ
	 * @param bool $force_output		強制出力
	 * @return void
	 */
	public function make_html( $contents_tpl, $contents_data, $header_data = NULL, $force_output = FALSE )
	{
		if( $header_data === NULL )
		{
			$header_data[ 'is_sess' ] = FALSE;
		}
		else
		{
			$header_data[ 'is_sess' ] = TRUE;
		}

		$this->load->view( 'header', $header_data );
		$this->load->view( $contents_tpl, $contents_data );
		$this->load->view( 'footer' );

		// HTMLを出力し処理を終了する
		if( $force_output )
		{
			$this->output->_display();
			exit();
		}
	}

	/**
	 * 配列をJSONに変換しアウトプットする
	 *
	 * @param array $data		JSONに変換する配列
	 * @return void
	 */
	public function output_json( $data )
	{
		header( 'Content-Type: application/json; charset=utf-8' );
		echo json_encode( $data, JSON_UNESCAPED_UNICODE );
	}

	/**
	 * エラーJSONをアウトプットする
	 *
	 * @param string $error_message		エラーメッセージ
	 * @param int $error_code			エラーコード
	 * @return void
	 */
	public function error_json( $error_message, $error_code )
	{
		$ary = [ 'error_code' => $error_code, 'error_message' => $error_message ];
		header( 'Content-Type: application/json; charset=utf-8' );
		echo json_encode( $ary, JSON_UNESCAPED_UNICODE );
		exit();
	}

	/**
	 * コンテンツエラー画面HTMLを組み立てる
	 *
	 * @param array $error_message		エラーメッセージ
	 * @param int $error_code			エラーコード
	 * @param array $header_data		ヘッダー置換データ
	 * @param array $back_url			戻るリンクURL指定 デフォルトhistory.back()
	 * @return bool
	 */
	public function contents_error( $error_message, $error_code, $header_data = NULL, $back_url = NULL )
	{
		$error[ 'error_message' ] = $error_message;
		$error[ 'error_code' ] = $error_code;
		if( $back_url )
		{
			$error[ 'back_url' ] = $back_url;
		}

		if( $header_data === NULL )
		{
			$header_data[ 'is_sess' ] = FALSE;
		}
		else
		{
			$header_data[ 'is_sess' ] = TRUE;
		}

		$this->load->view( 'header', $header_data );
		$this->load->view( 'errors/common_error/common_error', $error );
		$this->load->view( 'footer');

		$this->output->_display();
		exit();
	}

	/**
	 * 完了画面HTMLを組み立てる
	 *
	 * @param string $caption			見出し
	 * @param string $message			メッセージ
	 * @param array $header_data		ヘッダー置換データ
	 * @param string $back_url			戻るリンクURL指定 デフォルトhistory.back()
	 * @return void
	 */
	public function contents_complete( $caption, $message, $header_data = NULL, $back_url = NULL )
	{
		$str[ 'caption' ] = $caption;
		$str[ 'message' ] = $message;

		if( $back_url )
		{
			$str[ 'back_url' ] = $back_url;
		}

		if( $header_data === NULL )
		{
			$header_data[ 'is_sess' ] = FALSE;
		}
		else
		{
			$header_data[ 'is_sess' ] = TRUE;
		}

		$this->load->view( 'header', $header_data );
		$this->load->view( 'complete', $str );
		$this->load->view( 'footer');

		$this->output->_display();
		exit();
	}

	/**
	 * 完了画面コントローラーにリダイレクトさせる
	 *
	 * @param string $caption			見出し
	 * @param string $message			メッセージ
	 * @param string $back_url			戻るリンクURL指定 デフォルトhistory.back()
	 * @return void
	 */
	public function redirect_complete( $caption, $message, $back_url = NULL )
	{
		$this->load->helper( 'url' );

		$enc_caption = urlsafe_base64_encode( $caption );
		$enc_message = urlsafe_base64_encode( $message );
		$enc_back_url = '';
		if( $back_url )
		{
			$enc_back_url = urlsafe_base64_encode( $back_url );
		}
		redirect( '/complete/index/'.$enc_caption.'/'.$enc_message.'/'.$enc_back_url );
	}

	/**
	 * Redisサーバーに接続する
	 *
	 * 要件:phpredis
	 *
	 * @param string $db_name		config/redis.phpの設定グループ指定
	 * @return bool
	 */
	public function redis_connect( $db_name )
	{
		$this->config->load( 'redis', true);
		$rd_config = $this->config->item( 'redis' );

		$this->redis = new Redis;
		try
		{
			$this->redis->connect( 
						$rd_config[ $db_name ][ 'hostname' ],
						$rd_config[ $db_name ][ 'port' ]
			);
		}
		catch( Exception $e )
		{
			log_message( 'ERROR', 'HSK_Controller/redis_connect: redis connect error! error_message='.$e->getMessage() );
		return FALSE;
		}

		$sel_res = $this->redis->select( $rd_config[ $db_name ][ 'db_idx' ] );
		if( $sel_res === FALSE )
		{
			return FALSE;
		}

		$this->redis->$db_name = $this->redis;

		log_message( 'INFO', '---------------- Redis Connect. '.$db_name  );

	return TRUE;
	}

	/**
	 * QRコードを生成する
	 *
	 * 要件:GD, pear Image_QRCode, libpng
	 *
	 * pear install Image_QRCode-0.1.3
	 *
	 * @param string $str		QRコードに埋め込む文字列
	 * @param int $size			QRコードのサイズ
	 * @return resource
	 */
	public function make_qrcode( $str, $size = 14 )
	{
	require_once( 'Image/QRCode.php' );

		$qr = new Image_QRCode();
		$option = array(
				'module_size'	=> 14,
				'image_type'	=> 'png',
				'output_type'	=> 'return',
				'error_correct'	=> 'H'
		);

		$qrode_image = $qr->makeCode( $str, $option );

		ob_start();
		imagepng( $qrode_image, NULL );
		$qrode = ob_get_clean();

	return $qrode;
	}

	/**
	 * SendGridによるメール送信
	 *
	 * 要件:composer, Dotenv, SendGrid PHP SDK
	 *
	 * @param string $to		送信先メールアドレス
	 * @param string $subject	メール件名
	 * @param string $body		メール本文
	 * @param string $sender	送信元メールアドレス
	 * @return bool				メール送信成功時true
	 */
	public function sendgrid_mail_send( $to, $subject, $body, $sender, array $cc = [] )
	{
	require VENDOR_DIR.'/autoload.php';

		// Load our `.env` variables
		$dotenv = Dotenv\Dotenv::createImmutable( __DIR__ );
		$dotenv->load();

		// Declare a new SendGrid Mail object
		$email = new \SendGrid\Mail\Mail();

		// Set the email parameters
		$email->setFrom( $sender );
		$email->setSubject( $subject );
		$email->addTo( $to );
		foreach( $cc as $ccaddress )
		{
			$email->addCc( $ccaddress );
		}
		$email->addContent( "text/plain", $body );
		$sendgrid = new \SendGrid( $_ENV[ 'SENDGRID_API_KEY' ] );
		// Send the email
		try
		{
		   $response = $sendgrid->send( $email );
		}
		catch ( Exception $e )
		{
			log_message( 'ERROR', 'HSK_Controller/sendgrid_mail_send: mail send error! error_message='.$e->getMessage() );
		return FALSE;
		}

	return TRUE;
	}

	// ルームID確認用
	public function get_chatwork_rooms( $token )
	{
		$header = array(
					'X-ChatWorkToken: '.$token
					);

		$url = 'https://api.chatwork.com/v2/rooms';

		$res = $this->chatwork_curl( $url, METHOD_GET, NULL, $header );
		$res_array = json_decode( $res[ 1 ], TRUE );
		print_r($res_array);
	}

	/**
	 * チャットワークの指定ルームにメッセージを送信する
	 *
	 * 要件:CURL
	 *
	 * @param string $token			チャットワークAPIトークン
	 * @param int $room_id			メッセージを送信するルームID
	 * @param string $message		メッセージ
	 * @return bool
	 */
	public function send_chatwork_message( $token, $room_id, $message )
	{
		$header = array(
					'X-ChatWorkToken: '.$token
					);

		$url = 'https://api.chatwork.com/v2/rooms/'.$room_id.'/messages';

		$res = $this->chatwork_curl( $url, METHOD_POST, [ 'body' => $message ], $header );
		$res_array = json_decode( $res[ 1 ], TRUE );
		if( isset( $res[ 1 ][ 'errors' ] ) )
		{
			log_message( 'ERROR', 'HSK_Controller/get_chatwork_send_message: send message error! error_message='.$res[ 1 ][ 'errors' ] );
		return FALSE;
		}
	return TRUE;
	}

	private function chatwork_curl( $url, $method, $data = NULL, $header = NULL )
	{
		$curl = curl_init();

		if( $data )
		{
			curl_setopt( $curl, CURLOPT_URL, $url.'?'.http_build_query( $data ) );
		}
		else
		{
			curl_setopt( $curl, CURLOPT_URL, $url );
		}

		if( $header )
		{
			curl_setopt( $curl, CURLOPT_HTTPHEADER, $header );
		}

		if( $method == METHOD_GET )
		{
			curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, 'GET' );
		}
		else if( $method == METHOD_POST )
		{
			curl_setopt( $curl, CURLOPT_POST, TRUE );
		}

		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, FALSE );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 60 );

		$response = curl_exec( $curl );
		$info = curl_getinfo( $curl );
		curl_close( $curl );

	return array( $info, $response );
	}

	/**
	 * ランダムな英数文字列を生成する。
	 *
	 * @param int $len				生成する文字列の文字数
	 * @param string $exclusion		除外する文字列（ IとlとOと0を除外したい場合、make_randstr( $len, 'IlO0' ) と指定）
	 * @return bool
	 */
	public function make_randstr( $len, $exclusion = 'IlO0' )
	{
		$str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

		$exclusion_len = strlen( $exclusion );

		$randstr = '';
		for( $i = 0; $i < $len; ++$i )
		{
			$rand_num = mt_rand( 0, 61 );
			$_tmp = substr( $str, $rand_num, 1 );

			for( $x = 0; $x < $exclusion_len; ++$x )
			{
				$_exc = substr( $exclusion, $x, 1 );
				if( $_tmp == $_exc )
				{
					--$i;
				continue 2;
				}
			}

			$randstr .= substr( $str, $rand_num, 1 );
		}

	return $randstr;
	}

	/**
	 * ユーザーのbit値が許可されているbit値かどうか判定
	 *
	 * e.x. 
	 * define('BIT_ADMIN',	1);
	 * define('BIT_USER',	2);
	 * define('BIT_GUEST',	4);
	 * 
	 * $boolean = permission_check( $user_bit, BIT_USER | BIT_GUEST );
	 *
	 * @param int $user_bit			ユーザーのアカウント区分(bit値)
	 * @param int $ok_bit			許可するアカウント区分(bit値)
	 * @return bool
	 */
	public function permission_check( $user_bit, $ok_bit )
	{
		if( ( $user_bit & ( ACCOUNT_KIND_SU | $ok_bit ) ) > 0  )
		{
			return TRUE;
		}

	return FALSE;
	}


	/**
	 * エクセルファイルをPDFに変換
	 *
	 * 要件:libreoffice(yum install -y libreoffice libreoffice-langpack-ja)
	 * 		IPAfont,IPAexfont
	 *
	 * @param string $excel_filepath	エクセルファイルのフルパス
	 * @param string $output_filename	出力するPDFファイルのファイル名
	 * @param string $output_dir		PDFを出力するディレクトリ
	 * @return string					出力したPDFファイルのフルパス
	 */
	public function conv_excel2pdf( $excel_filepath, $output_filename, $output_dir = '/tmp' )
	{
		// ソースエクセルファイルの拡張子を取得
		$src_ext = pathinfo( $excel_filepath, PATHINFO_EXTENSION );

		// 出力ファイル名に拡張子が付いているか
		$dst_ext = pathinfo( $output_filename, PATHINFO_EXTENSION );
		if( $dst_ext )
		{
			// 拡張子が付いていた場合は消す
			$output_filename = str_replace( '.'.$dst_ext, '', $output_filename );
		}

		// 出力ディレクトリの最後にスラッシュが付いていたら消す
		$output_dir = rtrim( $output_dir, '/' );

		// ソースエクセルファイルをファイル名を変更してコピー
		$cp_file = $output_dir.'/'.$output_filename.'.'.$src_ext;
		if( !copy( $excel_filepath, $cp_file ) )
		{
			log_message( 'ERROR', 'HSK_Controller/conv_excel2pdf: file copy error!! src='.$excel_filepath.' dst='.$cp_file );
			return FALSE;
		}

		exec( 'export HOME=/var/tmp;libreoffice --headless --nologo --nofirststartwizard --convert-to pdf --outdir '.$output_dir.' '.$cp_file, $output, $ret );
		if( $ret != 0 )
		{
			log_message( 'ERROR', 'HSK_Controller/conv_excel2pdf: libreoffice execute error!! output_dir='.$output_dir.' cp_file='.$cp_file );
			return FALSE;
		}

		unlink( $cp_file );

		return $output_dir.'/'.$output_filename.'.pdf';
	}

	/**
	 * アクセス元のIPアドレスを取得
	 *
	 * ロードバランサを使用している場合はHTTP_X_FORWARDED_FORを返す
	 *
	 * @return string
	 */
	public function get_real_ipaddress()
	{
		if( isset( $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ) && $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] != '' )
		{
			return $_SERVER[ 'HTTP_X_FORWARDED_FOR' ];
		}

		return $_SERVER[ 'REMOTE_ADDR' ];
	}

	public function alpha_numeric_symbol( $str )
	{
	    if( preg_match( '/^[!-~]+$/', $str ) )
		{
	        return TRUE;
	    }

		return FALSE;
	}
}