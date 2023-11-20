<?php
/**
 * ダッシュボードコントローラー
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends HSK_Controller
{

	public $common_db = NULL;

	// ダッシュボード画面
	public function index()
	{
		$this->make_html( 'dashboard', NULL, $_SESSION );
	}
}
