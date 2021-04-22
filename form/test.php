<?php
if (isset($_POST['test'])) {
echo($_POST['test']);
}
echo("k00");
?>					<form>
                    <button class="w3-button w3-teal" type="submit" value='2'
                    formAction='./dashboard.php?content=test' name='test'>View</button>
					</form>
                    <button class="w3-button w3-teal" type="submit" value='5' onClick="console.log('test')">View</button>
    
                    <button class="w3-button w3-teal" type="submit" value='
                    9' onClick=showFormUsers(this.value)>View</button>
                    
                    <button class="w3-button w3-teal" type="submit" value='
                   1'
                     onClick=showFormUsers(this.value)>View</button>
