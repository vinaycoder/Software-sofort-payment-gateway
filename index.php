    <form id="sofort_payment" method="post" action="htttp://localhost/sofort/sofort/examples/example.sofortueberweisung.php">
       <input type="hidden" name="sofort_trans"  id="sofort_trans" />
		
			<input type="hidden" name="amount" value="100<?php //if(!empty($total)){ echo array_sum($total);  }?>" />   

          <input type="submit" value="submit">
    </form>
