<!DOCTYPE HTML> 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link type="text/css" rel="stylesheet" href="html/rickshaw/src/css/graph.css">
    <link type="text/css" rel="stylesheet" href="html/rickshaw/src/css/detail.css">
    <link type="text/css" rel="stylesheet" href="html/rickshaw/src/css/legend.css">
	<link type="text/css" rel="stylesheet" href="html/rickshaw/src/css/lines.css">
	
	<link type="text/css" rel="stylesheet" href="html/rickshaw/rickshaw.min.css">
<script src="html/rickshaw/vendor/d3.min.js"></script>
<script src="html/rickshaw/vendor/d3.layout.min.js"></script>
<script src="html/rickshaw/rickshaw.min.js"></script>

   
</head>
<body>

<style>
#chart_container {
        position: relative;
        display: inline-block;
        font-family: Arial, Helvetica, sans-serif;
        padding: 50px;
}
#chart {
        display: inline-block;
        margin-left: 40px;
}
#y_axis {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
}
#legend {
        display: inline-block;
        vertical-align: top;
        margin: 0 0 0 10px;
}
</style>
	<style>
		.swatch2 {
			display: inline-block;
			width: 10px;
			height: 10px;
			margin: 0 8px 0 0;
		}
		.label2 {
			display: inline-block;
		}
		.line2 {
			display: inline-block;
			margin: 0 0 0 30px;
		}

		.rickshaw_graph .detail {
			background: none;
		}
	</style>


<div id="chart_container">
        <div id="y_axis"></div>
        <div id="chart"></div>
<div id="legend"></div>
<div id="legend2"></div>
</div>

    <!--  Loading js for the charts -->

  	<script src="html/rickshaw/vendor/d3.v3.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="html/rickshaw/rickshaw.js"></script>	
	
<script type="text/javascript"> 	 
var start = +new Date();
function getUrlVars() {
       var vars = {};
	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
	    vars[key] = value;
    });
    return vars;
    }
    var type = getUrlVars()["type"];
    var max = getUrlVars()["max"];
    var single = getUrlVars()["single"];
    var group = getUrlVars()["group"];
    var mode = getUrlVars()["mode"];
    
        new Rickshaw.Graph.Ajax( {
            element: document.getElementById("chart"),
            width: 900,
            height: 500,
            renderer: 'line',
            dataURL: 'common/rc_data.php?type='+type+'&name='+name+'&max='+max+'&mode='+mode+'&group='+group+'&single='+single,
            onData: function(d) { d[0].data[0].y = 80; return d },
            onComplete: function(transport) {
                var graph = transport.graph;
               var detail = new Rickshaw.Graph.HoverDetail({ 
               	graph: graph 
                	});
               var legend = new Rickshaw.Graph.Legend( {
						graph: graph,
						element: document.getElementById('legend')
						} );
					var shelving = new Rickshaw.Graph.Behavior.Series.Toggle( {
						graph: graph,
						legend: legend
						} );
					var axes = new Rickshaw.Graph.Axis.Time( {
						graph: graph
						} );
						
					var y_axis = new Rickshaw.Graph.Axis.Y( {
        				graph: graph,
        				orientation: 'left',
        				tickFormat: Rickshaw.Fixtures.Number.formatKMBT,
        				element: document.getElementById('y_axis'),
					} );
					
					graph.render();
					
					
var legend = document.querySelector('#legend2');

var Hover = Rickshaw.Class.create(Rickshaw.Graph.HoverDetail, {

	render: function(args) {

		legend.innerHTML = args.formattedXValue;

		args.detail.sort(function(a, b) { return a.order - b.order }).forEach( function(d) {

			var line = document.createElement('div');
			line.className = 'line2';

			var swatch = document.createElement('div');
			swatch.className = 'swatch2';
			swatch.style.backgroundColor = d.series.color;

			var label = document.createElement('div');
			label.className = 'label2';
			label.innerHTML = d.name + ": " + d.formattedYValue;

			line.appendChild(swatch);
			line.appendChild(label);

			legend.appendChild(line);

			var dot = document.createElement('div');
			dot.className = 'dot';
			dot.style.top = graph.y(d.value.y0 + d.value.y) + 'px';
			dot.style.borderColor = d.series.color;

			this.element.appendChild(dot);

			dot.className = 'dot active';

			this.show();

		}, this );
        }
});

var hover = new Hover( { graph: graph } ); 



					
						
         	},
         } );
        
    </script>

</body>
