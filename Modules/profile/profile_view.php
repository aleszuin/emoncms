<?php
global $path;
?>

<script type="text/javascript" src="<?php echo $path; ?>Modules/profile/profile.js"></script>
<!--[if IE]><script language="javascript" type="text/javascript" src="<?php echo $path;?>Lib/flot/excanvas.min.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="<?php echo $path;?>Lib/flot/jquery.flot.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path;?>Lib/flot/jquery.flot.time.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Lib/flot/jquery.flot.selection.min.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo $path; ?>Modules/feed/feed.js"></script>

<link href="<?php echo $path; ?>Lib/bootstrap-datetimepicker-0.0.11/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo $path; ?>Lib/bootstrap-datetimepicker-0.0.11/js/bootstrap-datetimepicker.min.js"></script>



<TABLE>
<TR>
<TH ALIGN=LEFT VALIGN=TOP>
<h1>Profile configuration</h1>
Type of profile :
<input type='checkbox' id='daily_cb' checked='checked'>daily profile
<input type='checkbox' id='weekly_cb' >Weekly profile

<br>
<div class="input-prepend">
<span class="add-on" style="width:180px; text-align:right;" >Feed to profile: </span>
<select id="feed" style="width:208px"></select>
</div>

&nbsp;&nbsp;Interval <div class="input-prepend input-append">
<select id="timestep_sel" style="width:130px">
<option value=60>Select interval</option>
<option value=5>5 mins</option>
<option value=10>10 mins</option>
<option value=20>20 mins</option>
<option value=30>30 mins</option>
<option value=60>1 hour</option>
<option value=120>2 hours</option>
<option value=240>4 hours</option>
</select>
</div>





<br>
Start date 
<div id="datetimepicker1" class="input-append date">
<input id="read-start-config" data-format="dd/MM/yyyy" type="text" />
<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
</div>

&nbsp;&nbsp;End date
<div id="datetimepicker2" class="input-append date">
<input id="read-end-config" data-format="dd/MM/yyyy" type="text" />
<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
</div>




<br>Days taken into account in daily profiles : <input type='checkbox' id='Su_cb' checked='checked'>Su
<input type='checkbox' id='Mo_cb' checked='checked'>Mo
<input type='checkbox' id='Tu_cb' checked='checked'>Tu
<input type='checkbox' id='We_cb' checked='checked'>We
<input type='checkbox' id='Th_cb' checked='checked'>Th
<input type='checkbox' id='Fr_cb' checked='checked'>Fr
<input type='checkbox' id='Sa_cb' checked='checked'>Sa


<br>Ignored days (comma seperated, ddmmyyyy format):<div class="input-append">
<input id="ignoreddays"  id="appendedInputButton" type="text" style="width:185px">
<button id="ignoreddays_ok" class="btn" type="button">Ok</button>
</div>
<br>
<br>
<button id="save" class="btn">Save profile configuration</button>

</TH>

<TH>

<div id="quick_graph_bound" style="width:500px; height:300px; position:relative; ">
<div id="quick_graph"></div>
</div>
<H4>Profile quick view</H4>
</TH>
</TR>

<TR>
<TD colspan=2>

<!--
<div class="input-prepend input-append">
  <span class="add-on" style="width:180px; text-align:right;" >printf: </span>
  <input type="text" id="print0" style="width:155px" />
  <input type="text" id="print1" style="width:155px" />
  <input type="text" id="print2" style="width:155px" />
  <input type="text" id="print3" style="width:155px" />
  <input type="text" id="print4" style="width:155px" />

</div>
-->

<div Align=center id="config_graph_bound" style="width:100%; height:200px; position:relative; ">
<div id="config_graph"></div>
</div>
<H4 Align=center>Range of data used to create the profile</H4><div Align=center>(Data in purple are not taken into account to create the profile)</div>
</TD>
</TR>

</TABLE>

<br>
<h1>Profile visualisation</h1>


