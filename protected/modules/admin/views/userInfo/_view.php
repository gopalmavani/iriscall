<?php
/* @var $this UserInfoController */
/* @var $data UserInfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->user_id), array('view', 'id'=>$data->user_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('full_name')); ?>:</b>
	<?php echo CHtml::encode($data->full_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
	<?php echo CHtml::encode($data->first_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
	<?php echo CHtml::encode($data->last_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_of_birth')); ?>:</b>
	<?php echo CHtml::encode($data->date_of_birth); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sponsor_id')); ?>:</b>
	<?php echo CHtml::encode($data->sponsor_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_enabled')); ?>:</b>
	<?php echo CHtml::encode($data->is_enabled); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_active')); ?>:</b>
	<?php echo CHtml::encode($data->is_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_at')); ?>:</b>
	<?php echo CHtml::encode($data->modified_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_name')); ?>:</b>
	<?php echo CHtml::encode($data->business_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('vat_number')); ?>:</b>
	<?php echo CHtml::encode($data->vat_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('busAddress_building_num')); ?>:</b>
	<?php echo CHtml::encode($data->busAddress_building_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('busAddress_street')); ?>:</b>
	<?php echo CHtml::encode($data->busAddress_street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('busAddress_region')); ?>:</b>
	<?php echo CHtml::encode($data->busAddress_region); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('busAddress_city')); ?>:</b>
	<?php echo CHtml::encode($data->busAddress_city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('busAddress_postcode')); ?>:</b>
	<?php echo CHtml::encode($data->busAddress_postcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('busAddress_country')); ?>:</b>
	<?php echo CHtml::encode($data->busAddress_country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('business_phone')); ?>:</b>
	<?php echo CHtml::encode($data->business_phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('building_num')); ?>:</b>
	<?php echo CHtml::encode($data->building_num); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('street')); ?>:</b>
	<?php echo CHtml::encode($data->street); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('region')); ?>:</b>
	<?php echo CHtml::encode($data->region); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('city')); ?>:</b>
	<?php echo CHtml::encode($data->city); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('postcode')); ?>:</b>
	<?php echo CHtml::encode($data->postcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country')); ?>:</b>
	<?php echo CHtml::encode($data->country); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_delete')); ?>:</b>
	<?php echo CHtml::encode($data->is_delete); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo CHtml::encode($data->image); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role')); ?>:</b>
	<?php echo CHtml::encode($data->role); ?>
	<br />

	*/ ?>

</div>