<?php
require "./vendor/autoload.php";

// .envを使用する
Dotenv\Dotenv::createImmutable(__DIR__)->load();

use atomita\Backlog;
use atomita\BacklogException;

$apiKey = $_ENV['APIKEY'];

$issueList = [
//    "【API】テーブル構成変更対応",
//    "【API】テーブルリレーション作成",
    "【API】媒体",
    "【API】成約",
    "【API】案件(希望条件)",
    "【API】顧客アクション(顧客履歴)",
    "【API】ログイン",
    "【API】各環境準備",
    "【API】テスト 調整"
];

$issuePostResult = [];

// 23786916=[フェーズ1.2] 山内
$yamauchi = ["parentIssueId" => 23786916, "assigneeId" => "291862"];

// 23717523=[フェーズ1.2 画面　山本]
$yamamoto = ["parentIssueId" => 23717523, "assigneeId" => "405288"];

// 23838235=【フェーズ1.2】合田
$goda = ["parentIssueId" => 23838235, "assigneeId" => "184031"];

$config = $yamamoto;

$backlog = new Backlog('eyemovic', $apiKey);
try {
    foreach ($issueList as $issue) {
        $result = issuePost($backlog, $issue);
        array_push($issuePostResult, $result["issueKey"]);
    }
    var_dump($issuePostResult);
//
//    foreach ($issuePostResult as $issueKey) {
//        $issueDeleteResult = issueDelete($backlog, $issueKey);
//    }

//    // 個別に消したい時
//    $issueDeleteResult = issueDelete($backlog, "SUMITAS_KOKYAKU-401");


//    $issueGetResult = issueGet($backlog, "SUMITAS_KOKYAKU-399");
//    var_dump($issueGetResult);

} catch (BacklogException $e) {
    var_dump($e);

// error
}

function issuePost(Backlog $backlog, $summary)
{
    return $backlog->issues->post(
        [
            "projectId" => 155808,
            "summary" => $summary,

            "parentIssueId" => $GLOBALS['config']['parentIssueId'],

            "issueTypeId" => 777908,
            "priorityId" => 3,
            "startDate" => "2021-12-01",
            "dueDate" => "2021-12-01",

            "assigneeId" => $GLOBALS['config']['assigneeId'],

            // 288771=フェーズ1.2
            "milestoneId[]" => 288771
        ]
    );
}

function issueDelete(Backlog $backlog, $issueKey)
{
    return $backlog->issues->param($issueKey)->delete();
}

function issueGet(Backlog $backlog, $issueKey)
{
    return $backlog->issues->param($issueKey)->get();
}