<TABLE>
<TR>
<TH ALIGN=LEFT WIDTH=400>
Start date
<div id="datetimepicker3" class="input-append date">
<input id="read-start-vis" data-format="dd/MM/yyyy" type="text" />
<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
</div>

<br>End date
<div id="datetimepicker4" class="input-append date">
<input id="read-end-vis" data-format="dd/MM/yyyy" type="text" />
<span class="add-on"> <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
</div>

<br><div class="input-prepend input-append">
<span class="add-on" style="width:180px; text-align:right;" >Factor to the std deviation: </span>
<input type="text" id="factor" style="width:55px" />
<button id="factor_ok" class="btn" type="button">Ok</button>
</div>

</TH>
<TH ALIGN=LEFT>
&nbsp;&nbsp;<input type='checkbox' id='show_feed' checked='checked'><IMG src="<?php echo $path; ?>Modules/profile/greyline.png" width="50px">Feed 
<br>&nbsp;&nbsp;<input type='checkbox' id='show_average' checked='checked'><IMG src="<?php echo $path; ?>Modules/profile/blackline.png" width="50px">Averaged feed on the selected interval
<br>&nbsp;&nbsp;<input type='checkbox' id='show_up' checked='checked'><IMG src="<?php echo $path; ?>Modules/profile/redline.png" width="50px">Profile + <span id="textfactor">x</span> x standard deviation
<br>&nbsp;&nbsp;<input type='checkbox' id='show_profile' checked='checked'><IMG src="<?php echo $path; ?>Modules/profile/orangeline.png" width="50px">Profile
<br>&nbsp;&nbsp;<input type='checkbox' id='show_down' checked='checked'><IMG src="<?php echo $path; ?>Modules/profile/greenline.png" width="50px">Profile - <span id="textfactor2">x</span> x standard deviation
<br>&nbsp;&nbsp;<input type='checkbox' id='show_gap' checked='checked'><IMG src="<?php echo $path; ?>Modules/profile/blueline.png" width="50px">Gap (%) between average and profile : (avg-profile)/profile
</TH>


</TR>

</TABLE>

<div id="visual_graph_bound" style="width:100%; height:400px; position:relative; ">
<div id="visual_graph"></div>
</div>











<script >

var path = "<?php echo $path; ?>";
var apikey = "";

// To load the configuration of the current profile
var profile_id = <?php echo $profile_id; ?>;
var settings = profile.get(profile_id);

//To get the first phpfiwa feed id (will be used if the profile is not yet configured)
var first_phpfiwa_feed=0;
var feedlist = feed.list();
for (var z=0; z<feedlist.length; z++){
   if (feedlist[z].engine==6){
      first_phpfiwa_feed=feedlist[z].id;
      break;
   }
}

//To get the unix time of the last local midnight (will be used if the profile is not yet configured)
var offset = new Date().getTimezoneOffset(); 
var now = new Date().getTime();
var last_midnight = Math.floor(now/(24*3600000))*24*3600000+offset*60000; 

// Maximum point got per request (feed.get_data(...))
var maxnpointsperrequest = 800;

// If the profile is not yet configured, the following settings are used
if (settings==0){
   settings = {
      start_config : last_midnight - 30*3600000*24, //used for the config graph, one mont before last midgniht
      end_config :  last_midnight,                  //used for the config graph
      start_vis : last_midnight - 7*3600000*24, //used for the visualisation graph, one mont before last midgniht
      end_vis : last_midnight,                  //used for the visualisation graph
      daily_cb : true,     // daily profile
      weekly_cb : false,
                           //show_xxxx are used to show or hide data in the visualisation graph
      show_feed : false,   
      show_average : true,       
      show_up : false,           
      show_down : false,         
      show_profile : true,       
      show_gap : false,      
                           //xxxx_cb are used to include or exclude days of the week in the daily profiles
      Su_cb : false,       
      Mo_cb : true,             
      Tu_cb : true,             
      We_cb : true,
      Th_cb : true,
      Fr_cb : true,
      Sa_cb : false,
      feedid: first_phpfiwa_feed,
      timestep: 3600000,  // 1 hour
      factor :1,
      ignoreddays : []    //days ignored when constructing the profile
   };
}

