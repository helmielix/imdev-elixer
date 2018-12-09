<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

common\assets\AppAsset::register($this);
dmstr\web\AdminLteAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\BANKGUARANTEEPERMIT */

//$this->title = ' View OS Vendor SPK';
$this->registerCss('
@media print {
  @page { margin: 0; }
  body { margin: 1.6cm; font-size: 10px; height: 100%}
  table { page-break-after:auto }
  tr    { page-break-inside:avoid; page-break-after:auto }
  td    { page-break-inside:avoid; page-break-after:auto }
  thead { display:table-header-group }
  tfoot { display:table-footer-group }
}
body > #wrap {
    height: auto;
    min-height: 100%;
}

#main {
    padding-bottom: 180px;  /* must be same height as the footer */
}

#footer {
    position: relative;
    margin-top: -180px;  /* negative value of footer height */
    height: 180px;
    clear: both;
}
.kecil { font-size : 80%}
.borderTop{border-top:1px solid}
.borderBottom{border-bottom:1px solid}
.borderRight{border-right:1px solid}
.borderLeft{border-left:1px solid}
.row-eq-height {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display:         flex;
}
#rowtwo{margin-right:0px;margin-left:0px}
.paddingmnc {
    padding: 10px 15px;
}
.pad10top{
    padding-top: 10px;
}
.pad10bottom{
    padding-bottom: 10px;
}
.pad80top{
    padding-top: 80px;
}
.pad20bottom{
    padding-bottom: 20px;
}
ol {
    -webkit-padding-start: 10px;
}
');

$vendor = isset($modelVendor->vendorName->company_name) ? $modelVendor->vendorName->company_name : '&nbsp;';
$vendor = ($vendor == '')?'&nbsp;' : $vendor;
$address = isset($modelVendor->idVendorRegistVendor->address) ? $modelVendor->idVendorRegistVendor->address : '&nbsp;';
$address = ($address == '')?'&nbsp;' : $address;
$tel = isset($modelVendor->idVendorRegistVendor->phone_number) ? $modelVendor->idVendorRegistVendor->phone_number : '&nbsp;';
$tel = ($tel == '')?'&nbsp;' : $tel;
$fax = isset($modelVendor->idVendorRegistVendor->fax_number) ? $modelVendor->idVendorRegistVendor->fax_number : '&nbsp;';
$fax = ($fax == '')?'&nbsp;' : $fax;
$email = isset($modelVendor->idVendorRegistVendor->email) ? $modelVendor->idVendorRegistVendor->email : '&nbsp;';
$email = ($email == '')?'&nbsp;' : $email;

Class Terbilang {
	function terbilang() {
		$this->dasar = array(1=>'satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan');
		$this->angka = array(1000000000,1000000,1000,100,10,1);
		$this->satuan = array('milyar','juta','ribu','ratus','puluh','');
	}
	function eja($n) {
		$i=0;
		$str='';
		while($n!=0){
			$count = (int)($n/$this->angka[$i]);
			if($count>=10) $str .= $this->eja($count). " ".$this->satuan[$i]." ";
			else if($count > 0 && $count < 10)
			$str .= $this->dasar[$count] . " ".$this->satuan[$i]." ";
			$n -= $this->angka[$i] * $count;
			$i++;
		}
		$str = preg_replace("/satu puluh (\w+)/i","\\1 belas",$str);
		$str = preg_replace("/satu (ribu|ratus|puluh|belas)/i","se\\1",$str);
		return strtoupper($str);
	}
}

$bilangan = new Terbilang;
?>
 <!-- borderTop borderRight borderLeft borderBottom -->
