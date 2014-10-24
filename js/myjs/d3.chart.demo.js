
	function initWidth($id){
		if($id==-1) return 900;
    	var w=document.querySelector("#chart"+$id).clientWidth;
		return w;	
    }
	jsn={
		"name": "任务总数",
		"size": 2
	}
		    
	function drawChart($id,json){
		var panelwidth=initWidth($id);
		var chart_id="#chart";
		if($id!=-1) chart_id+=$id;
		var w = panelwidth-50,
		    h = 367,
		    x = d3.scale.linear().range([0, w]),
		    y = d3.scale.linear().range([0, h]);

		d3.select(chart_id).html("<div><h3>任务分布</h3></div>");
		var vis = d3.select(chart_id).attr("class","maptree_chart").append("div")
		    .attr("class", "chart")
		    .style("width", w + "px")
		    .style("height", h + "px")
		  .append("svg:svg")
		    .attr("width", w)
		    .attr("height", h);

		var partition = d3.layout.partition()
		    .value(function(d) { return d.size; });

		//d3.json(jsn, function(j) {
		  var g = vis.selectAll("g")
		      .data(partition.nodes(json))
		    .enter().append("svg:g")
		      .attr("transform", function(d) { return "translate(" + x(d.y) + "," + y(d.x) + ")"; })
		      .on("click", click);

		  var kx = w / json.dx,
		      ky = h / 1;

		  g.append("svg:rect")
		      .attr("width", json.dy * kx)
		      .attr("height", function(d) { return d.dx * ky; })
		      .attr("class", function(d) { return d.children ? "parent" : "child"; });

		  g.append("svg:text")
		      .attr("transform", transform)
		      .attr("dy", ".35em")
		      .style("opacity", function(d) { return d.dx * ky > 12 ? 1 : 0; })
		      .text(function(d) { return d.name; })

		  d3.select(window)
		      .on("click", function() { click(root); })

		  function click(d) {
		    if (!d.children) return;

		    kx = (d.y ? w - 40 : w) / (1 - d.y);
		    ky = h / d.dx;
		    x.domain([d.y, 1]).range([d.y ? 40 : 0, w]);
		    y.domain([d.x, d.x + d.dx]);

		    var t = g.transition()
		        .duration(d3.event.altKey ? 7500 : 750)
		        .attr("transform", function(d) { return "translate(" + x(d.y) + "," + y(d.x) + ")"; });

		    t.select("rect")
		        .attr("width", d.dy * kx)
		        .attr("height", function(d) { return d.dx * ky; });

		    t.select("text")
		        .attr("transform", transform)
		        .style("opacity", function(d) { return d.dx * ky > 12 ? 1 : 0; });

		    d3.event.stopPropagation();
		  }

		  function transform(d) {
		    return "translate(8," + d.dx * ky / 2 + ")";
		  }
		//});

		}
	
	
	function dashboard($id, fData){
		var chart_id="#chart";
		if($id!=-1) chart_id+=$id;
		
		var width=initWidth($id);
		var title=d3.select(chart_id).attr("class","column_pie_chart").html("").append("div")
			.attr("class","title").append("h3").text("【Mobogenie Android端】当前版本bug分布情况")
	    var barColor = 'steelblue';
		function segColor(c){ return {NEW:"#807dba",正在处理:"#CCCCCC",重新打开:"#7CB5EC", 已解决:"#e08214",已关闭:"#41ab5d"}[c]; }
	    // compute total for each state.
	    fData.forEach(function(d){d.total=parseInt(d.freq.NEW)+d.freq.正在处理+d.freq.重新打开+d.freq.已解决+d.freq.已关闭;});
	    // function to handle histogram.
	    function histoGram(fD){
	        var hG={},    hGDim = {t: 60, r: 0, b: 50, l: 0};
	        hGDim.w = initWidth($id)*0.6 - hGDim.l - hGDim.r, 
	        hGDim.h = 395 - hGDim.t - hGDim.b;
	            
	        //create svg for histogram.
	        var hGsvg = d3.select(chart_id).append("div").attr("class","column").append("svg")
	            .attr("width", hGDim.w + hGDim.l + hGDim.r)
	            .attr("height", hGDim.h + hGDim.t + hGDim.b).append("g")
	            .attr("transform", "translate(" + hGDim.l + "," + hGDim.t + ")");

	        // create function for x-axis mapping.
	        var x = d3.scale.ordinal().rangeRoundBands([0, hGDim.w], 0.1)
	                .domain(fD.map(function(d) { return d[0]; }));

	        // Add x-axis to the histogram svg.
	        hGsvg.append("g").attr("class", "x axis")
	            .attr("transform", "translate(0," + hGDim.h + ")")
	            .call(d3.svg.axis().scale(x).orient("bottom"))
	            .selectAll("text")
	            .attr("dx", "-20")
	            .attr("dy", "-.6em")
	            .attr("transform", "rotate(-65)");

	        // Create function for y-axis map.
	        var y = d3.scale.linear().range([hGDim.h, 0])
	                .domain([0, d3.max(fD, function(d) { return d[1]; })]);

	        // Create bars for histogram to contain rectangles and freq labels.
	        var bars = hGsvg.selectAll(".bar").data(fD).enter()
	                .append("g").attr("class", "bar");
	        
	        //create the rectangles.
	        bars.append("rect")
	            .attr("x", function(d) { return x(d[0]); })
	            .attr("y", function(d) { return y(d[1]); })
	            .attr("width", x.rangeBand())
	            .attr("height", function(d) { return hGDim.h - y(d[1]); })
	            .attr('fill',barColor)
	            .on("mouseover",mouseover)// mouseover is defined below.
	            .on("mouseout",mouseout);// mouseout is defined below.
	            
	        //Create the frequency labels above the rectangles.
	        bars.append("text").text(function(d){ return d3.format(",")(d[1])})
	            .attr("x", function(d) { return x(d[0])+x.rangeBand()/2; })
	            .attr("y", function(d) { return y(d[1])-5; })
	            .attr("text-anchor", "middle");
	        
	        function mouseover(d){  // utility function to be called on mouseover.
	            // filter for selected state.
	            var st = fData.filter(function(s){ return s.State == d[0];})[0],
	                nD = d3.keys(st.freq).map(function(s){ return {type:s, freq:st.freq[s]};});
	               
	            // call update functions of pie-chart and legend.    
	            pC.update(nD);
	            leg.update(nD);
	        }
	        
	        function mouseout(d){    // utility function to be called on mouseout.
	            // reset the pie-chart and legend.    
	            pC.update(tF);
	            leg.update(tF);
	        }
	        
	        // create function to update the bars. This will be used by pie-chart.
	        hG.update = function(nD, color){
	            // update the domain of the y-axis map to reflect change in frequencies.
	            y.domain([0, d3.max(nD, function(d) { return d[1]; })]);
	            
	            // Attach the new data to the bars.
	            var bars = hGsvg.selectAll(".bar").data(nD);
	            
	            // transition the height and color of rectangles.
	            bars.select("rect").transition().duration(500)
	                .attr("y", function(d) {return y(d[1]); })
	                .attr("height", function(d) { return hGDim.h - y(d[1]); })
	                .attr("fill", color);

	            // transition the frequency labels location and change value.
	            bars.select("text").transition().duration(500)
	                .text(function(d){ return d3.format(",")(d[1])})
	                .attr("y", function(d) {return y(d[1])-15; });            
	        }        
	        return hG;
	    }
	    
	    // function to handle pieChart.
	    function pieChart(pD){
	    var pC ={},    pieDim ={w:width/ 6, h: 200};
	        
	        pieDim.r = width/ 12;
	                
	        // create svg for pie chart.
	        var piesvg = d3.select(chart_id).append("div").attr("class","pie").append("svg")
	            .attr("width", pieDim.w).attr("height", pieDim.h).append("g")
	            .attr("transform", "translate("+pieDim.w/2+","+pieDim.h/2+")");
	        
	        // create function to draw the arcs of the pie slices.
	        var arc = d3.svg.arc().outerRadius(pieDim.r - 21).innerRadius(0);

	        // create a function to compute the pie slice angles.
	        var pie = d3.layout.pie().sort(null).value(function(d) { return d.freq; });

	        // Draw the pie slices.
	        piesvg.selectAll("path").data(pie(pD)).enter().append("path").attr("d", arc)
	            .each(function(d) { this._current = d; })
	            .style("fill", function(d) { return segColor(d.data.type); })
	            .on("mouseover",mouseover).on("mouseout",mouseout);

	        // create function to update pie-chart. This will be used by histogram.
	        pC.update = function(nD){
	            piesvg.selectAll("path").data(pie(nD)).transition().duration(500)
	                .attrTween("d", arcTween);
	        }        
	        // Utility function to be called on mouseover a pie slice.
	        function mouseover(d){
	            // call the update function of histogram with new data.
	            hG.update(fData.map(function(v){ 
	                return [v.State,v.freq[d.data.type]];}),segColor(d.data.type));
	        }
	        //Utility function to be called on mouseout a pie slice.
	        function mouseout(d){
	            // call the update function of histogram with all data.
	            hG.update(fData.map(function(v){
	                return [v.State,v.total];}), barColor);
	        }
	        // Animating the pie-slice requiring a custom function which specifies
	        // how the intermediate paths should be drawn.
	        function arcTween(a) {
	            var i = d3.interpolate(this._current, a);
	            this._current = i(0);
	            return function(t) { return arc(i(t));    };
	        }    
	        return pC;
	    }
	    
	    // function to handle legend.
	    function legend(lD){
	        var leg = {};
	            
	        // create table for legend.
	        var legend = d3.select(chart_id).append("table").attr('class','legend');
	        
	        // create one row per segment.
	        var tr = legend.append("tbody").selectAll("tr").data(lD).enter().append("tr");
	            
	        // create the first column for each segment.
	        tr.append("td").attr("class",'legendColor').append("svg").attr("width", '10').attr("height", '10').append("rect")
	            .attr("width", '10').attr("height", '10')
				.attr("fill",function(d){ return segColor(d.type); });
	            
	        // create the second column for each segment.
	        tr.append("td").text(function(d){ return d.type;});

	        // create the third column for each segment.
	        tr.append("td").attr("class",'legendFreq')
	            .text(function(d){ return d3.format(",")(d.freq);});

	        // create the fourth column for each segment.
	        tr.append("td").attr("class",'legendPerc')
	            .text(function(d){ return getLegend(d,lD);});

	        // Utility function to be used to update the legend.
	        leg.update = function(nD){
	            // update the data attached to the row elements.
	            var l = legend.select("tbody").selectAll("tr").data(nD);

	            // update the frequencies.
	            l.select(".legendFreq").text(function(d){ return d3.format(",")(d.freq);});

	            // update the percentage column.
	            l.select(".legendPerc").text(function(d){ return getLegend(d,nD);});        
	        }
	        
	        function getLegend(d,aD){ // Utility function to compute percentage.
	            return d3.format("%")(d.freq/d3.sum(aD.map(function(v){ return v.freq; })));
	        }

	        return leg;
	    }
	    
	    // calculate total frequency by segment for all state.
	    var tF = ['NEW','正在处理','重新打开','已解决','已关闭'].map(function(d){ 
	        return {type:d, freq: d3.sum(fData.map(function(t){ return t.freq[d];}))}; 
	    });    
	    
	    // calculate total frequency by state for all segment.
	    var sF = fData.map(function(d){return [d.State,d.total];});

	    var hG = histoGram(sF), // create the histogram.
	        pC = pieChart(tF), // create the pie-chart.
	        leg= legend(tF);  // create the legend.
	}

 				