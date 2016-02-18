<h4 class="add_user_head">List/Remove Gift Cards</h4>


<?php 
$bg='#d7c47d';

if(isset($_POST['remove']))
{
 foreach($_POST['remove'] as $key=> $value)
 {
  $q="UPDATE card_image SET flag_m=0  WHERE card_img_id=$key ";
  $r=mysqli_query($dbc, $q);
 }
}
if(isset($_POST['list']))
{
 foreach($_POST['list'] as $key=> $value)
 {
  $q="UPDATE card_image SET flag_m=1  WHERE card_img_id=$key ";
  $r=mysqli_query($dbc, $q);
 }
}

$display = 3;

 
if (isset($_GET['np'])) 
    $num_pages = $_GET['np'];
 else {
 $q="SELECT COUNT(*) FROM card_image WHERE flag_a=1";
 
$result = mysqli_query ($dbc, $q);
$row = mysqli_fetch_array ($result, MYSQLI_NUM);
$num_records = $row[0];


    if ($num_records > $display) 
        $num_pages = ceil ($num_records/$display);
    else 
        $num_pages = 1;    
    
} // End of np IF.

// Default Column Links
$link1 = "index.php?pagelet=list_card&#38;sort=ca";
$link2 = "index.php?pagelet=list_card&#38;sort=fma";

if (isset($_GET['sort']))  {

    switch ($_GET['sort'])  {
       case 'ca';
            $order_by = 'category ASC';
            $link1 ="index.php?pagelet=list_card&#38;sort=cd";
            $label = "Card Category - Ascending";
            break;
        case 'cd';
            $order_by = 'category DESC';
            $link1 ="index.php?pagelet=list_card&#38;sort=ca";
            $label = "Card Category - Descending";
            break;
        case 'fma';
            $order_by = 'flag_m ASC';
            $link2 ="index.php?pagelet=list_card&#38;sort=fmd";
            $label = "Listed - Descending";
            break;
        case 'fmd';
            $order_by = 'flag_m DESC';
            $label = "Listed - Ascending";
            $link2 ="index.php?pagelet=list_card&#38;sort=fma";
            break;
       
        default;
            $order_by = 'category ASC';
            $label = "Card category - Ascending";
            break;
    }

    
    $sort = $_GET['sort'];

} else {  // use default sorting order
    $order_by = 'category ASC';
    $sort = 'ca';
    $label = "Card Category - Ascending";
}

// Determine where in the database to start returning results.
if (isset($_GET['s'])) 
    $start = $_GET['s'];
 else 
    $start = 0;

 
 $q= "SELECT cardname, card_img_id, flag_m, category FROM card_image AS i, card_category AS c WHERE i.category_id=c.category_id AND flag_a=1 ORDER BY $order_by LIMIT $start, $display";
 $r=mysqli_query($dbc, $q);
 if($r)
 {
	if(mysqli_num_rows($r) >0)
	{
	echo '<div class="bainfo addform"> sorted by: ' . $label . '</div>';
    echo '<div class="addform">Click on Card Category and Listed column headings to sort.</div>';
	
	 echo '<table class="lr">';
	 echo '<tr style="background:'.$bg.'"><th>Card Image</th><th>CardName</th>';
	 echo '<th><a href="' . $link1 . '"> Card Category </a></th>';
	 echo '<th><a href="' . $link2 . '"> Status</a></th><th>Edit</th></tr>';
     while($row=mysqli_fetch_array($r, MYSQLI_ASSOC))
	 {	 
	 $bg = ($bg=='#d7c490'?'#cac490':'#d7c490');
	 
	 echo '<tr style="background:'.$bg.'">';
	 echo '<td style="text-align:left;margin-right:0px;">';
	 echo '<img alt="'.$row['category'].' card" src="includes/find_cards_image.inc.php?id='.$row['card_img_id'].'" width="167" height="100"/></td>';
	 echo '<td>'.$row['cardname'].'</td>';
	 echo '<td>'.$row['category'].'</td>';		 
	 echo '<td style="width:90px;">';
	 if($row['flag_m']==1)
	 {
	  echo 'Active';
	  echo '<td><form method="post" action="index.php?pagelet=list_card&#38;sort='.$sort.'&#38;s=' . $start . '&#38;np=' . $num_pages .'">';
	  echo '<input type="submit" value="Inctivate" name="remove['.$row['card_img_id'].']" class="bton"/></form></td>';
	 }
	 else
	 {
	  echo 'Inactive';
      echo '<td><form method="post" action="index.php?pagelet=list_card&#38;sort='.$sort.'&#38;s=' . $start . '&#38;np=' . $num_pages .'">';
	  echo '<input type="submit" value="Activate" name="list['.$row['card_img_id'].']" class="bton"/></form></td>';
     }		
	 echo '</tr>';
	 
	 }//End of while
	 
	  $bg='#d7c47d';
	 echo '<tr style="background:'.$bg.'"><td colspan="5" style="padding:2px 20px;text-align:right;">';
	 
	 if ($num_pages > 1) 
{
    $current_page = ($start/$display) + 1;
 
    if ($current_page != 1) 
        echo '<a class="black" href="index.php?pagelet=list_card&#38;sort='.$sort.'&#38;s=' . ($start - $display) . '&#38;np=' . $num_pages . '">Previous</a> ';
   
    for ($i = 1; $i <= $num_pages; $i++) {
        if ($i != $current_page) {
            echo '<a class="black" href="index.php?pagelet=list_card&#38;sort='.$sort.'&#38;s=' . (($display * ($i - 1))) . '&#38;np=' . $num_pages . '">' . $i . '</a> ';
        } else {
            echo $i . ' ';
        }
    }
   
    if ($current_page != $num_pages)
        echo '<a class="black" href="index.php?pagelet=list_card&#38;sort='.$sort.'&#38;s=' . ($start + $display) . '&#38;np=' . $num_pages . '">Next</a>';
    
} // End of links section.
	 
	 echo '</table>';
	}
	
 }
 else
  echo 'System Error! Gift Cards could not be listed. We apologize for any inconvenience.';
  
  

?>