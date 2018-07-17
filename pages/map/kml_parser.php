<?php/* * KML generator * Author: Amr Osama Saad * Description: takes in array of google map points(lat,long) and its description or body text and generates a KML file to download or view * 				as text * Date:29/09/09 1:12AM *//*sample KML from google documentation:  <?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2">  <Document>    <Placemark>      <name>Entity references example</name>      <description>	        &lt;h1&gt;Entity references are hard to type!&lt;/h1&gt;	        &lt;p&gt;&lt;font color="green"&gt;Text is           &lt;i&gt;more readable&lt;/i&gt;           and &lt;b&gt;easier to write&lt;/b&gt;           when you can avoid using entity references.&lt;/font&gt;&lt;/p&gt;      </description>      <Point>        <coordinates>102.594411,14.998518</coordinates>      </Point>    </Placemark>  </Document></kml>  */function generatekml($input,$file=true,$filename="mykml.kml"){$output="<?xml version=\"1.0\" encoding=\"UTF-8\"?><kml xmlns=\"http://www.opengis.net/kml/2.2\">  <Document>";foreach($input as $point){$name=$point['name'];$description=htmlentities($point['desc']);$coordinates=$point['coordinates'];$output.="<Placemark>      <name>$name</name>      <description>$description</description>	  <Point>        	  	<coordinates>$coordinates</coordinates>      </Point>    </Placemark>";}$output.="</Document></kml>";if($file){    header("Content-type: octet/stream");    header("Content-disposition: attachment; filename=".$filename.";");   // header("Content-lenght: ".filesize("files/".$file));    print $output;    exit;}else print $output;}/*generatekml(array(array('name'=>'sample point 1','desc'=>'this is <h3>HTML</h3> text','coordinates'=>'102.594411,14.998518'),array('name'=>'sample point 2','desc'=>'this is another <h3>HTML</h3> text','coordinates'=>'101.594411,14.998518')),true,"test.kml");*/