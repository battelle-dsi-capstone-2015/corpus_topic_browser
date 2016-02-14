<div class="page-header">
  <h1><?php print($page_title); ?></h1>
</div>

<?php if (isset($topics)) {
      print("<div class='well'>");
      foreach($topics as $topic) {
      print("<div>{$topic['topic_id']}: {$topic['topic_words']}</div>");
      }	
      print("</div>");
      }
      ?>

<div>
  <h2>Documents</h2>
  <table data-page-length='25' class="data-table">
    <thead>
      <tr>
	<th>Entropy</th>
	<th>Year</th>
	<th>Title</th>				
      </tr>
    </thead>
    <tbody>
   <?php
   foreach($docs as $doc) {
   $doc_url = base_url('doc/item/'.$doc['doc_id']);
   $h = round($doc['topic_entropy'],3);
   $w = round($doc['topic_entropy'] / $entropy['max'],2) * 100;
   print("<tr>");
   print("<td>");
   print progress_bar('info',$h,0,$entropy['max'],$w,$h);
   print("</td>");
   print("<td>{$doc['year']}</td>");
   print("<td><a href='$doc_url'>{$doc['title']}</a></td>");
   print("</tr>");	
 }
?>	
    </tbody>
  </table>
</div>