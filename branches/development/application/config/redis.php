<?php
defined('BASEPATH') OR exit('No direct script access allowed');


switch (ENVIRONMENT)
{
	case 'development':
		// 開発環境
		$config[ 'cache' ] = array(
				'hostname' => '127.0.0.1',
				'port'     => 6379,
				'db_idx'   => 0,
			);
	break;

	case 'staging':
		// ステージング
		$config[ 'cache' ] = array(
				'hostname' => '127.0.0.1',
				'port'     => 6379,
				'db_idx'   => 0,
			);
	break;

	case 'production':
		// 本番環境用設定
		$config[ 'cache' ] = array(
				'hostname' => '127.0.0.1',
				'port'     => 6379,
				'db_idx'   => 0,
			);
	break;
}