//initialisation of the date time picker
$('#datetimepicker1').datetimepicker({pickTime: false, language: 'en-EN'});
$('#datetimepicker2').datetimepicker({pickTime: false, language: 'en-EN'});
$('#datetimepicker3').datetimepicker({pickTime: false, language: 'en-EN'});
$('#datetimepicker4').datetimepicker({pickTime: false, language: 'en-EN'});

//initialisation of the start/End text label
$("#read-start-config").val(new Date(settings.start_config).toLocaleDateString());
$("#read-end-config").val(new Date(settings.end_config).toLocaleDateString());
$("#read-start-vis").val(new Date(settings.start_vis).toLocaleDateString());
$("#read-end-vis").val(new Date(settings.end_vis).toLocaleDateString());



//initialisation of the graphs
var $config_graph_bound = $('#config_graph_bound');
var $config_graph = $('#config_graph').width($config_graph_bound.width()).height($('#config_graph_bound').height());

var $quick_graph_bound = $('#quick_graph_bound');
var $quick_graph = $('#quick_graph').width($quick_graph_bound.width()).height($('#quick_graph_bound').height());

var $visual_graph_bound = $('#visual_graph_bound');
var $visual_graph = $('#visual_graph').width($visual_graph_bound.width()).height($('#visual_graph_bound').height());


//initialisation of the check boxes
document.getElementById("daily_cb").checked=settings.daily_cb;
document.getElementById("weekly_cb").checked=settings.weekly_cb;
document.getElementById("show_average").checked=settings.show_average;
document.getElementById("show_up").checked=settings.show_up;
document.getElementById("show_down").checked=settings.show_down;
document.getElementById("show_profile").checked=settings.show_profile;
document.getElementById("show_gap").checked=settings.show_gap;

document.getElementById("Su_cb").checked=settings.Su_cb;
document.getElementById("Mo_cb").checked=settings.Mo_cb;
document.getElementById("Tu_cb").checked=settings.Tu_cb;
document.getElementById("We_cb").checked=settings.We_cb;
document.getElementById("Th_cb").checked=settings.Th_cb;
document.getElementById("Fr_cb").checked=settings.Fr_cb;
document.getElementById("Sa_cb").checked=settings.Sa_cb;

//initialisation of the check boxes
if (settings.weekly_cb){
      document.getElementById("Su_cb").disabled=true;
      document.getElementById("Mo_cb").disabled=true;
      document.getElementById("Tu_cb").disabled=true;
      document.getElementById("We_cb").disabled=true;
      document.getElementById("Th_cb").disabled=true;
      document.getElementById("Fr_cb").disabled=true;
      document.getElementById("Sa_cb").disabled=true;
   } else {
      document.getElementById("Su_cb").disabled=false;
      document.getElementById("Mo_cb").disabled=false;
      document.getElementById("Tu_cb").disabled=false;
      document.getElementById("We_cb").disabled=false;
      document.getElementById("Th_cb").disabled=false;
      document.getElementById("Fr_cb").disabled=false;
      document.getElementById("Sa_cb").disabled=false;
   } 

simulate();

