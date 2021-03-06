<?php
header("Content-Type: text/html;charset=utf-8");
ini_set('date.timezone','Asia/Shanghai');

$orderModel = $this->getModel('order');

$id = $this->getParam('id');

exit($id);

if ($id) {
    $tmp_order = $orderModel->getById($id);

//    $this->view->model = $order;
}

//error_reporting(E_ERROR);
require_once '/var/www/yj/public/lib/WxPay.Api.php';
require_once '/var/www/yj/public/WxPay.JsApiPay.php';
require_once '/var/www/yj/public/log.php';

//初始化日志
$logHandler= new CLogFileHandler("/var/www/yj/public/logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data) {
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();

$openId = $tmp_order->customer->openid;//$tools->GetOpenid();"ovaVFs0D8661cy-w7C8o61Yd7p08";//

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody($tmp_order->teacher->name . "导师瑜伽授课费用");
$input->SetAttach("");

$tmp = WxPayConfig::MCHID . $tmp_order->id;

$out_trade_no = substr($tmp, 0, 32);

$input->SetOut_trade_no($out_trade_no);
$input->SetTotal_fee($tmp_order->pay_amount);//$this->model->pay_amount

$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("");

$input->SetNotify_url("http://www.yujiaqu.com/payNotify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);

$order = WxPayApi::unifiedOrder($input);

//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);

//exit(date("YmdHis"));
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>
<script type="text/javascript">
    //调用微信JS api 支付
    function jsApiCall() {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function(res){
                WeixinJSBridge.log(res.err_msg);
//                alert(res.err_code+res.err_desc+res.err_msg);
            }
        );
    }

    function callpay() {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        }else{
            jsApiCall();
        }
    }

    //获取共享地址
    function editAddress() {
        WeixinJSBridge.invoke(
            'editAddress',
            <?php echo $editAddress; ?>,
            function(res){
                var value1 = res.proviceFirstStageName;
                var value2 = res.addressCitySecondStageName;
                var value3 = res.addressCountiesThirdStageName;
                var value4 = res.addressDetailInfo;
                var tel = res.telNumber;

//                alert(value1 + value2 + value3 + value4 + ":" + tel);
            }
        );
    }

    window.onload = function() {
        if (typeof WeixinJSBridge == "undefined"){
            if( document.addEventListener ){
                document.addEventListener('WeixinJSBridgeReady', editAddress, false);
            }else if (document.attachEvent){
                document.attachEvent('WeixinJSBridgeReady', editAddress);
                document.attachEvent('onWeixinJSBridgeReady', editAddress);
            }
        }else{
            editAddress();
        }
    };

    callpay();
</script>

<style>
    body {
        background:#555;
        color:#FFF;
    }
    .p0y-c1 {
        padding:80px 0;
    }
    .p0y-c1 .spin {
        width:60px;
    }
    .p0y-c1 .txt {
        font-size:14px;
        padding:20px 0;
        line-height:24px;
    }
</style>

<div class="tc p0y-c1">
    <img class="spin" src="/img/loading-spin.svg" />
    <div class="txt">
        正在跳转至微信支付<br/>请稍后 ...
    </div>
</div>
<!--<br />-->
<!--<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">--><?php //echo $this->model->pay_amount ?><!--元</span>钱</b></font><br/><br/>-->
<!--<div align="center">-->
<!--    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>-->
<!--</div>-->