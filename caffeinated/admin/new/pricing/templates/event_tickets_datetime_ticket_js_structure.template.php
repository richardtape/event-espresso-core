<div id="edit-datetime-form-container-holder">
		<div id="event-datetime-DTTNUM" class="event-datetime-row edit-dtt-row"></div>
</div>

<!-- edit datetime base form -->
<div id="edit-datetime-form-holder" class="hidden">
	<?php echo $default_datetime_edit_row; ?>
</div>


<!-- retrieved by js to set a new ticket row -->
<table id="ticket-row-form-holder" class="hidden">
	<tbody>
		<?php echo $default_ticket_row; ?>
	</tbody>
</table>


<!-- this is retrieved by our js to set a new price row. Note this will also contain any default prices setup by event manager -->
<table id="ticket-edit-row-initial-price-row" class="hidden">
	<tbody>
		<?php echo $default_price_row; ?>
	</tbody>
</table>

<!-- this is retrieved by our js when a brand new ticket is created (not from short-ticket context).  It contains all the default prices available. -->
<table id="ticket-edit-row-default-price-rows" class="hidden">
	<tbody>
		<?php echo $default_price_rows; ?>
	</tbody>
</table>


<!-- This is the selector and it ONLY lists price-modifiers (i.e. PBT_ID = 2 || 3).  It is used for new price rows added for EXISTING tickets (not new tickets) -->
<div id="ticket-edit-row-price-modifier-selector" class="hidden">
	<?php echo $default_price_modifier_selector_row; ?>
</div>

<!-- available tickets for datetime html -->
<div id="edit-datetime-available-tickets-holder" class="hidden">
	<?php echo $default_available_tickets_for_datetime; ?>
</div>


<!-- this will always have existing tickets listed here.  When we create a new ticket they get added to this container so that if a new datetime is created it just pulls from here. -->
<ul id="dtt-existing-available-ticket-list-items-holder" class="hidden datetime-tickets-list">
	<li class="hidden"></li>
	<?php echo $existing_available_datetime_tickets_list; ?>
</ul>


<!-- same as above except for dtts -->
<ul id="dtt-existing-available-datetime-list-items-holder" class="hidden datetime-tickets-list">
	<li class="hidden"></li>
	<?php echo $existing_available_ticket_datetimes_list; ?>
</ul>

<!-- single list item for a new available ticket created from a datetime -->
<ul id="dtt-new-available-ticket-list-items-holder" class="hidden">
	<?php echo $new_available_datetime_ticket_list_item; ?>
</ul>


<!-- single list item for a new available datetime to add to our available ticket rows -->
<ul id="dtt-new-available-datetime-list-items-holder" class="hidden">
	<?php echo $new_available_ticket_datetime_list_item; ?>
</ul>

<?php
/**
 * template args in use
 * 
 * $default_datetime_edit_row
 * $default_ticket_row
 * $default_price_row
 * $default_price_rows
 * $default_price_modifier_selector_row
 * $default_available_tickets_for_datetime
 * $existing_available_datetime_tickets_list
 * $existing_available_ticket_datetimes_list
 * $new_available_datetime_ticket_list_item
 * $new_available_ticket_datetime_list_item
 */