<!DOCTYPE php>
<html>
<head>
  <meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8"/>
 <link rel="stylesheet" href="style.css" type="text/css">
</head>
  <body>
  <?php
ini_set('memory_limit', '1024M');
echo "Results are:";

$zip = zip_open("ftp://ftp.fec.gov/FEC/2016/pas216.zip");

while ($zip_entry = zip_read($zip))
{
  echo "<p>";
  if (zip_entry_open($zip, $zip_entry))
  {
    $contents = zip_entry_read($zip_entry);
    echo "\n\n";
    # object table row separator


    $data = explode("\n", $contents);
    $delimiter = '|';
    #print_r($data);
      echo "<br><br>\n\n";

      foreach ($data as $field_00)
      {
        $row_data_candi = 0;
        foreach ($data as $field_01)
        {
          $row_data_01 = rsort(explode("|", $field_01));
          $row_data_00 = explode("|", $field_00);

          if ($row_data_00[16] = -$row_data_01[16])
          {
            $candi_is = $row_data_01[16];
            $row_data_candi++;
          }
        }
      }

      print "Candidate ID: . . .  . . . . . : ".$candi_is."<br>\n";
      print "Candidate frequency: . . : ".$row_data_candi."<br>\n";


echo "\n\n";

      $listings = array(
                    array('Candidate' => 15),
                    array('Candidate' => 10),
                    array('Candidate' => 11)
                  );

      foreach($listings as $listing)
      {
          $flattenedListings[] = $listing['Candidate'];
      }

      $widths = range(0, 100, 10);
      $bins = array();
      $isLast = count($widths);
      foreach($widths as $key => $value)
      {
          if($key < $isLast - 1)
          {
              $bins[] = array('min' => $value, 'max' => $widths[$key+1]);
          }
      }

      $histogram = array();
      foreach($bins as $bin)
      {
        $histogram[$bin['min']."-".$bin['max']] = array_filter($flattenedListings, function($element) use ($bin) {

        if( ($element > $bin['min']) && ($element <= $bin['max']) )
        {
          return true;
        }
        return false;
       });
      }

      foreach($histogram as $key => $val)
      {
        $flotHistogram[$key] = (is_array($val)) ? ( (count($val)) ? count($val) : 0 ) : 0;
        print "Candidate Hist: . . . . . . .: ".$flotHistogram[$key]."<br>\n";
      }

      zip_entry_close($zip_entry);
      }
    echo "</p>";
  }
zip_close($zip);

?>

  </body>
</html>
