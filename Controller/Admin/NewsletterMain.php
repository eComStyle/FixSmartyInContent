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

namespace Ecs\FixSmartyInContent\Controller\Admin;

use \OxidEsales\Eshop\Core\Registry;

class NewsletterMain extends NewsletterMain_parent
{

    public function save()
    {

        $myConfig = $this->getConfig();

        $soxId   = $this->getEditObjectId();
        $aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("editval");

        // FixSmartyInContent Start
        if (isset($aParams['oxnewsletter__oxtemplate'])) {
            $aParams['oxnewsletter__oxtemplate'] = str_replace('-&gt;', '->', $aParams['oxnewsletter__oxtemplate']);
        }
        // FixSmartyInContent Ende

        // shopid
        $sShopID                           = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable("actshop");
        $aParams['oxnewsletter__oxshopid'] = $sShopID;

        $oNewsletter = oxNew(\OxidEsales\Eshop\Application\Model\Newsletter::class);
        if ($soxId != "-1") {
            $oNewsletter->load($soxId);
        } else {
            $aParams['oxnewsletter__oxid'] = null;
        }

        $oNewsletter->assign($aParams);
        $oNewsletter->save();

        // set oxid if inserted
        $this->setEditObjectId($oNewsletter->getId());
    }
}
