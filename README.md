# Atte
打刻によりユーザーの勤怠を管理できるシステムです。

TOPページ
<img width="1367" alt="atte-top-page" src="https://github.com/user-attachments/assets/a0700ac9-e2b1-482b-a4ad-95d65330fca4">

各ボタンをクリックすると、打刻ボタンが切り替わります。
<br>
例：勤務開始ボタンクリック時
<img width="1368" alt="atte-top-page ボタン切り替え" src="https://github.com/user-attachments/assets/cc2ccf60-d089-485f-8630-ab7d04927bd5">


例：勤務終了ボタンクリック時
<img width="1472" alt="atte-top-page 勤務終了" src="https://github.com/user-attachments/assets/54fffbe6-48bd-4410-ba01-68c57c26bee4">
<br>

## 作成した目的
学習のアウトプットのため
<br>
<br>

## 機能一覧
  * 認証機能
    * 会員登録
    * ログイン
    * メール認証
    * ログアウト

   
  * 打刻機能
    * 重複してボタンを押さないよう、勤怠ボタンを切り替える。
    * 日をまたいだ時点で翌日の出勤操作に切り替える
      
  * 日付毎の勤務データ閲覧
    * その日に勤務したユーザーと勤務時間を表示(勤務開始、勤務終了、休憩時間合計、勤務時間) 
    * 検索ボタンにより前日、翌日のデータを検索できる

  * ユーザー一覧データ閲覧
    * 現時点の登録ユーザー情報一覧(名前や登録年月日、勤務状態を表示)
    * 検索機能
    * ユーザー情報の更新、削除機能

  * ユーザー毎の勤怠表閲覧
    * ユーザーの勤怠表を月毎に表示(勤務開始、勤務終了、休憩時間合計、勤務時間)
    * 検索ボタンにより前月、翌月のデータを検索できる
    * ユーザー検索機能
<br>
<br>
   
## 使用技術
Laravel Framework 8.83.8
<br>
php 8.3.8
<br>
mysql 8.0.26
<br>
<br>

## テーブル設計
<img width="704" alt="atte-table-list" src="https://github.com/user-attachments/assets/d70fae87-0b44-48a3-872e-a344e7bc9490">
<br>
<br>

## ER図
![ER図](src/atte.drawio.png)
