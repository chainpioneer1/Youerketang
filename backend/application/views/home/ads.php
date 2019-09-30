<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/10/2017
 * Time: 5:25 PM
 */

?>
<div style="position: absolute;top:20%;width:100%;height: 100%">
    <div id="qrcode" style="width:100px; height:100px; margin-top:15px;"></div>
</div>

<script type="text/javascript" src="<?= base_url('assets/js/qrcode/qrcode.min.js')?>"></script>
<script>
 var csTitle = '<?= $csTitle;?>';
 var qrcode = new QRCode(document.getElementById("qrcode"), {
     width : 100,
     height : 100
 });
 function makeCode () {
     var elText = document.getElementById("text");

     if (!elText.value) {
         alert("Input a text");
         elText.focus();
         return;
     }
     qrcode.makeCode(elText.value);
 }
 makeCode(baseURL+'uploads/ads/'+csTitle);
</script>
