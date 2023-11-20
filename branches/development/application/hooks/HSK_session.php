<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HSK_session
{
	private $CI;


	public function __construct()
	{
		// CIオブジェクトを取得
		$this->CI =& get_instance();
	}

	public function start()
	{
		$class = $this->CI->router->class;
		$method = $this->CI->router->method;

		log_message( 'INFO', '======== execute controller class='.$class.' action='.$method );

		// セッション外のページ
		$nosess = FALSE;
		$cnt = count( NO_SESSION );
		for( $i = 0; $i < $cnt; ++$i )
		{
			if( NO_SESSION[ $i ][ 'method' ] == '*' )
			{
				if( $class == NO_SESSION[ $i ][ 'class' ] )
				{
					$nosess = TRUE;
				break;
				}
			}
			else
			{
				if( ( $class == NO_SESSION[ $i ][ 'class' ] && $method == NO_SESSION[ $i ][ 'method' ] ) )
				{
					$nosess = TRUE;
				break;
				}
			}
		}

		// セッションを開始する
		if( !$nosess )
		{
			ini_set( 'session.cookie_lifetime', COOKIE_LIFETIME );
			ini_set( 'session.gc_maxlifetime', GC_MAXLIFETIME );
			ini_set( 'session.serialize_handler', 'php_serialize' );
			// セッションIDをログインIDにする
			if( $class == LOGIN_CLASS && $method == LOGIN_METHOD )
			{
				$sess_id = '';
				if( defined( 'PROJECT_DIR' ) )
				{
					$sess_id = PROJECT_DIR.':';
				}
				$sess_id .= $_POST[ LOGINFORM_LOGINID_NAME ];
				session_id( $sess_id );
			}
			session_cache_limiter( 'none' );
			session_name( SESS_COOKIE_NAME );
			session_start();

			if( !( $class == LOGIN_CLASS && $method == LOGINFORM_METHOD )
				&& !( $class == COMPLETE_CLASS )
			 )
			{
				// ログイン処理以外でセッションが無ければログイン画面に戻す
				if( !( $class == LOGIN_CLASS && $method == LOGIN_METHOD ) )
				{
					$this->CI->load->helper( 'url' );
					if( !isset( $_SESSION[ 'user_id' ] ) )
					{
						session_destroy();
						$_uri = $_SERVER[ 'REQUEST_URI' ];
						$uri = urlsafe_base64_encode( $_uri );
						header( 'Location: '.base_url().LOGIN_CLASS.'/'.LOGINFORM_METHOD.'/'.$uri );
					exit;
					}

					if( $_SESSION[ 'last_access' ] < ( time() - HSK_SESS_LIFETIME ) )
					{
						// HSKセッションの有効期限を無視
						$nolimit = FALSE;
						$cnt = count( NO_LIMIT );
						for( $i = 0; $i < $cnt; ++$i )
						{
							if( NO_LIMIT[ $i ][ 'method' ] == '*' )
							{
								if( $class == NO_LIMIT[ $i ][ 'class' ] )
								{
									$nolimit = TRUE;
								break;
								}
							}
							else
							{
								if( ( $class == NO_LIMIT[ $i ][ 'class' ] && $method == NO_LIMIT[ $i ][ 'method' ] ) )
								{
									$nolimit = TRUE;
								break;
								}
							}
						}

						if( !$nolimit )
						{
							log_message( 'INFO', '======== session lifetime orver. user_id='.$_SESSION[ 'user_id' ] );
							session_destroy();
							$_uri = $_SERVER[ 'REQUEST_URI' ];
							$uri = urlsafe_base64_encode( $_uri );
							header( 'Location: '.base_url().LOGIN_CLASS.'/'.LOGINFORM_METHOD.'/'.$uri );
						exit;
						}
					}
				}
			}
		}
	}

	public function sess_time_update()
	{
		if( isset( $_SESSION[ 'last_access' ] ) )
		{
			$_SESSION[ 'last_access' ] = time();
		}
	}
}
