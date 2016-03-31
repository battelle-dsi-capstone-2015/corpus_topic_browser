
<div id="mynetwork" style="height:10in;width:12in;"></div>

<script type="text/javascript">
    var container = document.getElementById('mynetwork');
	var nodes = new vis.DataSet(<?php print $nodes; ?>);
	var edges = new vis.DataSet(<?php print $edges; ?>);	
    var data = {nodes: nodes, edges: edges};
    var options = {
    	layout: {
    		hierarchical: {
			  enabled:false,
			  levelSeparation: 150,
			  nodeSpacing: 100,
			  treeSpacing: 200,
			  blockShifting: true,
			  edgeMinimization: true,
			  parentCentralization: true,
			  direction: 'UD',        // UD, DU, LR, RL
			  sortMethod: 'hubsize'   // hubsize, directed
		    },
    		improvedLayout: true	
    	},
    	nodes: {
    		shape: 'box'
    	}
    };
    var network = new vis.Network(container, data, options);    
</script>

<pre>
	<tt>NODES<tt>
	<?php print $nodes; ?>)
	<tt>EDGES</tt>
	<?php print $edges; ?>)
</pre>
