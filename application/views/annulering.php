<?php 


if (isset($status) && $status) {
	?>
	<h1>Annulering succesvol </h1>
	<p>U zult een bevestiging in u mail ontvangen</p>
	<?php
} else {
	?>
	<h1>Er is iets niet goed gegaan</h1>
	<?php 
	if(isset($message) && strlen($message)) {
		switch ($message) {
		    case 'less.then.hour':
		        ?> <p>U kunt niet annuleren later dan een uur van te voren</p> <?php
		        break;
		    case 'person.dont.exists':
		        ?> <p>Deze persoon is al afgemeld</p> <?php
		        break;
		    default:
     		   ?> <p>Neem contact op met <a href="mailto:beach@clubhuisvollido.nl">beach@clubhuisvollido.nl</a></p> <?php
		}
	}
}
?>

<h4><a href="https://beach.clubhuisvollido.nl/">Ga naar de website</a></h4>