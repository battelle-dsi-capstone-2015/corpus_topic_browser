<div class="page-header">
    <h1><?php print($page_title); ?></h1>
</div>

<?php 
if (isset($topics)) {
    print("<div class='well'>");
    foreach($topics as $topic) {
        print("<h4>{$topic['topic_id']}: {$topic['topic_words']}</h4>");
    }	
    print("</div>");
}
?>

<div>
  <table data-page-length='25' class="table data-table">
    <thead>
      <tr>
        <th>Entropy</th>
        <th>Year</th>
        <th>Title</th>				
      </tr>
    </thead>
    <tbody>
   <?php
   $vmin = 0;
   $vmax = $entropy['max'];
   foreach($docs as $doc) {
       $doc_url = base_url('doc/item/'.$doc['doc_id']);
       $vnow = round($doc['topic_entropy'],3);
       print("<tr>");
       print("<td>");
       print progress_bar('info',$vnow,$vmin,$vmax,$vnow);
       print("</td>");
       print("<td>{$doc['year']}</td>");
       print("<td style='font-size:110%;'><a href='$doc_url'>{$doc['title']}</a></td>");
       print("</tr>");	
    }
    ?>	
    </tbody>
  </table>
</div>