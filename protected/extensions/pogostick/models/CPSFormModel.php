<?php
/**
 * CPSFormModel class file.
 *
 * @author Jerry Ablan <jablan@pogostick.com>
 * @link http://ps-yii-extensions.googlecode.com
 * @copyright Copyright &copy; 2009 Pogostick, LLC
 * @license http://www.pogostick.com/license/
 */

/**
 * CPSFormModel provides something stupid
 *
 * @author Jerry Ablan <jablan@pogostick.com>
 * @version SVN: $Id: CPSFormModel.php 126 2009-04-29 04:07:25Z jerryablan $
 * @filesource
 * @package psYiiExtensions
 * @subpackage Models
 * @since 1.0.4
 */
class CPSFormModel extends CFormModel
{
	/**
	* Fixup attribute labels for my funky naming conventions...
	*
	* @param string $sName
	* @return mixed
	*/
	public function generateAttributeLabel( $sName )
	{
		if ( substr( $sName, 0, 2 ) == 'm_' )
			$sName = substr( $sName, 3 );

		return( parent::generateAttributeLabel( $sName ) );
	}
}