function simulate() {  
   var profile = {};
   var feed_data=[];           //feed data for the config graph
   var feed_data2=[];          //feed data for the visualisation graph
   var quick_profile_data=[];  //profile data for the quick graph
   var average=[];             //average data on the range start/end
   var average_data=[];        //average data for the visualisation grap
   var profile_data=[];        //profile data for the visualisation grap
   var gap_data=[];            //gap data for the visualisation grap        
   var up_data=[];             //up data (profile + factor * std dev) for the visualisation grap
   var down_data=[];           //down data (profile - factor * std dev) data for the visualisation grap
   var time;
   var data;
   var data_length;
   var excludeddayoftheweek =[];//excluded day in the week (onlyfor daily profile)
   var datestring;
   var day;
   var endprofile
   var ndays=1;                 //number of days of the profile (1=daily, 7=weekly)


   //To exclude some days of the week in daily profiles
   if (settings.daily_cb){
      if (!settings.Su_cb) excludeddayoftheweek.push(0);
      if (!settings.Mo_cb) excludeddayoftheweek.push(1);
      if (!settings.Tu_cb) excludeddayoftheweek.push(2);
      if (!settings.We_cb) excludeddayoftheweek.push(3);
      if (!settings.Th_cb) excludeddayoftheweek.push(4);
      if (!settings.Fr_cb) excludeddayoftheweek.push(5);
      if (!settings.Sa_cb) excludeddayoftheweek.push(6);
   }

   document.getElementById("textfactor").innerHTML=settings.factor;
   document.getElementById("textfactor2").innerHTML=settings.factor;



   //Let's get the feed data for the config graph
   feed_data = feed.get_data(settings.feedid,settings.start_config,settings.end_config,maxnpointsperrequest);
   

   //Let's get the feed data without the day excluded or ignored
   feed_data_cleared = feed.get_data(settings.feedid,settings.start_config,settings.end_config,maxnpointsperrequest);
   for (var z=0; z<feed_data_cleared.length; z++){
     datestring = to_date_str(feed_data_cleared[z][0]);
     day = new Date (feed_data_cleared[z][0]).getDay();
     if((excludeddayoftheweek.indexOf(day)!=-1) || (settings.ignoreddays.indexOf(datestring)!=-1))
        delete feed_data_cleared[z];
   }
 
   //Let's get the feed data for the visualisation graph without the day excluded or ignored
   feed_data2 = feed.get_data(settings.feedid,settings.start_vis,settings.end_vis,maxnpointsperrequest);   
   for (var z=0; z<feed_data2.length; z++){
     datestring = to_date_str(feed_data2[z][0]);
     day = new Date (feed_data2[z][0]).getDay();
     if((excludeddayoftheweek.indexOf(day)!=-1) || (settings.ignoreddays.indexOf(datestring)!=-1))
        delete feed_data2[z];
   }
 
   // Let's get the average of the feed foreach time step
   // Several request are needed if the number of point exceed the maximum number of point per request.
   // Then the requests are concatenated
   // It's quite dirty ... IS THERE ANOTHER WAY TO DO THAT ?

   var npoints = Math.round((settings.end_config-settings.start_config)/settings.timestep);
   var nrequests = Math.ceil(npoints/maxnpointsperrequest);
   for (var n=1; n<nrequests; n++){   
       average = average.concat(feed.get_data(
          settings.feedid,
          settings.start_config+(n-1)*maxnpointsperrequest*settings.timestep,
          settings.start_config+n*maxnpointsperrequest*settings.timestep,
          maxnpointsperrequest));
   }
   average = average.concat(feed.get_data(
      settings.feedid,
      settings.start_config+(nrequests-1)*maxnpointsperrequest*settings.timestep,
      settings.end_config,
      (settings.end_config-(settings.start_config+(nrequests-1)*maxnpointsperrequest*settings.timestep))/settings.timestep));


   // Same operation for the visualisation graph
   npoints = Math.round((settings.end_vis-settings.start_vis)/settings.timestep);
   nrequests = Math.ceil(npoints/maxnpointsperrequest);
   for (var n=1; n<nrequests; n++){   
       average_data = average_data.concat(feed.get_data(
          settings.feedid,
          settings.start_vis+(n-1)*maxnpointsperrequest*settings.timestep,
          settings.start_vis+n*maxnpointsperrequest*settings.timestep,
          maxnpointsperrequest));
   }
   average_data = average_data.concat(feed.get_data(
      settings.feedid,
      settings.start_vis+(nrequests-1)*maxnpointsperrequest*settings.timestep,
      settings.end_vis,
      (settings.end_vis-(settings.start_vis+(nrequests-1)*maxnpointsperrequest*settings.timestep))/settings.timestep));




   // Let's look at the average feed to build the profile
   for (var z=0; z<average.length; z++){
      //each value of the profile has a label naed "time". Its value is :
      //       - Xhh:mm:ss for the daily profil where W is the number of the day in the week
      //       - hh:mm:ss for the daily profiles

      if (settings.weekly_cb) 
         time = new Date(average[z][0]).getDay()+new Date(average[z][0]).toLocaleTimeString();
      else
         time = new Date(average[z][0]).toLocaleTimeString();
      
      data = average[z][1];
      datestring = to_date_str(average[z][0]);
      day = new Date (average[z][0]).getDay();
      
      //If it's not a day excluded or ignored
      if((excludeddayoftheweek.indexOf(day)==-1) &&
      (settings.ignoreddays.indexOf(datestring)==-1)) {
        
         //if the profile exist for the label "time" then let's update the profile for that label
         if (profile[time]){
            profile[time].profile_sum+=data;                                                      // sum of each value
            profile[time].profile_sumsqrt+=data*data;                                             // sum of squared values
            profile[time].profile_nb_data++;                                                      // number of value
            profile[time].profile_value=profile[time].profile_sum/profile[time].profile_nb_data;  // averageand standard deviation
            profile[time].profile_stdderiv=Math.sqrt(profile[time].profile_sumsqrt/profile[time].profile_nb_data-profile[time].profile_value*profile[time].profile_value);                  
         }
         //otherwise let's create it
         else {
            profile[time]= {
               profile_sum: data,
               profile_sumsqrt: data*data,
               profile_nb_data : 1,
               profile_value : data,
               profile_stdderiv : 0
            };
         }
      }
   }

   // let's set the number of day of the profile
   if (settings.weekly_cb) ndays=7; else ndays=1;

   // Let's create the data for the profile quick view 
   for (var t=settings.start_config; t<settings.start_config+ndays*24*3600000; t+=settings.timestep){
      if (settings.weekly_cb) 
         time = new Date(t).getDay()+new Date(t).toLocaleTimeString();
      else
         time = new Date(t).toLocaleTimeString();
      if (profile[time])
         quick_profile_data.push([t,profile[time].profile_value]);     
   }


   // Let's create the data for the visualisation graph (the profile, the gap, ...)
   for (var z=0; z<average_data.length; z++){
      if (settings.weekly_cb) 
         time = new Date(average_data[z][0]).getDay()+new Date(average_data[z][0]).toLocaleTimeString();
      else
         time = new Date(average_data[z][0]).toLocaleTimeString();
      
      datestring = to_date_str(average_data[z][0]);
      day = new Date (average_data[z][0]).getDay();

      //If it's not a day excluded or ignored
      if((excludeddayoftheweek.indexOf(day)==-1) &&
      (settings.ignoreddays.indexOf(datestring)==-1) && profile[time]) {
         profile_data.push([average_data[z][0],profile[time].profile_value]);
         gap_data.push([average_data[z][0],(average_data[z][1]-profile[time].profile_value)/profile[time].profile_value*100]);
         up_data.push([average_data[z][0],settings.factor*profile[time].profile_stdderiv+profile[time].profile_value]);
         down_data.push([average_data[z][0],-settings.factor*profile[time].profile_stdderiv+profile[time].profile_value]);
      }
   }

   // Let's duplicate the value to create stairs
   data_length=average_data.length;
   for (var z=0; z<data_length; z++){
     datestring = to_date_str(average_data[z][0]);
     day = new Date (average_data[z][0]).getDay();
     //If it's a day excluded or ignored, lets clear the data
     if((excludeddayoftheweek.indexOf(day)!=-1) || (settings.ignoreddays.indexOf(datestring)!=-1))
        delete average_data[z];
     else
      average_data.push([average_data[z][0]+settings.timestep-1,average_data[z][1]]);
   } 

   // Let's duplicate the value to create stairs
   data_length=profile_data.length;
   for (var z=0; z<data_length; z++){
      profile_data.push([profile_data[z][0]+settings.timestep-1,profile_data[z][1]]);
      gap_data.push([gap_data[z][0]+settings.timestep-1,gap_data[z][1]]);
      up_data.push([up_data[z][0]+settings.timestep-1,up_data[z][1]]);
      down_data.push([down_data[z][0]+settings.timestep-1,down_data[z][1]]);
   } 
   
   // Let's duplicate the value to create stairs  
   data_length=quick_profile_data.length;
   for (var z=0; z<data_length; z++){
      quick_profile_data.push([quick_profile_data[z][0]+settings.timestep-1,quick_profile_data[z][1]]);
   }  
  
   // Let's sort the value to create stairs
   average_data.sort();
   profile_data.sort();
   quick_profile_data.sort();
   gap_data.sort();
   up_data.sort();
   down_data.sort();


   // feeds for the visualisation graph
   var feeds = [
      {data: feed_data2, lines: { show: document.getElementById("show_feed").checked, fill: false, lineWidth: 2}, color: "rgba(192,192,192,1)"},
      {data: profile_data, lines: { show: document.getElementById("show_profile").checked, fill: false, lineWidth: 2}, color: "rgba(255,128,0,1)"},
      {data: average_data, lines: { show: document.getElementById("show_average").checked, fill: false, lineWidth: 3}, color: "rgba(0,0,0,1)"},
      {data: gap_data, yaxis: 2, lines: { show: document.getElementById("show_gap").checked, fill: false, lineWidth: 2}, color: "rgba(0,0,255,1)"},
      {data: up_data, lines: { show: document.getElementById("show_up").checked, fill: false, lineWidth: 2}, color: "rgba(255,0,0,1)"},
      {data: down_data, lines: { show: document.getElementById("show_down").checked, fill: false, fillColor: "rgba(255,255,255,0.5)", lineWidth: 2}, color: "rgba(0,255,0,1)"}
   ];

   // Let'splot the configuration graph
   var plot = $.plot($config_graph, 
      [{data: feed_data, lines: { show: true, fill: false,lineWidth: 2 }, color: "rgba(255,0,192,1)"},{data: feed_data_cleared, lines: { show: true, fill: false,lineWidth: 2 }, color: "rgba(192,192,192,1)"}], 
      {
      grid: { show: true, hoverable: false, clickable: true },
      xaxis: { mode: "time", timezone: "browser", min: settings.start_config, max: settings.end_config },
      selection: { mode: "xy" }
   });

   endprofile=settings.start_config + ndays * 24 * 3600000; 

   // Let'splot the profile quick view
   if (ndays==7){
   var quick_plot = $.plot($quick_graph, 
      [{data: quick_profile_data, lines: { show: true, fill: false,lineWidth: 2 }, color: "rgba(255,128,0,1)"}], 
      {
      grid: { show: true, hoverable: false, clickable: true },
      xaxis: {     timeformat: "%a", mode: "time", timezone: "browser", min: settings.start_config, max: endprofile },
      yaxis: {min: 0 },
      selection: { mode: "xy" }
   });
   } else{
   var quick_plot = $.plot($quick_graph, 
      [{data: quick_profile_data, lines: { show: true, fill: false,lineWidth: 2 }, color: "rgba(255,128,0,1)"}], 
      {
      grid: { show: true, hoverable: false, clickable: true },
      xaxis: {mode: "time", timezone: "browser", min: settings.start_config, max: endprofile },
      yaxis: {min: 0 },
      selection: { mode: "xy" }
   });
   } 

   // Let'splot the visualisation graph
   var plot2 = $.plot($visual_graph, feeds, {
      grid: { show: true, hoverable: false, clickable: true },
      xaxis: { mode: "time", timezone: "browser", min: settings.start_vis, max: settings.end_vis },
      selection: { mode: "xy" }
   });

}



