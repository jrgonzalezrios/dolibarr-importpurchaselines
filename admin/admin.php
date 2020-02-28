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
print load_fiche_titre($langs->trans('ImportproductLinesInfo'), $linkback);

?>

<div class="titre"><?php echo $langs->trans('ImportproductLinesTitle') ?></div>

<p><?php echo $langs->trans('ImportproductLinesInfoFormat') ?></p><ul>
	<li><?php echo $langs->trans('ImportproductLinesInfoFormatA', $langs->transnoentities('Ref')) ?></li>
	<li><?php echo $langs->trans('ImportproductLinesInfoFormatB', $langs->transnoentities('Label')) ?></li>
	<li><?php echo $langs->trans('ImportproductLinesInfoFormatC', $langs->transnoentities('Qty')) ?></li>
	<li><?php echo $langs->trans('ImportproductLinesInfoFormatD', $langs->transnoentities('PU ht')) ?></li>
</ul>
<p><?php echo $langs->trans('ImportproductLinesInfoFormatMore') ?></p>
<p><?php echo $langs->trans('ImportproductLinesInfoFormatCreate',
		$langs->transnoentities('Tools'),
		$langs->transnoentities('NewExport'),
		$langs->transnoentities('Products'),
		$langs->transnoentities('Ref')
	).$langs->trans('ImportproductLinesInfoFormatCreate2',
			$langs->transnoentities('Label'),
			$langs->transnoentities('Qty')
		) ?></p>
<p><?php echo $langs->trans('ImportproductLinesInfoFormatExample') ?></p>
<img src="<?php echo $langs->trans('ImportproductLinesInfoFormatExampleImgSrc') ?>" alt="<?php echo $langs->trans('ImportproductLinesInfoFormatExampleImgAlt') ?>">

<br><br>
<p><?php echo $langs->trans('ImportproductLinesInfoLibelleCol') ?></p>

<div class="titre"><?php echo $langs->trans('ImportproductLinesInfoUsing') ?></div>

<p><?php echo $langs->trans('ImportproductLinesInfoUsingpurchase', $langs->transnoentities('ImportpurchaseLines')) ?></p>
<p><b><?php echo $langs->trans('ImportproductLinesInfoParticularites') ?></b></p>

<br>

<div class="titre"><?php echo $langs->trans('ImportproductLinesAbout') ?></div>

<p><?php echo $langs->trans('ImportproductLinesAuthor', '<a href="#"></a>', '<a href="#">importorderline</a>', '<a href=""></a>') ?></p>
<p><?php echo $langs->trans('ImportproductLinesContact', '<a href="mailto:jrgonzalezrios@gmail.com">jrgonzalezrios@gmail.com</a>') ?></p>

<?php

llxFooter();