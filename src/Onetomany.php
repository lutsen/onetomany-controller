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

		$list = [];
		foreach ($new_value as $id) {
			if ($id) {
				$list[] = \R::load(  $property['name'], $id );
			}
		}

		$bean->{ 'own'.ucfirst($property['name']).'List' } = $list;
		\R::store($bean);

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

		return  $bean->{ 'own'.ucfirst($property['name']).'List' };

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

		if ( $bean ) {

			// Return only beans with other or now $col_name id
			$col_name = $bean->getMeta( 'type' ) . '_id';
			return	\R::find( $property['name'],
					' '.$col_name.' != ? OR  '.$col_name.' IS NULL ',
					[ $bean->id ] );

		} else {

			return \R::findAll( $property['name'] );

		}

	}

}

?>