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

class ContentMain extends ContentMain_parent
{

    public function save()
    {
        //parent::save();
        $this->resetContentCache();

        $myConfig = $this->getConfig();

        $soxId   = $this->getEditObjectId();
        $aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("editval");

        // FixSmartyInContent Start
        if (isset($aParams['oxcontents__oxcontent'])) {
            $aParams['oxcontents__oxcontent'] = str_replace('-&gt;', '->', $aParams['oxcontents__oxcontent']);
        }
        // FixSmartyInContent Ende

        if (isset($aParams['oxcontents__oxloadid'])) {
            $aParams['oxcontents__oxloadid'] = $this->_prepareIdent($aParams['oxcontents__oxloadid']);
        }

        // check if loadid is unique
        if ($this->_checkIdent($aParams['oxcontents__oxloadid'], $soxId)) {
            // loadid already used, display error message
            $this->_aViewData["blLoadError"] = true;

            $oContent = oxNew(\OxidEsales\Eshop\Application\Model\Content::class);
            if ($soxId != '-1') {
                $oContent->load($soxId);
            }
            $oContent->assign($aParams);
            $this->_aViewData["edit"] = $oContent;

            return;
        }

        // checkbox handling
        if (!isset($aParams['oxcontents__oxactive'])) {
            $aParams['oxcontents__oxactive'] = 0;
        }

        // special treatment
        if ($aParams['oxcontents__oxtype'] == 0) {
            $aParams['oxcontents__oxsnippet'] = 1;
        } else {
            $aParams['oxcontents__oxsnippet'] = 0;
        }

        //Updates object folder parameters
        if ($aParams['oxcontents__oxfolder'] == 'CMSFOLDER_NONE') {
            $aParams['oxcontents__oxfolder'] = '';
        }

        $oContent = oxNew(\OxidEsales\Eshop\Application\Model\Content::class);

        if ($soxId != "-1") {
            $oContent->loadInLang($this->_iEditLang, $soxId);
        } else {
            $aParams['oxcontents__oxid'] = null;
        }

        //$aParams = $oContent->ConvertNameArray2Idx( $aParams);

        $oContent->setLanguage(0);
        $oContent->assign($aParams);
        $oContent->setLanguage($this->_iEditLang);
        $oContent->save();

        // set oxid if inserted
        $this->setEditObjectId($oContent->getId());
    }
}
