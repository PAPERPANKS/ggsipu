<!doctype html>

<html>
	<head>
		<title>notices</title>
	</head>
<style>
	#search_div{
		margin:auto;
		width:100%;
		float:right;
	}
	input[id=search_field] {
	padding: 8px 20px;
	float:right;
	color: #041e54;
	font-size: 18px;
    box-sizing: border-box;
    border: 3px solid #383838;
}

input[id=search_field]:focus {
    border: 3px solid #555;
}
</style>
<body>
<?php 	

	include_once ('header.php');
	include_once ('./style/credential.conf');
	
	$sql = 'SELECT * FROM notices_circulars ORDER BY uploading_date desc LIMIT 5';
	$retval = mysqli_query($conn, $sql);
	
?>
    	
    	<div class=table-box>
        
        <h2 id="heading1">NOTICES/CIRCULARS</h2>
	
		
		<div id="search_div">
			<input type="text" class="form-control" placeholder="Search..." id="search_field">		
		</div>
			
		<h3><small>*Click on the title to download the pdf</small></h3>	
		
	<table id="myTable">
    	
		<thead>
			<tr class="myHead">
				<th class="table-title">Title/Notices</th>
				<th class="dat">Uploading Date</th>
			</tr>
		</thead>
		
    	<tbody>
<?php        
        
	while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
	{
		$newDate = date("d-m-Y", strtotime($row['uploading_date']));
		
?>
<script>
// console.log($newDate);</script>
    	<tr>
        <td><a href="<?php print $row['links']; ?>"><?php print $row['title']; ?></a></td>         
        <td> <?php print $newDate; ?> </td>   
    	</tr>
<?php
	}       
?>

<?php	
	
	for($i=date('m');$i!=0;$i--)
	{
    		$dateObj   = DateTime::createFromFormat('!m', $i);
?>
        	
<?php
		$sql = "SELECT * FROM notices_circulars WHERE MONTH(uploading_date) = $i AND s_no < ( (SELECT MAX(s_no) FROM notices_circulars) - 5 ) AND YEAR(uploading_date) = ".date('Y')." ORDER BY DATE(uploading_date) desc" ;         
		$retval = mysqli_query($conn, $sql );
		$y=0;
		while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
		{
		$y=$y+1;
		if($y==1)
		{
?>
			<tr id="<?php print($dateObj->format('F').date('Y')) ?>"  class="item-collapse">
        	<td colspan="3"><?php print($dateObj->format('F')."     ".date('Y')); ?></td>
		</tr>

<?php
}
			$newDate = date("d-m-Y", strtotime($row['uploading_date']));
?>
			<tr class="<?php print($dateObj->format('F').date('Y')) ?>" style="display:none">  
	        	<td><a href="<?php print $row['links']; ?>"><?php print $row['title']; ?></a></td>         
	        	<td><?php print $newDate; ?></td>    
		    	</tr>

<?php
		}
?>

    
<?php
    
	}
    $year=date('Y');
    for($i=0;$i<2;$i++)
    {
        
        $year=$year-1;
?>
        <tr id="<?php print("year".$year) ?>"  class="year-collapse">
        <td  style="text-align:center" colspan="3"><?php print($year); ?></td>
        </tr>
<?php
        for($j=12;$j>0;$j--)
        {
            $dateObj   = DateTime::createFromFormat('!m', $j);
?>
            
<?php
            $sql = "SELECT * FROM notices_circulars WHERE MONTH(uploading_date) = $j AND YEAR(uploading_date) = ".$year." ORDER BY s_no desc" ;
            $retval = mysqli_query($conn, $sql );
    
?>
		
<?php
		$y=0;
            while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC))
            {
		$y=$y+1;
		if($y==1)
		{
?>
			<tr id="<?php print($dateObj->format('F').$year) ?>"  class="<?php print("year".$year) ?>" style="display:none">
        		<td class="item-collapse" colspan="3"><?php print($dateObj->format('F')."     ".$year); ?></td>
            		</tr>
		
<?php
		}
		
                
                $newDate = date("d-m-Y", strtotime($row['uploading_date']));
?>
                <tr class="<?php print($dateObj->format('F').$year) ?>" style="display:none">  
                <td><a href="<?php print $row['links']; ?>"><?php print $row['title']; ?></a></td>         
	        	<td><?php print $newDate; ?></td>    
		    	</tr>
<?php
		      }
?>

<?php
        }
    }
	
?>

    </tbody></table>
	</div>
	
<?php
    mysqli_close($conn);

	include_once ('footer1.php') ;	
?>

<script src='https://code.jquery.com/jquery-1.12.4.min.js'></script>
<script src="live_srch.js"></script>
</body>

</html>