// Populate feed selectors only with phpfiwa feeds

var out = "", selected = "";
for (z in feedlist) {
if (feedlist[z].id==settings.feedid) selected = 'selected'; else selected = '';
if (feedlist[z].engine==6) out += "<option value='"+z+"' "+selected+">"+feedlist[z].name+"</option>";
}
$("#feed").html(out);


$("#timestep_sel").val(settings.timestep/60000);

$("#factor").val(settings.factor);

$("#factor_ok").click(function(){
   settings.factor = $("#factor").val();
   simulate();
});


// feed selector controllers
$("#feed").click(function(){
   var z = $(this).val();
   if (feedlist[z].id!=settings.feedid) { 
      settings.feedid = feedlist[z].id;
      // the start date must be after the first midnight (see function "get_first_midnight")
      // otherwise the concatenation if several request fails 
      var first_midnight=get_first_midnight(settings.feedid)
      if (settings.start_config<first_midnight)
         settings.start_config=first_midnight;
      // the end date must be after the start date
      if (settings.start_config>=settings.end_config)
         settings.end_config=settings.start_config+24*3600000;
   $("#read-start-config").val(new Date(settings.start_config).toLocaleDateString());
   $("#read-end-config").val(new Date(settings.end_config).toLocaleDateString());
   simulate();
   }
});


