<?php

class Club
{
	//Private Data
	private $HostName;
	private $UserID;
	private $Password;
	private $DBName;
	private $Con;
	
//--------------------------------------------------------
//--------------------------------------------------------

//Pubic Methods----------------------

	
//Constructor

public function __construct($host=NULL, $uid=NULL, $pw=NULL, $db=NULL)
{
	//echo("The class constructor is being called... <br />");
	$this->HostName = $host;
	$this->UserID   = $uid;
	$this->Password = $pw;
	$this->DBName   = $db;   // Connect to Database
	$this->Con = mysqli_connect($host, $uid, $pw, $db);
	
	if (mysqli_connect_errno($this->Con))
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	
}
	
//Destructor---------------------------------
public function __destruct()
{
	echo("The class destructor is being called... <br />");
	// Close connection
	mysqli_close($this->Con);
	
}
//----------------------------------------------
public function DisplayMembers()
{
	echo("<table border ='3' align='center'>");
	echo("<thead>");
	echo("<tr>");
	echo("<th colspan='4'    bgcolor='#3BA3D0'>");
	echo("Informatics Club Membership");
	echo("</th>");
	echo("</tr>");
	echo("<tr>");
	echo("<th bgcolor='#3BA3D0'>");
	echo("Name");
	echo("</th>");
	echo("<th    bgcolor='#3BA3D0'>");
	echo("Email");
	echo("</th>");
	echo("<th    bgcolor='#3BA3D0'>");
	echo("Gender");
	echo("</th>");
	echo("<th bgcolor='#3BA3D0' width='200px'>");
	echo("Interests");
	echo("</th>");
	echo("</tr>");
	echo("</thead>");
	echo("<!--The table Body -->");
	echo("<tbody>");
	
	$Membership = $this->Get_Members_From_DB();
	
	for($i=0; $i < sizeof($Membership); $i++)
	{
		echo("<tr>");
		echo("<td>" . $Membership[$i]['FirstName'] . ", " .    $Membership[$i]['LastName'] ."</td>");
		echo("<td>" . $Membership[$i]['Email'] . "</td>");
		echo("<td>" . $Membership[$i]['Gender'] . "</td>");
		
		$Interests = $this->Get_Members_Interestes_From_DB($Membership[$i]['Email']);
		echo("<td><ul>");
		for($j =0; $j < sizeof($Interests); $j++)
			echo("<li>" . $Interests[$j]['InterestDescription'] . "</li>");
		
		echo("</ul></td>");
		echo("</tr>");
	}
	echo("</body>");
	echo("</table>");
}
//--------------------------------------------
public function DisplayHome()
{
echo("<h1>Informatics</h1>
<h2>Club</h2>
<h1>Home</h1>
<h2>Tab</h2>");
}
//----------------------------------------------
function DisplayAbout()
{
			echo(
				
				"<h2 align='left';>About the Informatics Club</h2>
				<div id='insidecontent'>
					<p>The informatics club is a student organization.</p>
					
					<p>The main goal of the student club is to bring together current students to involve in activities that benefit the greater community. This includes mentoring peers, networking, hosting invited talks, taking part in programming competitions, hosting community events, and others.</p>
					
					<img class='right' src='https://ready.iusb.edu/Resources/iusb2.jpg'>
					
				<h3><strong>Our Events and Activites Inlcude:</strong></h3>
					<ol>
					<li>Pizza Parties</li>
					<li>Casino Night</li>
					<li>Trivia Night</li>
					<li>Game Night</li>
					<li>Programming Competition</li>
					</ol>
					
					<h3><strong>Club Officers:</strong></h3>
					
					<p>Information about office held:</p>
					<ul>
						<li>Dr. Hossein Hakimzadeh, Director, hhakimza @ iusb.edu </li>
						<li>Scott Wickline, Student, sewickli@iu.edu</li>
						<li>John Doe, Event Organzier, Jdoe@iu.edu</li>
					</ul>
					</div>
					<br><br>
			
					
		<div id='reverse'>
			
		<h1>Questions and Comments:</h1>
		
			<p>Questions about the club system may be directed to:<br>
			Dr. Hossein Hakimzadeh, Department of Computer and Information Sciences Indiana University South Bend hhakimza@iusb.edu</p>
		
	 </div>");
	
}
//------------------------------------------------
function DisplayRegistrationForm()
{
	
	echo("<form method='POST' >");
	echo("<div id='RegistrationForm'");
	echo("style='background-color:#FFFF00; ");
	echo("                           border:2px solid black; ");
	echo("                            border-radi us: 10px;");
	echo("height:500px; ");
	echo("width:100%; ");
	echo("float:left;'> ");
	echo("<h1 align='center'>Become a Club Member</h1> ");
	echo("<table style= 'margin:1cm;'> ");
	echo("<tr> ");
	echo("<td> <label> Your Email: </label> </td> ");
	echo("<td> <input type='text' name='email' size='20' > (must be unique)</td> ");
	echo("</tr>");
	echo("<tr> ");
	echo("<td> <label> First Name </label></td> ");
	echo("<td> <input type='text' name='fname' size='20' ></td> ");
	echo("</tr> ");
	echo("<tr> ");
	echo("<td> <label> Last Name </label></td> ");
	echo("<td> <input type='text' name='lname' size='20' ></td> ");
	echo("</tr>");
	echo("<tr> ");
	echo("<td> Gender:</td> ");
	echo("<td>    ");
	echo("<input type='radio' name='sex' value='Male'>Male<br> ");
	echo("<input type='radio' name='sex' value='Female'>Female ");
	echo("</td> ");
	echo("</tr>");
	echo("<tr> ");
	echo("<td> Interested in:</td> ");
	echo("<td>    ");
	echo("<fieldset> ");
	echo("<legend><b> Check all that apply: </b></legend>    ");
	
	$MemberInterests = $this->Get_Interests_Types_From_DB();
	
	for ($i=0; $i< sizeof($MemberInterests); $i++)
	{
		$ID = $MemberInterests[$i]['InterestID'];
		$Description = $MemberInterests[$i]['InterestDescription'];
		echo("<input type='checkbox' name='interests[]'value='$ID'>$Description<br> ");
	}
	echo("</fieldset> ");
	echo("</td> ");
	echo("</tr>");
	echo("</table> ");
	echo("<input type='submit' value='Sign Up'>");
	echo("</div> ");
	echo("</form> ");
	
			if((!empty($_POST["fname"])) || (!empty($_POST["lname"])) || (!empty($_POST["email"])) || (!empty($_POST["sex"])))
			{
		
			$this->ProcessRegistrationForm();
	
			}
	

		
	
}



//------------------------------------------------
function ProcessRegistrationForm()
{
if( !isset($_POST) )
{
	echo("Form was not completed");
}
	else
	{
		// The post method is used 
		echo("<h3> Thank your for registering</h3>");
		$email = $_POST['email'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$sex   = $_POST['sex'];
		
		// write to database
		$sql = "INSERT INTO member(
							`Email`, 
							`FirstName`, 
							`LastName`, 
							`Gender`, 
							`MemberSince`) 
						VALUES(
						'$email', 
						'$fname', 
						'$lname', 
						'$sex', 
						date('Y-m-d')); ";
		
		echo ($sql . "<br />");
		
		$status = mysqli_query($this->Con,$sql);
		
		if ($status == true) 
		{
			echo "Successful Registration <br />";
			
			// Write the interests:
			for($i =0; $i < sizeof($_POST['interests']); $i++)
			{
				$interest = $_POST['interests'][$i];
				
				$sql = "INSERT INTO member_interests
												(`Email`, `InterestID`) 
							        VALUES
							   					('$email', $interest);";
				echo ($sql . "<br/>");
				
				$result = mysqli_query($this->Con, $sql);
			}
		}
		else    
		{
			echo "Error in Registration: " . mysqli_error($this->Con) ."    <br/>";
		}
	}
	
}
//-------------------------------------------------
//-------------------------------------------------
//Private Methods
//-------------------------------------------------

private function Get_Members_From_DB()
{
	$sql =  "SELECT 
				member.Email,
				member.FirstName,
				member.LastName,
				member.Gender,
				member.MemberSince
		
				FROM
					member";
	
	$result = mysqli_query($this->Con, $sql);

	$arrayResult = array();
	
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
	{
		$arrayResult[] = $row;
		//print_r($row);
		//echo "<br />";
	}
	return($arrayResult);
	
}
//-------------------------------------------------
private function Get_Members_Interestes_From_DB($MemberEmail)
{
	$sql = "SELECT interest_type.InterestDescription
	FROM
			member, 
			member_interests, 
			interest_type
	WHERE
			member.Email = '$MemberEmail'
	AND
			member.Email = member_interests.Email
	AND
			member_interests.InterestID = interest_type.InterestID";

	$result = mysqli_query($this->Con,$sql);
	$arrayResult = array();
	while($row = mysqli_fetch_array($result))
	{
		$arrayResult[] = $row;
		//print_r($row);
		//echo "<br />";
	}
	return($arrayResult);
	
}
//--------------------------------------------------
private function Get_Interests_Types_From_DB()
{

	$sql = "SELECT 
			InterestID,
			InterestDescription
	FROM
			interest_type";
	
	$result = mysqli_query($this->Con, $sql);
	
	$arrayResult = array();
	
	while($row = mysqli_fetch_array($result))
	{
		$arrayResult[] = $row;
		//echo $row['InterestID'] . " " . $row['InterestDescription'];
		//echo "<br />";
	}
	return($arrayResult);
	
	
}
//----------------------------------------------------

}
?>
	
	