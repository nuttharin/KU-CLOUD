
class WidgetObject
{
  constructor()
  { 
  }

  LineGraphObject(id, canvasTag, chartData, chartOption, type)
  {
    this.id = id;
    this.canvasTag = canvasTag;
    this.chartData = chartData;
    this.chartOption = chartOption;
    this.type = type;
  }

  HeadFontObject(id, spanTag, type)
  {
    this.id = id;
    this.spanTag = spanTag;
    this.type = type;
  }
}