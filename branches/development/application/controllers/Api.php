<?php
/**
 * APIコントローラー サンプル
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends HSK_Controller
{

	public $common_db = NULL;

	public function echoback()
	{
		$json = $this->input->raw_input_stream;

		$json_array = json_decode( $json, TRUE );

		$this->output_json( $json_array );
	}
}
