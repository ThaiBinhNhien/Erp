<?php
/**
 *
 * @package	Message
 *
 * Setting : $lang['KEY'] = 'VALUE'
 * Use: $this->lang->line('KEY')
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['message_remove_success'] = '削除しました。';
$lang['message_remove_error'] = '削除に失敗しました。';
$lang['message_delete_success'] = '削除しました。';
$lang['message_delete_error'] = '削除に失敗しました。';
$lang['message_edit_success'] = '更新しました。';
$lang['message_edit_error'] = '更新に失敗しました。';
$lang['message_add_success'] = '追加しました。';
$lang['message_add_error'] = '追加に失敗しました。';
$lang['message_has_update_before'] = 'データが更新されました。ページをロードして再度入力してください。';
$lang['message_exits_id_error'] = '指定したコードは既に存在しています。違うコードを指定してください。';
$lang['message_exits_buy_id_error'] = 'この仕入商品コードはすでに存在しています。違うコードを指定してください。';
$lang['message_exits_sell_id_error'] = 'この売上商品コードはすでに存在しています。違うコードを指定してください。';
$lang['message_error_ajax'] = 'サーバ接続でエラーが発生しました。';
$lang['message_error_delivery_date_null'] = '納品日を指定してください。';
$lang['message_error_delivery_date_faild'] = '納品日が正しくありません。';
$lang['message_error_select_date_checklist'] = '売上（納品）日を指定してください';
$lang['message_edit_delivery_detail_error'] = '保存に失敗しました。再度実行してください。';
$lang['message_error_not_select_report'] = "帳票を指定してください。";
$lang['message_error_not_select_date_report'] = "期間を指定してください。";
$lang['message_error_data_null'] = "\u30C7\u30FC\u30BF\u306F\u3042\u308A\u307E\u305B\u3093\u3002"; // データはありません。
$lang['message_error_requeird_value'] = "{0}は必須です。ご入力ください。";
$lang['message_delete_product'] = "経営中止品";

/* Shipment */
$lang['message_check_container_error'] = '右側のコンテナ番号は左側のコンテナ番号以上の値で入力してください。';
$lang['message_not_select_set_error'] = '商品セット名またはマイワンタッチを指定してください。';
$lang['message_check_isNull_quantity_error'] = '出荷数を入力してください。';
$lang['message_check_isNull_container_error'] = 'コンテナを数値で入力してください。';
$lang['message_check_total_error'] = 'トラックの最大積載量を越えています。';
$lang['message_title_add_shipment'] = '発注確定します。よろしいでしょうか？';
$lang['message_fix_number_shipment'] = '出荷確定します。よろしいでしょうか？';
$lang['message_not_select_row'] = '削除対象の行を選択してください。';
$lang['message_title_delete'] = '出荷伝票を削除してもよろしいでしょうか？';
$lang['message_incorrect_quantity'] = '納品数は注文数以下の数値で入力してください。';
$lang['message_incorrect_quantity_shipment'] = '出荷数は注文数以下の数値で入力してください。';
$lang['message_not_no_container'] = 'ｺﾝﾃﾅNoは指定の場合は「1-5，14等」と入力';
$lang['message_shipment_error_product_setproduct'] = 'この商品セット又はマイワンタッチに商品がありません。他のを選択してください。';
$lang['message_not_add_detail'] = '出荷情報を入力してください。';
$lang['message_add_detail_change_shipping'] = '配送便を変更すると下記選択した商品が全てリセットされます。よろしいでしょうか？';
$lang['message_check_confirmed_shipment'] = 'この伝票は出荷確定されました。編集出来ません。'; // Hóa đơn này đã được xuất hàng. Không thể chỉnh sửa

// 営業管理
$lang['message_error_not_select_time_exp'] = '帳票の期間及び種類 (日報、旬報、月報、年報)を選択してください。';
$lang['message_error_exits_insert_price'] = '該当の単価がすでに存在しています。更新してもよろしいでしょうか？';
$lang['message_confirm_delete_field'] = "{0}を削除してよろしいでしょうか？"; //削除します。よろしいですか？
$lang['message_confirm_save_field'] = '保存します。よろしいでしょうか？'; //保存します。よろしいですか？

