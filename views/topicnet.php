<div class="page-header">
  <h1>Topic Network</h1>
  <p class="lead">This is a visualization of the topic network. It includes a subset of topics that have a 
  	Jensen-Shannon Divergence value (i.e. distance) of <tt><?php print $js_min; ?></tt> or less to at least one other topic.
  	Topics with very high and very low alphas have also been reomoved.</p>
  </p>
</div>
<style type="text/css">
    #mynetwork {
      width: 100%;
      height: 1000px;
      border: 1px solid lightgray;
    }
</style>
<div id="mynetwork">&nbsp;</div>
<script type="text/javascript">
	var nodes = <?php print json_encode($topicnet['nodes']); ?>;
	var edges = <?php print json_encode($topicnet['edges']); ?>;
    var nodeset = new vis.DataSet(nodes);
    var edgeset = new vis.DataSet(edges);
    var container = document.getElementById('mynetwork');
    var data = {
        nodes: nodeset,
        edges: edgeset
    };
    var options = {
  		nodes: {
            shape: 'box',
            size: 30,
            font: {
                size: 12
            },
            borderWidth: 2,
            shadow:true
        },
	edges: {
        	smooth: {
            	type: 'cubicBezier',
                forceDirection: 'vertical',
                roundness: 0.4
            }
      },
      layout: {
      	improvedLayout: true,
		    hierarchical: {
		    	enabled: true,
		        direction: "UD",
		        sortMethod: 'hubsize',
		        levelSeparation:200,
		        nodeSpacing:128,
		        //treeSpacing: 100,
		        //blockShifting: true,
		        //edgeMinimization: true,
		        //parentCentralization: true
		        
		    }
		},
	  physics:{
	    enabled: false,
	    barnesHut: {
	      gravitationalConstant: -2000,
	      //gravitationalConstant: -5000,
	      centralGravity: 0.3,
	      springLength: 95,
	      springConstant: 0.04,
	      damping: 0.09,
	      avoidOverlap: 1
	    },
	    forceAtlas2Based: {
	      gravitationalConstant: -50,
	      centralGravity: 0.01,
	      springConstant: 0.08,
	      springLength: 100,
	      damping: 0.4,
	      avoidOverlap: 1
	    },
	    repulsion: {
	      centralGravity: 0.2,
	      springLength: 200,
	      springConstant: 0.05,
	      nodeDistance: 100,
	      damping: 0.09,
	      avoidOverlap: 1
	    },
	    hierarchicalRepulsion: {
	      centralGravity: 0.0,
	      springLength: 100,
	      springConstant: 0.01,
	      nodeDistance: 120,
	      damping: 0.09
	    },
	    maxVelocity: 50,
	    minVelocity: 0.1,
	    //solver: 'repulsion',
	    //solver: 'barnesHut',
	    //solver: 'hierarchicalRepulsion',
	    solver: 'forceAtlas2Based',
	    stabilization: {
	      enabled: true,
	      iterations: 1000,
	      updateInterval: .5,
	      onlyDynamicEdges: true,
	      fit: true
	    },
	    timestep: 10,
	    adaptiveTimestep: true
	  }
    };
    var network = new vis.Network(container, data, options);
</script>