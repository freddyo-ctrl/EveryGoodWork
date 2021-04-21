<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include("dbconn.inc.php"); // database connection

// make database connection
$conn = dbConnect();



function getAllEvents($month, $year){

global $conn;
    // ex. May 2021 events ==> eventDate >= 5/1/2021 and eventDate <=5/31/2021



    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

    $lowerBound = "$year-$month-01"; // "2021-05-01"
    $numberDays = date('t',$firstDayOfMonth);
    $upperBound = "$year-$month-$numberDays";
    $sql = "SELECT EventID, Name, Description,EventDate,StartTime,EndTime,VolunteersNeeded from events where EventDate >='$lowerBound' and EventDate <='$upperBound'";

    //create a prepared statement
    $stmt = $conn->stmt_init();

    if ($stmt->prepare($sql)){

                     $stmt->execute();

                     $stmt->bind_result($EventID, $Name, $Description,$EventDate,$StartTime,$EndTime,$VolunteersNeeded );

                     $dataArr = []; // establish a new array to store the event data



                     while($stmt->fetch()){

                       // break the $EventDate to get the day part so we can use it as the array key

                           // assuming the date is in this format: 2021-05-03

                         $day = intval(substr($EventDate, -2));

                       // see if this day has been added to the dataArr already

                        if (array_key_exists($day, $dataArr)) {

                            // if yes, add the current event to this day's array

                            // find the number of events on this day already.  Use that as the index number (since the first event has a key of zero)

                            $n = count($dataArr[$day]);

                        } else {

                           // establish a new array for the day
                            $dataArr[$day] = []; // make $dataArr[$day] an array to store multiple events on that day

                           // set the index number as 0 (the first item)
                            $n = 0;

                         }
                        $dataArr[$day][$n] = [];

                        $dataArr[$day][$n]['EventID'] = $EventID;

                        $dataArr[$day][$n]['Name'] = $Name;

                        $dataArr[$day][$n]['Description'] = $Description;

                        $dataArr[$day][$n]['EventDate'] = $EventDate;

                        $dataArr[$day][$n]['StartTime'] = $StartTime;

                        $dataArr[$day][$n]['EndTime'] = $EndTime;

                        $dataArr[$day][$n]['VolunteersNeeded'] = $VolunteersNeeded;


                     }



                     $stmt->close();

      }



      $conn->close();



      return $dataArr;

}


function build_calendar($month,$year) {

    // validate that the month and year numbers are within valid ranges (you can see below how the year range is set up.  Modify it as you see fit.)
    $currentYear = date('Y');
    if (is_int($month) && $month>=1 && $month <=12 && is_int($year) && $year <= ($currentYear + 10) && $year>=($currentYear-10) ) {

        $eventArr = getAllEvents($month, $year);
        // $eventArr[1]:
        //     $eventArr[1][0]['eventID']= 234;
        //     $eventArr[1][0]['name']= 'fundraising party';
        //     $eventArr[1][0]['description']= '....';
        //     $eventArr[1][1]['eventID']= 235;
        //     $eventArr[1][1]['name']= 'fundraising party 2';
        //     $eventArr[1][1]['name']= '...';

        // $eventArr[7] = ...;

        // Create array containing abbreviations of days of week.
        $daysOfWeek = array('S','M','T','W','T','F','S');

        // What is the first day of the month in question?
        $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

        // How many days does this month contain?
        $numberDays = date('t',$firstDayOfMonth);

        // Retrieve some information about the first day of the
        // month in question.
        $dateComponents = getdate($firstDayOfMonth);

        // What is the name of the month in question?
        $monthName = $dateComponents['month'];

        // What is the index value (0-6) of the first day of the
        // month in question.
        $dayOfWeek = $dateComponents['wday'];

        // Create the table tag opener and day headers

        $calendar = "<table class='calendar'>";
        $calendar .= "<caption>$monthName $year</caption>";
        $calendar .= "<tr>";

        // Create the calendar headers

        foreach($daysOfWeek as $day) {
             $calendar .= "<th class='header'>$day</th>";
        }

        // Create the rest of the calendar

        // Initiate the day counter, starting with the 1st.

        $currentDay = 1;

        $calendar .= "</tr><tr>";

        // The variable $dayOfWeek is used to
        // ensure that the calendar
        // display consists of exactly 7 columns.

        if ($dayOfWeek > 0) {
             $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
        }

        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

        while ($currentDay <= $numberDays) {

             // Seventh column (Saturday) reached. Start a new row.

             if ($dayOfWeek == 7) {

                  $dayOfWeek = 0;
                  $calendar .= "</tr><tr>";

             }

             $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);

             $date = "$year-$month-$currentDayRel";

             if(array_key_exists($currentDay,$eventArr))     {
                 $eventListArr = $eventArr[$currentDay]; // $eventArr[$currentDay] is an array
                 $eventList = "<ul>";
                  foreach ($eventListArr as $e){
                     $eventList .="
                        <li id='{$e['EventID']}'>
                    <div id='detail-234'>
                        <h3>{$e['Name']}</h3>
                        Time: {$e['StartTime']} - {$e['EndTime']}<br>
                        {$e['Description']}<br>
                        <a href='registration.php?eventID={$e['EventID']}'>volunteer registration</a>
                    </div>
                </li>";

                  }
                 $eventList .= "</ul>";
             } else {
                 $eventList = "";
             }




             $calendar .= "
             <td class='day' rel='$date'>
                <span>$currentDay</span><br>
                $eventList

             </td>";

             // Increment counters

             $currentDay++;
             $dayOfWeek++;

        }

        // Complete the row of the last week in month, if necessary

        if ($dayOfWeek != 7) {

             $remainingDays = 7 - $dayOfWeek;
             $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";

        }

        $calendar .= "</tr>";

        $calendar .= "</table>";
    } else {
        // either month or year number is invalid
        $calendar = "Oops! The system cannot generate the calendar with the informaiton provided. Please .... ";
    }
    return $calendar;

}

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Calander</title>
	<meta charset="utf-8">
    <style>
        table, td, th {
          border:1px solid #aaa;
        }

table {
  height: 1000px;
width:1000px;
}

td{
  height:250px;
  width:250px;
}

li{
  list-style-type:none;
}


    </style>
</head>
<body>
	<!-- Display event calendar -->
	<div id="calendar_div">
		<?php
            echo build_calendar(4,2021); ?>
	</div>
</body>
</html>
