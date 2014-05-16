<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

class AdminController extends ModuleAdminController
{
	public $defaultAction = "ViewAllOphTrIntravitrealinjection_Treatment_Drug";

	public function actionViewTreatmentDrugs()
	{
		$model_list = OphTrIntravitrealinjection_Treatment_Drug::model()->active()->findAll(array('order' => 'display_order asc'));
		$this->jsVars['OphTrIntravitrealinjection_sort_url'] = $this->createUrl('sortTreatmentDrugs');

		Audit::add('admin','list',null,null,array('module'=>'OphTrIntravitrealinjection','model'=>'OphTrIntravitrealinjection_Treatment_Drug'));

		$this->render('list_OphTrIntravitrealinjection_Treatment_Drug',array(
				'model_list' => $model_list,
				'title' => 'Treatment Drugs',
				'model_class' => 'OphTrIntravitrealinjection_Treatment_Drug',
		));
	}

	public function actionAddTreatmentDrug()
	{
		$model = new OphTrIntravitrealinjection_Treatment_Drug();

		if (isset($_POST['OphTrIntravitrealinjection_Treatment_Drug'])) {
			$model->attributes = $_POST['OphTrIntravitrealinjection_Treatment_Drug'];

			if ($bottom_drug = OphTrIntravitrealinjection_Treatment_Drug::model()->find(array('order'=>'display_order desc'))) {
				$display_order = $bottom_drug->display_order+1;
			} else {
				$display_order = 1;
			}
			$model->display_order = $display_order;

			if ($model->save()) {
				Audit::add('admin','create',$model->id,null,array('module'=>'OphTrIntravitrealinjection','model'=>'OphTrIntravitrealinjection_Treatment_Drug'));
				Yii::app()->user->setFlash('success', 'Treatment drug created');

				$this->redirect(array('ViewTreatmentDrugs'));
			}
		}

		$this->render('create', array(
			'model' => $model,
			'title' => 'Treatment Drug',
			'cancel_uri' => '/OphTrIntravitrealinjection/admin/viewTreatmentDrugs',
		));
	}


	public function actionEditTreatmentDrug($id)
	{
		if (!$model = OphTrIntravitrealinjection_Treatment_Drug::model()->findByPk((int) $id)) {
			throw new Exception('Treatment drug not found with id ' . $id);
		}

		if (isset($_POST['OphTrIntravitrealinjection_Treatment_Drug'])) {
			$model->attributes = $_POST['OphTrIntravitrealinjection_Treatment_Drug'];

			if ($model->save()) {
				Audit::add('admin','update',$model->id,null,array('module'=>'OphTrIntravitrealinjection','model'=>'OphTrIntravitrealinjection_Treatment_Drug'));
				Yii::app()->user->setFlash('success', 'Treatment drug updated');

				$this->redirect(array('ViewTreatmentDrugs'));
			}
		}

		$this->render('update', array(
				'model' => $model,
				'title' => 'Treatment Drug',
				'cancel_uri' => '/OphTrIntravitrealinjection/admin/viewTreatmentDrugs',
		));
	}

	/*
	 * sorts the drugs into the provided order (NOTE does not support a paginated list of drugs)
	 */
	public function actionSortTreatmentDrugs()
	{
		if (!empty($_POST['order'])) {
			foreach ($_POST['order'] as $i => $id) {
				if ($drug = OphTrIntravitrealinjection_Treatment_Drug::model()->findByPk($id)) {
					$drug->display_order = $i+1;
					if (!$drug->save()) {
						throw new Exception("Unable to save drug: ".print_r($drug->getErrors(),true));
					}
				}
			}
		}
	}

	public function actionDeleteTreatmentDrugs()
	{
		$result = 1;

		foreach (OphTrIntravitrealinjection_Treatment_Drug::model()->findAllByPk($_POST['treatment_drugs']) as $drug) {
			if (!$drug->delete()) {
				$result = 0;
			}
		}

		echo $result;
	}
}
