<h2>API</h2>
   <table class="table">
     <thead>
       <tr>
         <th>Function</th>
         <th>URL</th>
       </tr>
     </thead>
     <tbody>
       <tr>
         <td>[1] View All The Tables!</td>
         <td><a href="/battelle/data/view">http://studio1.shanti.virginia.edu/battelle/data/view</a></td>
       </tr>
     <tr>
       <td>[2] View a single table</td>
       <td>
         <tt>http://studio1.shanti.virginia.edu/battelle/data/view/<b>TABLENAME</b></tt>
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic">http://studio1.shanti.virginia.edu/battelle/data/view/topic</a> 
       </td>     
     </tr>
     <tr>
       <td>[3] View a table as CSV for downloading and importing into phpMyAdmin</td>
       <td>
         <tt>http://studio1.shanti.virginia.edu/battelle/data/view/<b>TABLENAME</b>/<b>text</b></tt>
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic/text">http://studio1.shanti.virginia.edu/battelle/data/view/topic/text</a>
       </td>     
     </tr>
     <tr>
       <td>[4] View a table as an HTML fragment for including in another HTML document</td>
       <td>
         <tt>http://studio1.shanti.virginia.edu/battelle/data/view/<b>TABLENAME</b>/<b>html</b></tt>
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic/html">http://studio1.shanti.virginia.edu/battelle/data/view/topic/html</a>         
       </td>     
     </tr>
     <tr>
       <td>[5] View a single row as an HTML fragment for including in another HTML document</td>
       <td>
         <tt>http://studio1.shanti.virginia.edu/battelle/data/view/<b>TABLENAME</b>/<b>html</b>/<b>PRIMARYKEY</b>/<b>VALUE</b></tt>
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic/html/topic_id/1">http://studio1.shanti.virginia.edu/battelle/data/view/topic/html/topic_id/1</a>         
       </td>     
     </tr>
     <tr>
       <td>[6] View a single cell as an HTML fragment for including in another HTML document</td>
       <td>
         <tt>http://studio1.shanti.virginia.edu/battelle/data/view/<b>TABLENAME</b>/<b>html</b>/<b>PRIMARYKEY</b>/<b>VALUE</b>/<b>COLNAME</b></tt>
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic/html/topic_id/1/topic_alpha">http://studio1.shanti.virginia.edu/battelle/data/view/topic/html/topic_id/1/topic_alpha</a>
         <br>Or view more than one column by joining column names with a <tt>--</tt> (two dashes),
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic/html/topic_id/1/topic_alpha--topic_words">http://studio1.shanti.virginia.edu/battelle/data/view/topic/html/topic_id/1/topic_alpha--topic_words </a>         
       </td>     
     </tr>
     <tr>
       <td>[7] View a single cell as raw text for including in another HTML document. Good for using in attributes.</td>
       <td>
       <tt>http://studio1.shanti.virginia.edu/battelle/data/view/<b>TABLENAME</b>/<b>text</b>/<b>PRIMARYKEY</b>/<b>VALUE</b>/<b>COLNAME</b></tt>
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic/text/topic_id/1/topic_words">http://studio1.shanti.virginia.edu/battelle/data/view/topic/text/topic_id/1/topic_words</a>
       </td>     
     </tr>
     <tr>
       <td>[8] View one or more colomns in any format.</td>
       <td>
       <tt>http://studio1.shanti.virginia.edu/battelle/data/view/<b>TABLENAME</b>/<b>(html|json|text)</b>/<b>COLNAME</b></tt>
         <br>e.g. <a href="http://studio1.shanti.virginia.edu/battelle/data/view/topic/text/topic_alpha">http://studio1.shanti.virginia.edu/battelle/data/view/topic/text/topic_alpha</a>
         <br>Note this URL does not return field names, just field values. If you want field names too, in your database create a view from your table that selects just the columns you want and then use the view in the URL for retrieving tables (above).
         <br>Also note that in the URL template above, the expression <tt><b>(html|json|text)</b></tt> is meant to signify a choice of three options. As in the examples above, choose an option and do not include the parentheses or pipes.
         </p>
       </td>     
     </tr>
     </tbody>
   </table>	
   