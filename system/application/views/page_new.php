<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Wallboard</title>
   <!-- Bootstrap core CSS -->
	<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
	<style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>
  <body>
    
<main>
  <div class="container-xxl">
   <div class="row mb-4 mt-3">
    <div class="col-md-6">
        <div class="h-100 p-3 bg-light border border-primary rounded-3">
          <h2> DATA DC 1</h2>
		  <table class="table table-success table-bordered table-striped text-center">
			  <thead>
			<tr>
			  <th scope="col" class="text-start">OVERDUE</th>
			  <th scope="col">1</th>
			  <th scope="col">2</th>
			  <th scope="col">3</th>
			  <th scope="col">4</th>
			  <th scope="col">5</th>
			  <th scope="col">6</th>
			  <th scope="col">7</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th class="col-md-3 text-start">PENGERJAAN</th>
				<td><?php echo number_format($calltrack['total_plus1']) ?></td>
				<td><?php echo number_format($calltrack['total_plus2']) ?></td>
				<td><?php echo number_format($calltrack['total_plus3']) ?></td>
				<td><?php echo number_format($calltrack['total_plus4']) ?></td>
				<td><?php echo number_format($calltrack['total_plus5']) ?></td>
				<td><?php echo number_format($calltrack['total_plus6']) ?></td>
				<td><?php echo number_format($calltrack['total_plus7']) ?></td>
			</tr>
			<tr>
			  <th class="col-md-3 text-start">SISA</th>
				<td><?php echo number_format($debtor_main['total_plus1']-$calltrack['total_plus1']-$debtor_main['total_plus1_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus2']-$calltrack['total_plus2']-$debtor_main['total_plus2_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus3']-$calltrack['total_plus3']-$debtor_main['total_plus3_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus4']-$calltrack['total_plus4']-$debtor_main['total_plus4_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus5']-$calltrack['total_plus5']-$debtor_main['total_plus5_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus6']-$calltrack['total_plus6']-$debtor_main['total_plus6_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus7']-$calltrack['total_plus7']-$debtor_main['total_plus7_skip']) ?></td>
			</tr>
			
		  </tbody>

		  </table>
      </div>
      </div>
      <div class="col-md-6">
        <div class="h-100 p-3 bg-light border border-primary rounded-3">
          <h2>DATA DC 2</h2>
		  <table class="table table-primary table-striped table-bordered text-center">
			  <thead>
			<tr>
			  <th scope="col" class="text-start">OVERDUE</th>
			  <th scope="col">8</th>
			  <th scope="col">9</th>
			  <th scope="col">10</th>
			  <th scope="col">11</th>
			  <th scope="col">12</th>
			  <th scope="col">13</th>
			  <th scope="col">14</th>
			  <th scope="col">15</th>
			  <th scope="col">15+</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th class="col-md-2 text-start">PENGERJAAN</th>
				<td><?php echo number_format($calltrack['total_plus8']) ?></td>
				<td><?php echo number_format($calltrack['total_plus9']) ?></td>
				<td><?php echo number_format($calltrack['total_plus10']) ?></td>
				<td><?php echo number_format($calltrack['total_plus11']) ?></td>
				<td><?php echo number_format($calltrack['total_plus12']) ?></td>
				<td><?php echo number_format($calltrack['total_plus13']) ?></td>
				<td><?php echo number_format($calltrack['total_plus14']) ?></td>
				<td><?php echo number_format($calltrack['total_plus15']) ?></td>
				<td><?php echo number_format($calltrack['total_plus15plus']) ?></td>
			</tr>
			<tr>
			  <th class="col-md-2 text-start">SISA</th>
				<td><?php echo number_format($debtor_main['total_plus8']-$calltrack['total_plus8']-$debtor_main['total_plus8_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus9']-$calltrack['total_plus9']-$debtor_main['total_plus9_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus10']-$calltrack['total_plus10']-$debtor_main['total_plus10_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus11']-$calltrack['total_plus11']-$debtor_main['total_plus11_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus12']-$calltrack['total_plus12']-$debtor_main['total_plus12_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus13']-$calltrack['total_plus13']-$debtor_main['total_plus13_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus14']-$calltrack['total_plus14']-$debtor_main['total_plus14_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus15']-$calltrack['total_plus15']-$debtor_main['total_plus15_skip']) ?></td>
				<td><?php echo number_format($debtor_main['total_plus15plus']-$calltrack['total_plus15plus']-$debtor_main['total_plus15plus_skip']) ?></td>
			</tr>
			
		  </tbody>

		  </table>
		
        </div>
      </div>
    </div>

    <div class="row align-items-md-stretch">
      <div class="col-md-4">
        <div class="h-100 p-3 bg-light border border-primary rounded-3">
          <h2>REMINDER</h2>
		  <table class="table table-info table-striped table-bordered text-center">
			  <thead>
			<tr>
			  <th scope="col" class="text-start">OVERDUE</th>
			  <th scope="col">-3</th>
			  <th scope="col">-2</th>
			  <th scope="col">-1</th>
			  <th scope="col">0</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <th class="col-md-5 text-start">PENGERJAAN</th>
			  <td><?php echo number_format($calltrack['total_min3']) ?></td>
			  <td><?php echo number_format($calltrack['total_min2']) ?></td>
			  <td><?php echo number_format($calltrack['total_min1']) ?></td>
			  <td><?php echo number_format($calltrack['total_null']) ?></td>
			</tr>
			<tr>
			  <th class="col-md-5 text-start">SISA</th>
			  <td><?php echo number_format($debtor_main['total_min3']-$calltrack['total_min3']-$debtor_main['total_min3_skip']) ?></td>
			  <td><?php echo number_format($debtor_main['total_min2']-$calltrack['total_min2']-$debtor_main['total_min2_skip']) ?></td>
			  <td><?php echo number_format($debtor_main['total_min1']-$calltrack['total_min1']-$debtor_main['total_min1_skip']) ?></td>
			  <td><?php echo number_format($debtor_main['total_null']-$calltrack['total_null']-$debtor_main['total_null_skip']) ?></td>
			</tr>
			
		  </tbody>

		  </table>
			
		  </div>
      </div>
      <div class="col-md-4">
        <div class="h-100 p-3 bg-light border border-primary rounded-3">
          <h2>TOTAL PEGERJAAN</h2>
		  <h1 class="display-1 fw-bold text-center"><?php echo number_format($calltrack['total_cust']) ?></h1>
		 </div>
		 
      </div>
	   <div class="col-md-4">
        <div class="h-100 p-3 bg-light border border-primary rounded-3 shadow-lg p-3 bg-body">
          <h2>TOTAL SISA</h2>
		   <h1 class="display-1 fw-bold text-center"><?php echo number_format($debtor_main['total_cust']-$calltrack['total_cust']-$debtor_main['total_cust_skip']) ?></h1>
		</div>
		
      </div>
    </div>
	<div class="row mt-4 align-items-md-stretch">
		<div class="col-md-7">
        <div class="h-100 p-3 bg-light border border-info rounded-3">
			<h5 class="display-7 mt-2">Note :</h5>
		</div>
	</div>
	   <div class="col-md-5">
        <div class="h-100 p-2 bg-light border border-info rounded-3">
          <h1 class="display-1 text-center" id="jam"></h1>
		</div>
		
      </div>
	</div>
	<footer class="pt-3 mt-4 border-top">
		<div class="row mb-2">
			<div class="col-md-3">
			  <h3 class="display-7 text-start" id="tanggalwaktu"></h3>
			</div>
			<div class="col-md-9">
			  <marquee><h3 class="display-7 text-center" id="ucapan"></h3></marquee>
			</div>
		 </div>
		
	 </footer>
  </div>
