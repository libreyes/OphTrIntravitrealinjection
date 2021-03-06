<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<div class="element-fields element-eyes row">
	<?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>
	<div
		class="element-eye right-eye left side column <?php if (!$element->hasRight()) { ?> inactive<?php } ?>"
		data-side="right">
		<div class="active-form">
			<?php $this->renderPartial($element->form_view . '_fields',
				array('side' => 'right', 'element' => $element, 'form' => $form, 'data' => $data)); ?>
		</div>
		<div class="inactive-form">
			<div class="add-side">
			Set right side treatment drug
			</div>
		</div>
	</div>

	<div
		class="element-eye left-eye right side column<?php if (!$element->hasLeft()) { ?> inactive<?php } ?>"
		data-side="left">
		<div class="active-form">
			<?php $this->renderPartial($element->form_view . '_fields',
				array('side' => 'left', 'element' => $element, 'form' => $form, 'data' => $data)); ?>
		</div>
		<div class="inactive-form">
			<div class="add-side">
			Set left side treatment drug
			</div>
		</div>
	</div>

</div>