// User
$lang['invalid_user_registration'] = 'ユーザID及びパスワードを入力してください。';
$lang['password-not-match-confirm'] = 'パスワードが確認用パスワードと一致していません。';
$lang['user_not_found'] = 'ユーザが存在していません。';
$lang['user_existed'] = 'このユーザ名は既に使われています。';

$lang['added_successfully'] = 'ユーザを新規追加しました。';
$lang['updated_successfully'] = 'ユーザ情報を更新しました。';

$lang['message_import_success'] = 'CSVのインポートは完了しました。';
$lang['message_import_error'] = 'CSVのインポートに心配しました。CSVフォーマットを確認して、再度実行してください。';

// check list
$lang['message_success_select_date_checklist'] = 'チェックリストを更新しました。';
$lang['message_success_checklist_diff_search'] = 'ご指定の検索条件以外で、未チェックの伝票が存在しています。';
$lang['message_checklist_success'] = 'チェックリストを更新しました。';
$lang['message_error_not_checked'] = 'チェックした商品がありません。';
$lang['message_error_not_data_checked'] = '検索結果が見つかりません。';
$lang['message_title_confirm_checklist'] = '注文伝票（チェックリスト）を保存します。よろしいですか？';

// shipment
$lang['message_not_select_container_error'] = 'コンテナを入力してください。';
$lang['message_error_not_select_date_import_inventory'] = '入庫年月を指定してください。';
$lang['message_not_exits_container'] = 'この出荷伝票ではこのコンテナNoが使用されていません。';
$lang['message_error_max_container'] = 'コンテナ上限数の値（100）以下で番号を入力してください。';
$lang['message_error_multiples_product'] = '商品 {0}の発注数は結束単位（{1}）の倍数ではないのですが、そのまま発注しましょうか？'; 

// Mua vào
$lang['message_not_select_check_price'] = "単価チェックの対象伝票を選択してください。";
$lang['message_success_select_check_price'] = "単価チェックを行いました。";
$lang['message_success_update_check_price'] = "単価チェッリストを更新しました。";

//Delivery
$lang['message_fix_confirm_delivery'] = "納品・売上処理を行います。<br>よろしいですか？";
$lang['message_copy_order_to_shipment_title'] = "受発注に注文内容を取り込みます。よろしいでしょうか？"; //Bạn muốn copy order sang shipment hay không ?
$lang['message_copy_order_to_shipment_error'] = "受発注に注文内容の取り込みに失敗しました。"; //Copy order sang shipment thất bại.
$lang['message_copy_order_to_shipment_success'] = "受発注に注文内容を取り込みました。"; //Copy order sang shipment thành công.
$lang['message_copy_order_to_shipment_error_department'] = "受発注のマスターに99番の部署が見つかりません。受発注に注文内容の取り込みに失敗しました。"; //không có department 99. copy thất bại

// Master
$lang['message_add_error_price_gaichyn'] = "外注の単価は売上単価の数値以下で入力してください。";
$lang['message_is_exits_set_product'] = "この連番は既存しました。他連番を入力してください。";
$lang['message_is_product_not_null_stt'] = "連番を入力してください。";
$lang['message_error_requeird_product'] = "商品は必須です。ご入力ください。";

//add new C
$lang['message_exits_name_product_error'] = "重複した商品（{0}）があります。 再度選択してください";
//"{0}を削除してよろしいでしょうか？";//削除します。よろしいですか？
$lang['message_empty_data'] = "検索条件に該当するデータはありません。";

$lang['message_error_data_updated'] = "データが更新されました。ページをロードして再度入力してください。";

// Order
$lang['message_not_redirect_to_delivery'] = "チェックリストされました。編集出来ません。";