<?php
require_once("../loader.php");

$data = array();
$appSecret = APP_SECRET;
$data["app_id"] = APP_ID;
$data["timestamp"] = time() * 1000;
$data["app_sign"] = md5($data["app_id"] . $data["timestamp"] . $appSecret);
$data["total_fee"] = 100;
$data["desc"] = "transfer test";

$type = $_GET['type'];
switch($type) {
    case 'WX_REDPACK' :
        $title = '微信红包'; //单个微信红包金额介于[1.00元，200.00元]之间
        $data["transfer_no"] = "".time();//微信要求10位数字
        $data["channel_user_id"] = '';  //微信用户openid o3kKrjlROJ1qlDmFdlBQA95kvbN0
        $data["channel"] = "WX_REDPACK";
        $data["redpack_info"] = (object)array(
            "send_name" => "BeeCloud",
            "wishing" => "test",
            "act_name" => "testA"
        );
        break;
    case 'WX_TRANSFER' :
        $title = '微信企业打款';
        $data["transfer_no"] = "".time();//微信要求10位数字
        $data["channel"] = "WX_TRANSFER";
        $data["channel_user_id"] = '';   //微信用户openid o3kKrjlROJ1qlDmFdlBQA95kvbN0
        break;
    case 'ALI_TRANSFER' :
        $title = '支付宝企业打款';
        $data["channel"] = "ALI_TRANSFER";
        $data["transfer_no"] = "trans" . time();

        //收款方的id 账号和 名字也需要对应
        $data["channel_user_id"] = '';   //收款人账户
        $data["channel_user_name"] = ''; //收款人账户姓名

        $data["account_name"] = "苏州比可网络科技有限公司"; //注意此处需要和企业账号对应的全称
        break;
    case 'ALI_TRANSFERS' :
        $title = '支付宝批量打款';
        $data["channel"] = "ALI";
        $data["batch_no"] = "bcdemo" . $data["timestamp"];
        $data["account_name"] = "苏州比可网络科技有限公司";
        $data["transfer_data"] = array(
            (object)array(
                "transfer_id" => "bf693b3121864f3f969a3e1ebc5c376a",
                "receiver_account" => "", //收款方账户
                "receiver_name" =>"",     //收款方账号姓名
                "transfer_fee" => 1,      //打款金额，单位为分
                "transfer_note" => "test"
            ),
            (object)array(
                "transfer_id" => "bf693b3121864f3f969a3e1ebc5c3768",
                "receiver_account" => "",
                "receiver_name" =>"",
                "transfer_fee" => 1,
                "transfer_note" => "test"
            )
        );
        break;
    case 'BC_TRANSFER' :
        unset($data['desc']);
        $data["bill_no"] = "bcdemo" . $data["timestamp"];
        $data["title"] = "白开水";
        $data["trade_source"] = "OUT_PC";
        $data["bank_code"] = "BOC";   //银行缩写编码
        $data["bank_associated_code"] = "104305045476"; //银行联行行号 eg:104305045476 中国银行股份有限公司苏州跨塘支行
        $data["bank_fullname"] = "中国银行"; //银行全称
        $data["card_type"] = "DE"; //银行卡类型,区分借记卡和信用卡，DE代表借记卡，CR代表信用卡，其他值为非法
        $data["account_type"] = "P"; //帐户类型，P代表私户，C代表公户，其他值为非法
        $data["account_no"] = "";   //收款方的银行卡号
        $data["account_name"] = ""; //收款方的姓名或者单位名
        //选填mobile
        $data["mobile"] = ""; //银行绑定的手机号
        //选填optional
        $data["optional"] = (object)array("tag"=>"msgtoreturn"); //附加数据
        break;
    default :
        exit("No this type.");
        break;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>BeeCloud<?php echo $title; ?>示例</title>
</head>
<body>
<?php
    try {
        switch($type){
            case 'ALI_TRANSFERS':
                $result = $api->transfers($data);
                break;
            case 'BC_TRANSFER':
                $result = $api->bc_transfer($data);
                break;
            default :
                $result = $api->transfer($data);
                break;

        }
        if ($result->result_code != 0) {
            print_r($result);
            exit();
        }
        if(isset($result->url)){
            header("Location:$result->url");
        }else{
            echo '下发成功!';
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
?>
</body>
</table>
</body>
</html>