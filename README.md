# PetSave
@version 0.2ß
A prototype (work in progress) aimed at helping animal shelters find volunteers, donors and homes for rescued pets.


SUMMARY OF FILES
----------------

FILE NAME               DESCRIPTION

addconfirm.php          Displays confirmation message once new adopted animal is added to database
addrescue-cat.php       Displays the interface that allows the Admin to add into database a cat to be rescued
addrescue-dog.php       Displays the interface that allows the Admin to add into database a cat to be rescued
admin.php               Displays the general Administrator interface
adopt.php               Displays the form with the fields necessary to enter into database a new rescue animal
adoptionlist.php        Displays the list of animals up for adoption
catpcha.php             This script contains Captcha functionality to prevent mass/spam posts. It needs a registered domain in order to be implemented.
changepassword.php      Contains the form used to allow Admin to change his/her password
confirmation.php        This page displays the confirmation
connect.php             This script contains the database connection instructions (to be used as an include file in the next version of the prototype)
contact.php             This page contains the form required for comments left to the Admin
creditcard.php          This page contains the form required for credit card donations
donate.php              This page contains general information on donations
editrescue.php          This page allows the Admin to make changes to a rescued animal's profile
footer.php              Contains the basic html code to appear at the bottom of the pages (common import)
index.php               Intro page
insert.php              Basic script for photo insertion (to be fully implemented in the next version)
login.php               Form for Admin log in
logoff.php              Page that confirms Admin has logged off
menubar.php             Insert file with the basic menu bar for page navigation
passwordhash.php        Test algorithm that 
setup.php               Script that creates the tables used (this is only run once for testing purposes, to be disused in the final version)
submit-comment.php      Page that confirms comment submitted to Admin
uninstall.php           Script that drops the tables in use (only for test purposes)
viewadoptions.php       Page that shows the animals that are up for adoption
viewcomments.php        Page that allows Admin to see comments posted
viewdonations.php       Page that allows the Admin to see the donations sent
viewrescues.php         Page that allows the Admin to see the animals that have been adopted

WHAT'S NEXT
-----------

These are the improvements to be put in place next:
- A front-end layer that would result in proper visualization of table contents (rescued animals, adopted animals, donations, comments).
- A back-end interface with payment systems (using Payum) which would also make PayPal donations possible.
- Finish implementing the Photo insertion/display capabilities.
- A further refining of the algorithm that evaluates regular expressions to make sure the expiry date of the credit card is in the correct format.
