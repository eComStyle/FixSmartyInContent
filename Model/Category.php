<?php
/*    Please retain this copyright header in all versions of the software
 *
 *    Copyright (C) Josef A. Puckl | eComStyle.de
 *
 *    This program is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    This program is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */

namespace Ecs\FixSmartyInContent\Model;

use \OxidEsales\Eshop\Core\Field;

class Category extends Category_parent
{
    public function assign($dbRecord)
    {
        parent::assign($dbRecord);
        if ($this->oxcategories__oxlongdesc) {
            $this->oxcategories__oxlongdesc->setValue(str_replace('-&gt;', '->', $this->oxcategories__oxlongdesc->value), Field::T_RAW);
        }
    }
}
