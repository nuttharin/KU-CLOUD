
class WidgetObject
{
  constructor()
  { 
  }

  // Garph
  WidgetGraphObject(id, canvasTag, chartData, chartOption, type)
  {
    this.id = id;
    this.canvasTag = canvasTag;
    this.chartData = chartData;
    this.chartOption = chartOption;
    this.type = type;
  }

  // Text
  MapWidgetObject(id, mapTag, type)
  {
    this.id = id;
    this.mapTag = mapTag;
    this.type = type;
  }

  // Text
  HeadFontObject(id, spanTag, type)
  {
    this.id = id;
    this.spanTag = spanTag;
    this.type = type;
  }

  // Table
  WidgetTableObject(id, tableTag, type)
  {
    this.id = id;
    this.tableTag = tableTag;
    this.type = type;
  }

  // Image
  WidgetImageObject(id, divImgTag, type)
  {
    this.id = id;
    this.divImgTag = divImgTag;
    this.type = type;
  }

  // Shape
  WidgetShapeObject(id, divTag, type)
  {
    this.id = id;
    this.divTag = divTag;
    this.type = type;
  }
}