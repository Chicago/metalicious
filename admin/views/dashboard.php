
		<!-- Begin Dashboard for Administrators -->

		<div class="row-fluid">
			<div class="span12">
				<h1 class="page-title">Dashboard - Admin</h1>
			</div>
		</div>
	
		<div class="row-fluid">
		
			<div class="span6">

			<?php

				$testwidget = new WidgetBuilder;
				$testwidget->buildWidget();
			
			?>

			</div>

			<div class="span6">

			<?php

				$tablewidget = new ApprovalWidget;
				$tablewidget->widget_name = "Unapproved Variables";
				$tablewidget->widget_item_type = "variable";
				$tablewidget->buildWidget();
			
			?>

			</div>
		</div>
		<div class="row-fluid">

			<div class="span6">

			<?php

				$tablewidget = new ApprovalWidget;
				$tablewidget->widget_name = "Unapproved Tables";
				$tablewidget->widget_item_type = "table";
				$tablewidget->buildWidget();
			?>

			</div>

			<div class="span6">

			<?php

				$tablewidget = new ApprovalWidget;
				$tablewidget->widget_name = "Unapproved Tables";
				$tablewidget->widget_item_type = "database";
				$tablewidget->buildWidget();

			
			?>

			</div>

		</div>
		
	</div> <!-- /container -->

	<!-- end Administrators' dashboard -->

	<div class="container">

		<div class="row-fluid">
			<div class="span12">
				<h1 class="page-title">Dashboard - Content Managers</h1>
			</div>
		</div>

<?php

include 'admin/include/footer.php';

?>
