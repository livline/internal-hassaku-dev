<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/


$hook['post_controller_constructor'] = array(
  'class'     => 'HSK_session', // 呼ぶクラス名
  'function'  => 'start', // 呼ぶメソッド
  'filename'  => 'HSK_session.php', // ファイル名
  'filepath'  => 'hooks' // applicationフォルダからの相対パス
);

$hook['post_controller'] = array(
  'class'     => 'HSK_session', // 呼ぶクラス名
  'function'  => 'sess_time_update', // 呼ぶメソッド
  'filename'  => 'HSK_session.php', // ファイル名
  'filepath'  => 'hooks' // applicationフォルダからの相対パス
);