$("#timestep_sel").click(function(){
      settings.timestep = $(this).val()*60000;
      simulate();
});



$("#ignoreddays").val(settings.ignoreddays.join(","));

$("#ignoreddays_ok").click(function(){
   var str = $("#ignoreddays").val();
   settings.ignoreddays = str.split(",");
   $("#ignoreddays").val(settings.ignoreddays.join(","));
   simulate();
});




$("#weekly_cb, #daily_cb").click(function(){
   settings.daily_cb=!settings.daily_cb;
   settings.weekly_cb=!settings.weekly_cb;
   document.getElementById("daily_cb").checked=settings.daily_cb;
   document.getElementById("weekly_cb").checked=settings.weekly_cb;


   if (settings.weekly_cb){
      document.getElementById("Su_cb").disabled=true;
      document.getElementById("Mo_cb").disabled=true;
      document.getElementById("Tu_cb").disabled=true;
      document.getElementById("We_cb").disabled=true;
      document.getElementById("Th_cb").disabled=true;
      document.getElementById("Fr_cb").disabled=true;
      document.getElementById("Sa_cb").disabled=true;
   } else {
      document.getElementById("Su_cb").disabled=false;
      document.getElementById("Mo_cb").disabled=false;
      document.getElementById("Tu_cb").disabled=false;
      document.getElementById("We_cb").disabled=false;
      document.getElementById("Th_cb").disabled=false;
      document.getElementById("Fr_cb").disabled=false;
      document.getElementById("Sa_cb").disabled=false;
   } 

   simulate();
});

