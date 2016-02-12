
<div>
<h2>Documents by Entropy</h2>
<?php
foreach($bars as $bar) {
	$w = round($bar['n'] / $nmax, 2) * 100;
	$h_start = round($bar['h'],2);
	$h_end = round($bar['m'],2);
	$doc_url = base_url("doc/by_h/$h_start/$h_end");
	print("<div class='data-item'>");
	print("<p><a href='$doc_url'>H >= $h_start and < $h_end</a></p>");
    print("<div class='progress'>");
    print("<div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow='{$bar['n']}' aria-valuemin='0' aria-valuemax='{$nmax}' style='width:{$w}%'>");
    print($bar['n']);
    print("</div>");
	print("</div>");
	print("</div>");
}
?>
 </div>