
class WidgetObject
{
  constructor()
  { 
  }

  LineGraphObject(id, canvasTag, chartData, type)
  {
    this.id = id;
    this.canvasTag = canvasTag;
    this.chartData = chartData;
    this.type = type;
  }

  HeadFontObject(id, spanTag, type)
  {
    this.id = id;
    this.spanTag = spanTag;
    this.type = type;
  }
}