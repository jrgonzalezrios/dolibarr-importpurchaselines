<?php

/**
 * Copyright © 2015-2016 Marcos García de La Fuente <hola@marcosgdf.com>
 * Copyright © 2020 Julio Gonzalez <jrgonzalezrios@gmail.com>
 *
 * This file is part of Importpurchaselines, un module développé sur la base du module importorderline développé par Marcos Garcia
 *
 * This file is part of Importorpurchase lines.
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

if (file_exists('../../main.inc.php')) {
	require __DIR__.'/../../main.inc.php';
} else {
	require __DIR__.'/../../../main.inc.php';
}

$langs->load('admin');
$langs->load('exports');
$langs->load('other');
$langs->load('importpurchaselines@importpurchaselines');

llxHeader();

$linkback='<a href="'.DOL_URL_ROOT.'/admin/modules.php">'.$langs->trans("BackToModuleList").'</a>';
print load_fiche_titre($langs->trans('ImportPurchaseLinesInfo'), $linkback);

?>

<div class="titre"><?php echo $langs->trans('ImportPurchaseLinesTitle') ?></div>

<p><?php echo $langs->trans('ImportPurchaseLinesInfoFormat') ?></p><ul>
	<li><?php echo $langs->trans('ImportPurchaseLinesInfoFormatA', $langs->transnoentities('Ref')) ?></li>
	<li><?php echo $langs->trans('ImportPurchaseLinesInfoFormatB', $langs->transnoentities('Label')) ?></li>
	<li><?php echo $langs->trans('ImportPurchaseLinesInfoFormatC', $langs->transnoentities('Qty')) ?></li>
	<li><?php echo $langs->trans('ImportPurchaseLinesInfoFormatD', $langs->transnoentities('PU ht')) ?></li>
</ul>
<p><?php echo $langs->trans('ImportPurchaseLinesInfoFormatMore') ?></p>
<p><?php echo $langs->trans('ImportPurchaseLinesInfoFormatCreate',
		$langs->transnoentities('Tools'),
		$langs->transnoentities('NewExport'),
		$langs->transnoentities('Products'),
		$langs->transnoentities('Ref')
	).$langs->trans('ImportPurchaseLinesInfoFormatCreate2',
			$langs->transnoentities('Label'),
			$langs->transnoentities('Qty')
		) ?></p>
<p><?php echo $langs->trans('ImportPurchaseLinesInfoFormatExample') ?></p>
<img src="<?php echo $langs->trans('ImportPurchaseLinesInfoFormatExampleImgSrc') ?>" alt="<?php echo $langs->trans('ImportPurchaseLinesInfoFormatExampleImgAlt') ?>">

<br><br>
<p><?php echo $langs->trans('ImportPurchaseLinesInfoLibelleCol') ?></p>

<div class="titre"><?php echo $langs->trans('ImportPurchaseLinesInfoUsing') ?></div>

<p><?php echo $langs->trans('ImportPurchaseLinesInfoUsingpurchase', $langs->transnoentities('ImportPurchaseLines')) ?></p>
<p><b><?php echo $langs->trans('ImportPurchaseLinesInfoParticularites') ?></b></p>

<br>

<div class="titre"><?php echo $langs->trans('ImportPurchaseLinesAbout') ?></div>

<p><?php echo $langs->trans('ImportPurchaseLinesAuthor', '<a href="#"></a>', '<a href="#">importpurchaseline</a>', '<a href=""></a>') ?></p>
<p><?php echo $langs->trans('ImportPurchaseLinesContact', '<a href="mailto:jrgonzalezrios@gmail.com">jrgonzalezrios@gmail.com</a>') ?></p>

<?php

llxFooter();