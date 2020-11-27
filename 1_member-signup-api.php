<?php
include __DIR__ . '/1_parts/0_config.php';
// require __DIR__ . '/parts/admin-required.php';
$output = [
    'success' => false,
    'code' => 0,
    'error' => '哎呀! 您尚未完成表單資料填寫',
    'postData' => [],
];

if (empty($_POST['name']) && empty($_POST['account']) && empty($_POST['password']) && empty($_POST['checkpassword'])) {
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
    exit;
}

//TODO: 檢查資料格式

$sql = "INSERT INTO `kunsthaus`(
        `name`, `account`, `password`,`checkpassword`, 
        `mobile`, `address`
        ) VALUES (
        ?, ?, ?,
        ?, ?, ?, NOW()
    )";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $_POST['name'],
    $_POST['account'],
    $_POST['password'],
    $_POST['checkpassword'],
    $_POST['mobile'],
    $_POST['address'],
]);
if ($stmt->rowCount() == 1) {
    $output['success'] = true;
    $output['error'] = '';
    $output['info'] ='資料新增完成';
}
echo json_encode($output, JSON_UNESCAPED_UNICODE);