</main>


<script>
	   setInterval(customClock, 500);
	   function customClock() {
		var ucapan;
	       var time = new Date();
	       var hrs = time.getHours();
	       var min = time.getMinutes();
	       var sec = time.getSeconds();
	       
	       document.getElementById('jam').innerHTML = hrs + ":" + min + ":" + sec ;
		if (hrs >= 4 && hrs < 10) {
				ucapan = "Selamat Pagi - Jangan Lengah, Mari Tetap Disiplin dan Menaati Protokol Kesehatan";
			} else if (hrs >= 10 && hrs < 15) {
				ucapan = "Selamat Siang - Jangan Lengah, Mari Tetap Disiplin dan Menaati Protokol Kesehatan";
			} else if (hrs >= 15 && hrs < 18) {
				ucapan = "Selamat Sore - Jangan Lengah, Mari Tetap Disiplin dan Menaati Protokol Kesehatan";
			} else if (hrs >= 18 || hrs < 4) {
				ucapan = "Selamat Malam - Jangan Lengah, Mari Tetap Disiplin dan Menaati Protokol Kesehatan";
			} else {
				ucapan = "";
			}
			document.getElementById("ucapan").innerHTML = ucapan;	
	       
	   }
	   
	</script><script>
var tw = new Date();
if (tw.getTimezoneOffset() == 0) (a=tw.getTime() + ( 7 *60*60*1000))
else (a=tw.getTime());
tw.setTime(a);
var tahun= tw.getFullYear ();
var hari= tw.getDay ();
var bulan= tw.getMonth ();
var tanggal= tw.getDate ();
var hariarray=new Array("Minggu,","Senin,","Selasa,","Rabu,","Kamis,","Jum'at,","Sabtu,");
var bulanarray=new Array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","Nopember","Desember");
document.getElementById("tanggalwaktu").innerHTML = hariarray[hari]+" "+tanggal+" "+bulanarray[bulan]+" "+tahun;
</script>
  </body>
</html>
