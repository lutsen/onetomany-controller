<?php

namespace Lagan\Property;

/**
 * Controller for the Lagan one-to-many property.
 * Lets the user define a one-to-many relation between two content objects.
 * The Onetomany property type controller enables a one-to-many relation between 2 Lagan models.
 * The name of the property should be the name of the Lagan model this model can have a one-to-many
 * relation with. For this to work properly the other model should have a many-to-one relation with this model.
 * So in our example in the Lagan project the Lagan Hoverkraft model has a one-to-many relation
 * with the Lagan Crew model, and the Lagan Crew model has a many-to-one relation with the Lagan Hoverkraft model.
 *
 * A property type controller can contain a set, read, delete and options method. All methods are optional.
 * To be used with Lagan: https://github.com/lutsen/lagan
 */

class Onetomany {

	/**
	 * The set method is executed each time a property with this type is set.
	 *
	 * @param bean		$bean		The Redbean bean object with the property.
	 * @param array		$property	Lagan model property arrray.
	 * @param integer[]	$new_value	An array with id's of the objects the object with this property has a one-to-many relation with.
	 *
	 * @return boolean	Returns false because a one-to-many relation is only set in the bean with the one-to-many relation
	 */
	public function set($bean, $property, $new_value) {

		foreach ($new_value as $id) {
			$related = \R::load(  $property['name'], $id );
			$related->{ $bean->type.'_id' } = $id;
			\R::store($related);
		}

		return false;

	}

	/**
	 * The read method is executed each time a property with this type is read.
	 *
	 * @param bean		$bean		The Readbean bean object with this property.
	 * @param string[]		$property	Lagan model property arrray.
	 *
	 * @return bean[]	Array with Redbean beans with a many-to-one relation with the object with this property.
	 */
	public function read($bean, $property) {

		$list_name = 'own'.ucfirst($property['name']).'List';
		return  $bean->{ $list_name };

	}

	/**
	 * The options method returns all the optional values this property can have,
	 * but NOT the ones it currently has.
	 *
	 * @param bean		$bean		The Readbean bean object with this property.
	 * @param array		$property	Lagan model property arrray.
	 *
	 * @return bean[]	Array with all beans of the $property['name'] Lagan model.
	 */
	public function options($bean, $property) {

		$list_name = 'own'.ucfirst($property['name']).'List';
		// List of beans who allready have a one-to-many ralation with this bean
		$relations = $bean->{ $list_name };
		$ids = [];
		foreach ($relations as $relation) {
			$ids[] = $relation->id;
		}

		return	\R::find( $property['name'],
				' '.$property['name'].'_id NOT IN ('.\R::genSlots( $ids ).')',
				$ids );
	}

}

?>