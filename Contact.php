<?php
include 'inc/functions.php';
htmlHead("Get In Touch With Me!!");
?>

<?php
    // Make variable output.
$output = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    // Capture form data
    $gender = htmlspecialchars($_POST['gender']);
    $firstName = htmlspecialchars($_POST['first-name']);
    $lastName = htmlspecialchars($_POST['last-name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    //Checks if last name is input
    if($lastName == "")
    {
        $output = "you need to submit your lastname";
    }
}
else
{
    echo "No data submitted";
}
?>
        <div class="Container">
            <div class="Contact">
                <h1>Contact</h1>
            </div>
            <div class="Bottom-part">
                <form action="Contact.php" method="POST">
                <label>Gender</label>
                <select name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <label>First name</label>
                <input name="first-name" type="text" required>
                <label>Last name</label>
                <input name="last-name" type="text" required>
                <label>Email</label>
                <input name="email" type="email">
                <div class="form-group">
                <label for="message">Messages</label>
                <textarea id="message" name="message"></textarea>
                </div>
                <input type="submit" value="Submit">
                <div></div>
                <input type="submit" value="Reset">
                </form>
            </div>
        </div>
        <div id="Container">
            <div class="Bottom-part">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    if($output != "")
                    {
                        echo $output;
                    }
                    else
                    {
                    // Display the submitted information
                    echo "<script>console.log('Gender: " . $gender . "' );</script>";
                    echo "<script>console.log('First Name: " . $firstName . "' );</script>";
                    echo "<script>console.log('Last Name: " . $lastName . "' );</script>";
                    echo "<script>console.log('Email: " . $email . "' );</script>";
                    echo "<script>console.log('Message: " . $message . "' );</script>";


                    echo "<p>Thank you $firstName $lastName for contacting radiogaga</p>";
                    }
                }
                else
                {
                    echo "<p>Anwsers will be put here</p>";
                }
                ?>
            </div>
        </div>
    </body>
</html>

<?php
    htmlFooter();
?>