<?php
/**
 * City Data Dictionary - Widget Factory
 * 
 * @package WidgetFactory
 */

/* The 'include' statements below do not point to the correct path. Including the correct path will create a "cannot redeclare class" error. Right now, it will generate a "Failed opening" warning.
*/

include_once dirname(__FILE__) . '/../../classes/database.php';
include_once dirname(__FILE__) . '/../../classes/table.php';
include_once dirname(__FILE__) . '/../../classes/variable.php';

/*********************************
 * Base class for admin widgets. 
 *
 * Creates a flexible widget. Variable $widget_content is a catch-all.
 *
 *********************************/
class WidgetBuilder {

	var $widget_name; //widget name
	var $widget_icon_type; //which icon to use
	var $widget_content;


	/**
	 * Widget empty constructor.
	 *
	 * @returns WidgetBuilder empty widget object.
	 */
	public function __construct() {
		$this->widget_name = "";
		$this->widget_icon_type = "";
		$this->widget_content = "";
	}

	/**
	 * Builds the widget.
	 *
	 * Creates the html widget.
	 */
	public function buildWidget() {
		?>
<div class="widget">
	<div class="widget-header">
		<i class="<?php echo($this->widget_icon_type)?>"></i>
		<h3><?php echo($this->widget_name)?></h3>
	</div>
	<div class="widget-content">
		<?php
		echo($this->widget_content);
		?>
	</div>	
</div>	
		<?php
	}
}

/*********************************
 * Class for widgets that have tables of items to be approved for publishing. 
 *
 * Variable $widget_item_type must be declared.
 *********************************/

class ApprovalWidget extends WidgetBuilder {

	var $widget_item_type; //which item type to display

	/**
	 * Widget empty constructor.
	 *
	 * @returns ApprovalWidget empty widget object.
	 */
	public function __construct() {

	}

	/**
	 * Builds the widget.
	 *
	 * Creates a table of content needing to be approved.
	 */
	public function buildWidget() {
		?>
<div class="widget">
	<div class="widget-header">
		<i class="<?php echo($this->widget_icon_type)?>"></i>
		<h3><?php echo($this->widget_item_type)?></h3>
	</div>
	<div class="widget-content">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<td>Name</td>
					<td>Content Author</td>
					<td>Date Created</td>
					<td></td>
				</tr>
			</thead>
			
			<tbody>

		<?php

			if ($this->widget_item_type == "database") {
				
				$orphan_revisions = Database::get_orphan_revisions();

    			while ($orphan_revision = mysqli_fetch_assoc($orphan_revisions)) {
    	?>
				<tr>
					<td>
						<a href="<?php echo $orphan_revision['Database_Revision_ID']; ?>"><?php echo $orphan_revision['Database_Name']; ?></a>
					</td>
					<td>
						<?php echo $orphan_revision['Creator']; ?>
					</td>
					<td>
						<?php echo $orphan_revision['Last_Updated']; ?>
					</td>
					<td class="action-td">
						<a href="javascript:;" class="btn btn-small btn-warning">
							<i class="icon-ok"></i>								
						</a>					
						<a href="javascript:;" class="btn btn-small">
							<i class="icon-remove"></i>						
						</a>
					</td>
				</tr>

    	<?php
    			}

    		} elseif ($this->widget_item_type == "table") {

				$orphan_revisions = Table::get_orphan_revisions();

    			while ($orphan_revision = mysqli_fetch_assoc($orphan_revisions)) {
    	?>
				<tr>
					<td>
						<a href="<?php echo $orphan_revision['Table_Revision_ID']; ?>"><?php echo $orphan_revision['Table_Name']; ?></a>
					</td>
					<td>
						<?php echo $orphan_revision['Creator']; ?>
					</td>
					<td>
						<?php echo $orphan_revision['Date_Created']; ?>
					</td>
					<td class="action-td">
						<a href="javascript:;" class="btn btn-small btn-warning">
							<i class="icon-ok"></i>								
						</a>					
						<a href="javascript:;" class="btn btn-small">
							<i class="icon-remove"></i>						
						</a>
					</td>
				</tr>

    	<?php
    			}

    		} elseif ($this->widget_item_type == "variable") {
				$orphan_revisions = Variable::get_orphan_revisions();

    			while ($orphan_revision = mysqli_fetch_assoc($orphan_revisions)) {

    	?>

				<tr>
					<td>
						<a href="<?php echo $orphan_revision['Variable_Revision_ID']; ?>"><?php echo $orphan_revision['Variable_Name']; ?></a>
					</td>
					<td>
						<?php echo $orphan_revision['Creator']; ?>
					</td>
					<td>
						<?php echo $orphan_revision['Date_Created']; ?>
					</td>
					<td class="action-td">
						<a href="javascript:;" class="btn btn-small btn-warning">
							<i class="icon-ok"></i>								
						</a>					
						<a href="javascript:;" class="btn btn-small">
							<i class="icon-remove"></i>						
						</a>
					</td>
				</tr>

    	<?php
    			}

    		}
    	?>
					
			</tbody>
		</table>
	</div>	
</div>	
		<?php
	} 
}


/*********************************
 * Class for widgets to add/edit items.
 *
 *********************************/
class WriterWidget extends WidgetBuilder {





}


/*********************************
 * Class for widgets to manage users.
 *
 *********************************/
class UserManagerWidget extends WidgetBuilder {





}
