<div id="content"></div>

    <script type="text/javascript" src="modules/highcharts/js/jquery.min.js"></script>
    <script type="text/javascript" src="modules/highcharts/js/highcharts.js"></script>
    <script type="text/javascript" src="modules/highcharts/js/chart.min.js" charset="utf-8"></script>
    <script src="modules/kwh/html/js/exporting.js"></script>
    <script type="text/javascript">
      $(document).ready(function(){
	function getUrlVars() {
	    var vars = {};
    	    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    	    vars[key] = value;
	});
	return vars;
	}
	var type = getUrlVars()["type"];
	var highcharts = getUrlVars()["highcharts"];
	
	if(!highcharts){
	    var highcharts = "hour";
	}
	if(!type){
	    var type = "temp";
	}	
	//alert(type);
	//alert(highcharts);

        $.ajax({
          type: "GET",
          url: "tmp/highcharts/"+type+"_highcharts_"+highcharts+".xml",
          dataType: "xml",
          success: function(xml) {
            var series = []

            //define series
            $(xml).find("entry").each(function() {
              var seriesOptions = {
                name: $(this).text(),
                data: []
              };
              options.series.push(seriesOptions);
            });

            //populate with data
            $(xml).find("row").each(function()
            {
                var t = parseInt($(this).find("t").text())*1000

                $(this).find("v").each(function(index){
                    var v = parseFloat($(this).text())
                    v = v || null
                    if (v != null) {
                      options.series[index].data.push([t,v])
                    };
                });
            });
            options.title.text = type + " of the last " + highcharts
            $.each(series, function(index) {
              options.series.push(series[index]);
            });

            chart = new Highcharts.Chart(options);
          }
        });


    });

    </script>
</script>
