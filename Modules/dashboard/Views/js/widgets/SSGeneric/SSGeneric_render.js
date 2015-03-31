function SSGeneric_widgetlist()
{
  var widgets = {
    "SSGeneric":
    {
      "offsetx":-80,"offsety":-80,"width":200,"height":200,
      "menu":"Widgets",
      "options"		:["feed", "generictype", "type","framedesign", "backgroundcolour","pointercolour","PointerType","LcdColor","LedColor","ForegroundType","title", "unit", "threshold","sections","areas","minvalue","maxvalue"],
      "optionstype"	:["feed","generictype", "type", "framedesign", "backgroundcolour","pointercolour","PointerType","LcdColor","LedColor","ForegroundType","value","value","value", "sections", "areas","value","value"],
      "optionsname"	:[ _Tr("Feed"),_Tr("Generictype Selector"),  _Tr("Type Selector"), _Tr("Frame Design"), _Tr("Backgroundcolour"), _Tr("Pointercolour"), _Tr("PointerType"), _Tr("LcdColor"), _Tr("LedColor"),_Tr("ForegroundType"),_Tr("Title"),_Tr("Units"),_Tr("Threshold"),_Tr("Sections"),_Tr("Areas"),_Tr("Min Value"),_Tr("Max Value")],
      "optionshint"	:[_Tr(""),_Tr(""),_Tr("1/4, 1/2, 3/4, Full"),_Tr(""),_Tr(""),_Tr(""),_Tr(""),_Tr(""),_Tr(""),_Tr(""),_Tr("Title"),_Tr("Units to show"),_Tr("Led will Blink if Exceeded"),_Tr("Define section colours"),_Tr("Define area colours"),_Tr(""),_Tr(""),] 
    }
  }
  return widgets;
}

function SSGeneric_init()
{
  setup_widget_canvas('SSGeneric');//add init
  setup_steelseries_object('SSGeneric');
}



function SSGeneric_draw()
{
	$('.SSGeneric').each(function(index){
	//REVISE
	var feed = $(this).attr("feed");
	if (feed==undefined){feed=0;}
	
	var val = assoc[feed];
    if (val==undefined) val = 0;

	
	if (val != temp){//redraw?
        try {
              var generictype = $(this).attr("generictype");
              if (generictype == undefined)  {  generictype="Compass"  };
              // Per ogni tipologia di controllo Steel esistente
              if (generictype=="Compass"){
                 if (val < 0)  val = 0;
                 val = val % 360;
                 SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
              }
              else if (generictype=="WindDirection"){
                 if (val < 0)  val = 0;
                 val = val % 360;
                 SteelseriesObjects[$(this).attr("id")].setValueAnimatedLatest(val);
                 SteelseriesObjects[$(this).attr("id")].setValueAnimatedAverage(val);
              }
              else if (generictype=="Level"){
                 if (val < 0)  val = 0;
                 val = val % 360;
                 SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
              }
              else if (generictype=="Horizon"){
                 if (val < -50)  val = -50;
                 val = val % 100;
                 SteelseriesObjects[$(this).attr("id")].setPitchAnimated(val);
                 SteelseriesObjects[$(this).attr("id")].setRollAnimated(val+10);
              }
              else if (generictype=="Led"){
                 if (val < 0)  val = 0;
                 val = val % 7;
                 var colore = "";
                 switch (val) {
                     case 0:
                        colore = "RED_LED";
                        break;
                     case 1:
                        colore = "GREEN_LED";
                        break;
                     case 2:
                        colore = "BLUE_LED";
                        break;
                     case 3:
                        colore = "ORANGE_LED";
                        break;
                     case 4:
                        colore = "YELLOW_LED";
                        break;
                     case 5:
                        colore = "CYAN_LED";
                        break;
                     case 6:
                        colore = "MAGENTA_LED";
                        break;
                     default:
                        colore = "RED_LED";
                  }
                 SteelseriesObjects[$(this).attr("id")].setLedColor(colore);
              }
              else if (generictype=="Clock"){
                 SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
              }
              else if (generictype=="Battery"){
                 SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
              }
              else if (generictype=="Altimeter"){
                 SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
              }
              else if (generictype=="Odometer"){
                 SteelseriesObjects[$(this).attr("id")].setValue(val);
              }
              else if (generictype=="LightBulb"){
                 //SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
                 SteelseriesObjects[$(this).attr("id")].setOn(val > 0);
                 SteelseriesObjects[$(this).attr("id")].setAlpha(val % 100);
              }
              else if (generictype=="gradientWrapper"){
                 SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
              }
              else if (generictype=="StopWatch"){
                 SteelseriesObjects[$(this).attr("id")].setValueAnimated(val);
              }

        }
        catch (err)
        {
            err = err;
        }
		var temp =val;
		}
    });
}

function draw_SSGeneric(){

}

function SSGeneric_slowupdate()
{
	
}

function SSGeneric_fastupdate()
{
  SSGeneric_draw();
}