$("#show_feed").click(function(){
   settings.show_feed=!settings.show_feed;
   simulate();
});

$("#show_average").click(function(){
   settings.show_average=!settings.show_average;
   simulate();
});

$("#show_profile").click(function(){
   settings.show_profile=!settings.show_profile;
   simulate();
});

$("#show_gap").click(function(){
   settings.show_gap=!settings.show_gap;
   simulate();
});

$("#show_up").click(function(){
   settings.show_up=!settings.show_up;
   simulate();
});

$("#show_down").click(function(){
   settings.show_down=!settings.show_down;
   simulate();
});

$("#Su_cb").click(function(){
   settings.Su_cb=!settings.Su_cb;
   simulate();
});

$("#Mo_cb").click(function(){
   settings.Mo_cb=!settings.Mo_cb;
   simulate();
});

$("#Tu_cb").click(function(){
   settings.Tu_cb=!settings.Tu_cb;
   simulate();
});

$("#We_cb").click(function(){
   settings.We_cb=!settings.We_cb;
   simulate();
});

$("#Th_cb").click(function(){
   settings.Th_cb=!settings.Th_cb;
   simulate();
});

$("#Fr_cb").click(function(){
   settings.Fr_cb=!settings.Fr_cb;
   simulate();
});

$("#Sa_cb").click(function(){
   settings.Sa_cb=!settings.Sa_cb;
   simulate();
});


