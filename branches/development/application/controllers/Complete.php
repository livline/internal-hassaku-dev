<?php
/**
 * 完了画面コントローラー
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Complete extends HSK_Controller
{

	public function index( $enc_caption, $enc_message, $enc_back_uri = NULL )
	{
		$caption = urlsafe_base64_decode( $enc_caption );
		$message = urlsafe_base64_decode( $enc_message );
		$back_uri = '';
		if( $enc_back_uri )
		{
			$back_uri = urlsafe_base64_decode( $enc_back_uri );
		}

		if( isset( $_SESSION[ 'user_id' ] ) )
		{
			$sess = $_SESSION;
		}
		else
		{
			$sess = NULL;
		}

		$this->contents_complete( $caption, $message, $sess, $back_uri );
	}

}
