<?php

/**
 * Copyright © 2015-2016 Marcos García de La Fuente <hola@marcosgdf.com>
 * Copyright © 2020 Julio Gonzalez <jrgonzalezrios@gmail.com>
 *
 * This file is part of Importpurchaselines, un module développé sur la base du module importorderline développé par Marcos Garcia
 *
 * This file is part of Importpurchaselines.
 *
 * Multismtp is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Multismtp is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Multismtp.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Dolibarr license:
 *
 * You can find a copy of the code at http://github.com/dolibarr/dolibarr
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

class Utils
{

	/**
	 * Piece of code extracted from Form::formconfirm to show a confirm dialog with a upload form
	 * File input has name 'uploadfile'
	 *
	 * @param string $page Url of page to call if confirmation is OK
	 * @param string $title Title
	 * @param string $question Question
	 * @param string $action Action
	 * @param string $label Label of the input
	 * @return string HTML code
	 */
	public static function uploadForm($page, $title, $question, $action, $label)
	{
		global $langs;

		$formconfirm = "\n<!-- begin form_confirm page=".$page." -->\n";

		$formconfirm.= '<form method="POST" action="'.$page.'" class="notoptoleftroright" enctype="multipart/form-data">'."\n";
		$formconfirm.= '<input type="hidden" name="action" value="'.$action.'">';
		$formconfirm.= '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">'."\n";

		$formconfirm.= '<table width="100%" class="valid">'."\n";

		// Line title
		$formconfirm.= '<tr class="validtitre"><td class="validtitre" colspan="3">'.img_picto('','recent').' '.$title.'</td></tr>'."\n";

		// Line form fields
		$formconfirm.='<tr class="valid"><td class="valid" colspan="3">'."\n";
		$formconfirm.=$label.'</td><td valign="top" colspan="2" align="left">';
		$formconfirm.= '<input type="file" name="uploadfile">';
		$formconfirm.='</td></tr>'."\n";
		$formconfirm.='</td></tr>'."\n";

		// Line with question
		$formconfirm.= '<tr class="valid">';
		$formconfirm.= '<td class="valid" colspan="3"></td>';
		$formconfirm.= '<td class="valid" colspan="2"><input class="button" type="submit" value="'.$langs->trans("Upload").'"></td>';
		$formconfirm.= '</tr>'."\n";

		$formconfirm.= '</table>'."\n";

		$formconfirm.= "</form>\n";
		$formconfirm.= '<br>';

		$formconfirm.= "<!-- end form_confirm -->\n";

		return $formconfirm;
	}

	/**
	 * Adds a product to the purchase
	 *
	 * @param CommandeFournisseur $object CommandeFournisseur object
	 * @param Product $prod Product to add
	 * @param int $qty Quantity of the product
	 * @throws Exception
	 */
	public static function addpurchaseLine(CommandeFournisseur $object, Product $prod, $qty, $prixuht)
	{
		global $db, $conf, $mysoc, $langs;

		$tva_tx = get_default_tva($mysoc, $object->thirdparty, $prod->id);
		$tva_npr = get_default_npr($mysoc, $object->thirdparty, $prod->id);

		$pu_ht = $prod->cost_price;
		$price_base_type = $prod->price_base_type;
		$type = $prod->type;
		$pu_ttc = $prod->price_ttc;

		// Local Taxes
		$localtax1_tx = get_localtax($tva_tx, 1, $object->thirdparty);
		$localtax2_tx = get_localtax($tva_tx, 2, $object->thirdparty);

		include_once DOL_DOCUMENT_ROOT.'/fourn/class/fournisseur.product.class.php';
		$product_fourn = new ProductFournisseur($db);
		$product_fourn_result = $product_fourn->find_min_price_product_fournisseur($prod->id, $qty, $object->thirdparty->id);

		if($product_fourn_result > 0){
			$pu_ht = $product_fourn->fourn_unitprice;
			$pu_ttc = $product_fourn->price_ttc;
		}

		// Define output language
		if (! empty($conf->global->MAIN_MULTILANGS) && ! empty($conf->global->PRODUIT_TEXTS_IN_THIRDPARTY_LANGUAGE)) {
			$outputlangs = $langs;
			$newlang = '';
			if (empty($newlang) && GETPOST('lang_id'))
				$newlang = GETPOST('lang_id');
			if (empty($newlang))
				$newlang = $object->thirdparty->default_lang;
			if (! empty($newlang)) {
				$outputlangs = new Translate("", $conf);
				$outputlangs->setDefaultLang($newlang);
			}

			$desc = (! empty($prod->multilangs [$outputlangs->defaultlang] ["description"])) ? $prod->multilangs [$outputlangs->defaultlang] ["description"] : $prod->description;
		} else {
			$desc = $prod->description;
		}

		// Add custom code and origin country into description
		if (empty($conf->global->MAIN_PRODUCT_DISABLE_CUSTOMCOUNTRYCODE) && (! empty($prod->customcode) || ! empty($prod->country_code))) {
			$tmptxt = '(';
			if (! empty($prod->customcode))
				$tmptxt .= $langs->transnoentitiesnoconv("CustomCode") . ': ' . $prod->customcode;
			if (! empty($prod->customcode) && ! empty($prod->country_code))
				$tmptxt .= ' - ';
			if (! empty($prod->country_code))
				$tmptxt .= $langs->transnoentitiesnoconv("CountryOrigin") . ': ' . getCountry($prod->country_code, 0, $db, $langs, 0);
			$tmptxt .= ')';
			$desc = dol_concatdesc($desc, $tmptxt);
		}

		$info_bits = 0;
		if ($tva_npr)
			$info_bits |= 0x01;

		//Percent remise
		if (! empty($object->thirdparty->remise_percent)) {
			$percent_remise = $object->thirdparty->remise_percent;
		} else {
			$percent_remise=0;
		}
		
		// Insert line
		$result = $object->addline(
			$desc, //Description
			$default_cost_price, //Unit price
			$qty, //Quantity
			$tva_tx, //Taux tva
			$localtax1_tx, //Localtax1 tax
			$localtax2_tx, //Localtax2 tax
			$prod->id, //Id product
			$object->thirdparty->id, //int Id supplier price
			'',//string, //Supplier reference price
			$percent_remise, //float Remise
			$price_base_type, //string HT or TTC
			$pu_ttc, //float Unit price TTC
			$type, //int Type of line (0=product, 1=service)
			$info_bits, //More information
			0, //bool Disable triggers
			0, //int Date start of service
			0, //int Date end of service
			null, //array extrafields array
			null, //string Code of the unit to use. Null to use the default one
			'', //string Amount in currency
			'', //string 'order', ...
			0 //int Id of origin object*/
		);

		if ($result < 0) {
			throw new Exception($langs->trans('ErrorAddpurchaseLine', $prod->ref));
			}
	}

}