// date time picker of the start date
$('#datetimepicker1').on('changeDate', function(e) { 
   
   // the start date must be after the first midnight (see function "get_first_midnight")
   // otherwise the concatenation if several request fails
   var first_midnight=get_first_midnight(settings.feedid)
   settings.start_config=parse_timepicker_time($("#read-start-config").val());
   if (settings.start_config<first_midnight)
      settings.start_config=first_midnight;
   
   // the end date must be after the start date
   if (settings.start_config>=settings.end_config)
      settings.end_config=settings.start_config+24*3600000;

   $('#datetimepicker1').data('datetimepicker').setLocalDate(new Date(settings.start_config));
   $("#read-start-config").val(new Date(settings.start_config).toLocaleDateString());
   $("#read-end-config").val(new Date(settings.end_config).toLocaleDateString());
   simulate();
});

// date time picker of the end date
$('#datetimepicker2').on('changeDate', function(e) { 
   
   // the end date must be after the first midnight +24h (see function "get_first_midnight")
   // otherwise the concatenation if several request fails
   var first_midnight=get_first_midnight(settings.feedid);
   settings.end_config=parse_timepicker_time($("#read-end-config").val());
   if (settings.end_config<first_midnight+24*3600000){
         settings.start_config=first_midnight;
         settings.end_config=first_midnight+24*3600000;

   }
   // the end date must be after the start date
   if (settings.end_config<=settings.start_config){
         settings.start_config=settings.end_config-24*3600000;
   }
   
   $('#datetimepicker2').data('datetimepicker').setLocalDate(new Date(settings.end_config));
   $("#read-start-config").val(new Date(settings.start_config).toLocaleDateString());
   $("#read-end-config").val(new Date(settings.end_config).toLocaleDateString());
   simulate();
});




$('#datetimepicker3, #datetimepicker4').on('changeDate', function(e) { 
   settings.start_vis = parse_timepicker_time($("#read-start-vis").val());
   settings.end_vis  = parse_timepicker_time($("#read-end-vis").val());
   $("#read-start-vis").val(new Date(settings.start_vis).toLocaleDateString());
   $("#read-end-vis").val(new Date(settings.end_vis).toLocaleDateString());   
   simulate();
});



$("#save").click(function(){
   profile.save(profile_id,settings); 
});


// The first midnight is the unix time that corespond to the first local midnight when a feed is defined.
//As an example is the feed is created the 22th of august 2014 at 12:30:10 in Paris, the first midnigt will be the unix time of the 23th of august 2014 at 00:00:00 in Paris
function get_first_midnight(feedid){
   var temp = feed.get_data(feedid,new Date(2010,1,1,0,0,0,0).getTime(),new Date().getTime(),maxnpointsperrequest);
   var offset = new Date(temp[0][0]).getTimezoneOffset();
   var first_midnight = (Math.ceil(temp[0][0]/(24*3600000)))*24*3600000+offset*60000; 
   temp = feed.get_data(feedid,first_midnight,new Date().getTime(),maxnpointsperrequest);
   while (temp[0][0]!=first_midnight){
      first_midnight += 24*3600000;
      temp = feed.get_data(feedid,first_midnight,new Date().getTime(),maxnpointsperrequest);
   }
   return first_midnight;
}


function to_date_str(unixtime){
   var date=new Date(unixtime).getDate();
   if (date<10) date="0".concat(date);
   var month=new Date(unixtime).getMonth()+1;
   if (month<10) month="0".concat(month);
   var year=new Date(unixtime).getFullYear().toString();
   return date+month+year;
}

function parse_timepicker_time(timestr){
   var tmp = timestr.split(" ");
   var date = tmp[0].split("/");
   if (date.length!=3) return false;
   return new Date(date[2],date[1]-1,date[0],0,0,0,0).getTime();
}
</script>