<div class="container" id="main">

    <div class="row row-eq-height" id="rowone">
        <div class="col-xs-4 borderTop  borderLeft borderBottom">
            <?= Html::img('@commonpath/images/MNC_media_logo.png', $options=["class"=>"img-fluid img-responsive"]) ?>
        </div>
        <div class="col-xs-4 borderTop borderRight borderLeft borderBottom text-center"><h3>SURAT JALAN</h3></div>
        <div class="col-xs-4 borderTop borderRight  borderBottom">
            <?= Html::img('@commonpath/images/MNC_Playmedia.png', $options=["class"=>"img-fluid img-responsive"]) ?>
        </div>
    </div>
    <div class="row" id='rowtwo'>
        <div class="row">
            <div class="paddingmnc col-xs-12 borderRight borderLeft " style="display:block">
                PT. MNC Kabel Mediacom <br>
                MNC Tower Lt. 26 <br>
                Jl. Kebon Sirih No. 17-19 Kebon Sirih, Menteng, <br>
                Jakarta Pusat 10340, INDONESIA <br>
                Tax Number : 03.256.238.1-021.000
            </div>
        </div>
        <div class="row row-eq-height">
            <div class="col-xs-6 borderTop  borderLeft borderBottom">
                <!-- Data Vendor Regist Vendor -->
                <dl class="row pad10top">
                  <dt class="col-xs-5">No. GRF</dt>
                  <dd class='col-xs-7'><?= $model->idInstructionWh->grf_number ?></dd>
                  <dt class="col-xs-5">Tgl. Diterbitkan</dt>
                  <dd class='col-xs-7'><?= $model->published_date ?></dd>
                  <dt class="col-xs-5">Gudang Asal / Alamat</dt>
                  <dd class='col-xs-7'><?= $model->idInstructionWh->whOrigin->nama_warehouse ?></dd>
                  <dt class="col-xs-5">Tujuan / Alamat</dt>
                  <dd class='col-xs-7'><?= $model->idInstructionWh->whDestination->nama_warehouse ?></dd>
                  <dt class="col-xs-5">Tim</dt>
                  <dd class='col-xs-7'><?= $email ?></dd>
                  <dt class="col-xs-5">Dept. / Vendor Cont. / Forwarder</dt>
                  <dd class='col-xs-7'><?= $model->forwarder0->description ?></dd>
                  
                </dl>
            </div>
            <div class="col-xs-6 borderTop borderRight borderLeft borderBottom">
                <dl class="row pad10top">
                    <dt class="col-xs-3">Nomor Polisi</dt>
                    <dd class='col-xs-9'><?= $model->plate_number ?></dd>
                    <dt class="col-xs-3">Driver</dt>
                    <dd class='col-xs-9'><?= $model->driver ?></dd>
                </dl>
            </div>
        </div>
        <!-- <div class="row borderBottom borderRight borderLeft">&nbsp;</div> -->
        <div class="row borderRight borderLeft ">
            <span class="col-xs-12 pad10bottom">
                <!-- <hr size="5"> -->
                <div class="row"><div class=" borderBottom" style="margin:0 15px">&nbsp;</div></div>
               </span>
        </div>
        <!-- table -->
        <div class="row borderRight borderLeft">
            <div class="container-fluid table-responsive">
                <table class="table table-striped table-bordered table-condensed" style='page-break-after:auto'>
                    <thead style='display:table-header-group'>
                        <tr class="info" style='page-break-inside:avoid; page-break-after:auto'>
                            <th rowspan="2" style="text-align:center;">NO</th>
                            <th rowspan="2" style="text-align:center;">Kode Material</th>
                            <th rowspan="2" style="text-align:center;">Deskripsi</th>
                            <th colspan="4" style="text-align:center;">QTY Per Kondisi</th>
                            <th rowspan="2" style="text-align:center;">Total QTY</th>
                            <th rowspan="2" style="text-align:center;">UOM</th>
                            <th rowspan="2" style="text-align:center;">Remark</th>
                        </tr>
                        <tr>
                            <th>Good</th>
                            <th>Not Good</th>
                            <th>Dismantled</th>
                            <th>Rejected</th>
                        </tr>

                    </thead>
                    <tbody style='display:table-header-group'>
                        <?php
                        $j = 1;
						$subtotal = 0;
                        for ($i=0; $i < count($modelDetail); $i++) {
							// $price = $modelDetail[$i]['po_amount'] / $modelDetail[$i]['pr_quantity'];
							// // $price = "{$modelDetail[$i]['po_amount']} - {$modelDetail[$i]['pr_quantity']}";
							// $priceview = number_format($price,0,".",",");
							// $totalview = number_format($modelDetail[$i]['po_amount'],0,".",",");
							// $qtyview   = number_format($modelDetail[$i]['pr_quantity'],0,".",",");
                            $totalQty = $modelDetail[$i]['req_good'] + $modelDetail[$i]['req_not_good'] + $modelDetail[$i]['req_reject'] + $modelDetail[$i]['req_good_dismantle'];
                            echo "<tr style='page-break-inside:avoid; page-break-after:auto'>";
                            echo "<td style='page-break-inside:avoid; page-break-after:auto'>$j</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'>{$modelDetail[$i]['im_code']}</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'>{$modelDetail[$i]['item_name']}</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'>{$modelDetail[$i]['req_good']}</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'>{$modelDetail[$i]['req_not_good']}</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'>{$modelDetail[$i]['req_good_dismantle']}</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'>{$modelDetail[$i]['req_reject']}</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'>{$totalQty}</td>
                            <td style='page-break-inside:avoid; page-break-after:auto'></td>
                            <td style='page-break-inside:avoid; page-break-after:auto'></td>
                            

                            ";
							// echo "<td style='page-break-inside:avoid; page-break-after:auto' style='text-align:right'>{$priceview}</td><td style='page-bre$modelDetail[$i]['req_reject']ak-inside:avoid; page-break-after:auto' style='text-align:right'>{$totalview}</td>";
                            echo "</tr>";
							// $subtotal = $modelDetail[$i]['po_amount'] + $subtotal;
                            $j++;
                        }
						
						// $subtotalview = number_format($subtotal,0,".",",");
						// echo "<tr style='page-break-inside:avoid; page-break-after:auto'>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' colspan = 3>&nbsp;</td>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' colspan = 2 style='text-align:right'>Sub Total</td>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' style='text-align:right'>$subtotalview</td>";
						// echo "</tr>";
						
						// $vat = $subtotal * (10/100);
						// $vatview = number_format($vat,0,".",",");
						// echo "<tr style='page-break-inside:avoid; page-break-after:auto'>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' colspan = 3>&nbsp;</td>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' colspan = 2 style='text-align:right'>VAT 10%</td>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' style='text-align:right'>$vatview</td>";
						// echo "</tr>";
						
						// $grandtotal = $subtotal + $vat;
						// $grandtotalview = number_format($grandtotal,0,".",",");
						// echo "<tr style='page-break-inside:avoid; page-break-after:auto'>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' colspan = 3>&nbsp;</td>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' colspan = 2 style='text-align:right'>Grand Total</td>";
						// echo "<td style='page-break-inside:avoid; page-break-after:auto' style='text-align:right'>$grandtotalview</td>";
						// echo "</tr>";
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- table -->
		
    </div>
    <div class="row borderRight borderLeft borderBottom" id="rowthree" style='page-break-inside:avoid; page-break-after:auto'>
        <div class="row">
            <div class="col-xs-2 text-center">Disiapkan oleh,</div>
            <div class="col-xs-2 text-center">Diperiksa oleh,</div>
            <div class="col-xs-2 text-center">Disampaikan oleh,</div>
            <div class="col-xs-2 text-center">Mengetahui,</div>
            <div class="col-xs-2 text-center">Diterima oleh,</div>
        </div>

        <div class="row pad80top pad20bottom">
            <div class="col-xs-2 text-center">( ---------------------- )</div>
            <div class="col-xs-2 text-center">( ---------------------- )</div>
            <div class="col-xs-2 text-center">( ---------------------- )</div>
            <div class="col-xs-2 text-center">( ---------------------- )</div>
            <div class="col-xs-2 text-center">( ---------------------- )</div>
        </div>
    </div>


</div>
