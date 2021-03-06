<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
    <style>
        #mcover {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            z-index: 20000;
        }
        #mcover img {
            position: fixed;
            right: 18px;
            top: 5px;
            width: 260px!important;
            height: 180px!important;
            z-index: 20001;
        }
        .text {
            margin: 15px 0;
            font-size: 14px;
            word-wrap: break-word;
            color: #727272;
        }
        #mess_share {
            margin: 15px 0;
            display: block;
        }
        #share_1 {
            float: left;
            width: 49%;
            display: block;
        }
        #share_2 {
            float: right;
            width: 49%;
            display: block;
        }
        .clr {
            display: block;
            clear: both;
            height: 0;
            overflow: hidden;
        }
        .button2 {
            font-size: 16px;
            padding: 8px 0;
            border: 1px solid #adadab;
            color: #000000;
            background-color: #e8e8e8;
            background-image: linear-gradient(to top, #dbdbdb, #f4f4f4);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.45), inset 0 1px 1px #efefef;
            text-shadow: 0.5px 0.5px 1px #fff;
            text-align: center;
            border-radius: 3px;
            width: 100%;
        }
        #mess_share img {
            width: 22px!important;
            height: 22px!important;
            vertical-align: top;
            border: 0;
        }
    </style><script type="text/javascript">
        function button1(){
            $("#mcover").css("display","block")    // 分享给好友按钮触动函数
        }
        function button2(){
            $("#mcover").css("display","block")  // 分享给好友圈按钮触动函数
        }
        function weChat(){
            $("#mcover").css("display","none");  // 点击弹出层，弹出层消失
        }

        /*$
         (function(){
         setTimeout(function () {
         $("#mcover").show();}, 6000);   // 6000时毫秒是弹出层
         setTimeout(function () {
         $("#mcover").hide(); }, 8000);    //8000毫秒是隐藏层
         })
         */
    </script></head>


<body style="zoom: 1;">
<div id="mcover" onclick="weChat()" style="display:none;">
    <img src="https://mmbiz.qlogo.cn/mmbiz/vV3bdMHsLIjY2s0npKT0FaJ6iaC1MaiciakM61zfqBsNjYH14ovUG145GEuwMPafiaPjh5drSaAg8DMTic3a2I3icbLg/0">
</div>

<div class="text" id="content">
    <div id="mess_share">
        <div id="share_1">
            <button class="button2" onclick="button1()">
                <img src="https://mmbiz.qlogo.cn/mmbiz/vV3bdMHsLIjY2s0npKT0FaJ6iaC1MaiciakIHMqX6tb7127kicbBd5vIZcey4wenREiaEe8YXshOWpFcIser6AgbsEA/0" width="64" height="64">
                发送给朋友
            </button>
        </div>
        <div id="share_2">
            <button class="button2" onclick="button2()">
                <img src="https://mmbiz.qlogo.cn/mmbiz/vV3bdMHsLIjY2s0npKT0FaJ6iaC1MaiciakERrBO1bHKDDzxiakMd4m2H1mmib1ShpekZ8RZm5ECazcDqF96c5wcl2w/0" width="64" height="64">
                分享到朋友圈
            </button>
        </div>
        <div class="clr"></div>
    </div>
</div>

</body></html>