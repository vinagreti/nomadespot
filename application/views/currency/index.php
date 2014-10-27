<h1 class="page-header">Taxas de câmbio</h1>

<p><strong>Total:</strong> <?=count($rates['rates'])?></p>

<div class="row">
	<div class="col-sm-4 col-xs-12">
		<?php
			$i = 0;
			foreach($rates['rates'] as $currency => $rate) {

				if($i == 28 || $i == 56 || $i == 84 || $i == 112 || $i == 140)
					echo '</div><div class="col-sm-4 col-xs-12">';

				echo '<p>' . $currency . ' -> ' . $rate . '</p>';

				$i++;
				
			}
		?>
	</div>
</div>