<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\ViewArea;
use common\models\OltBuilt;
use common\models\OltPlan;
use common\models\OdpBuilt;
use common\models\OdpPlan;
use common\models\OdcBuilt;
use common\models\OdcPlan;
use yii\helpers\Json;
use ShapeFile\ShapeFile;
/**
 * Site controller
 */
class MapController extends Controller
{

    public function actionGetFeaturesByCoordinates()
    {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$results = [];
		
		$result = ViewArea::find()->where(['=','ST_DWithin(st_transform(geom,900913), ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->all();
        foreach ($result as $entity) {
			array_push($results,['area',$entity]);
		}
		
		$result = OltBuilt::find()->where(['=','ST_DWithin(st_transform(geom,900913), ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->all();
        foreach ($result as $entity) {
			array_push($results,['olt_built',$entity]);
		}
		
		$result = OltPlan::find()->where(['=','ST_DWithin(st_transform(geom,900913), ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->all();
        foreach ($result as $entity) {
			array_push($results,['olt_plan',$entity]);
		}
		
		$result = OdcBuilt::find()->where(['=','ST_DWithin(st_transform(geom,900913), ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->all();
        foreach ($result as $entity) {
			array_push($results,['odc_built',$entity]);
		}
		
		$result = OdcPlan::find()->where(['=','ST_DWithin(st_transform(geom,900913), ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->all();
        foreach ($result as $entity) {
			array_push($results,['odc_plan',$entity]);
		}
		
		$result = OdpBuilt::find()->where(['=','ST_DWithin(st_transform(geom,900913), ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->all();
        foreach ($result as $entity) {
			array_push($results,['odp_built',$entity]);
		}
		
		$result = OdpPlan::find()->where(['=','ST_DWithin(st_transform(geom,900913), ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->all();
        foreach ($result as $entity) {
			array_push($results,['odp_plan',$entity]);
		}
		
		
		return JSON::encode($results);
    }
	
	public function actionGetSummaryByCoordinates()
    {
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$results = [];
		
		$boundary = PotentialCaWithGeom::find()->where(['=','ST_DWithin(geom, ST_setSRID(ST_MakePoint('.Yii::$app->request->get('x')
			.','.Yii::$app->request->get('y').'),900913), '.(5*Yii::$app->request->get('resolution')).')',true])->one();
        $result = Tiang::find()->where(['=','ST_Within(geom, ST_GeomFromText(\''.$boundary->coordinates.'\',3857))',true])->count();
		array_push($results,['tiang',$result == null ? 0:$result]);
		
		$result = Odp::find()->where(['=','ST_Within(geom, ST_GeomFromText(\''.$boundary->coordinates.'\',3857))',true])->count();
		array_push($results,['odp',$result == null ? 0:$result]);
		
		$result = Odc::find()->where(['=','ST_Within(geom, ST_GeomFromText(\''.$boundary->coordinates.'\',3857))',true])->count();
		array_push($results,['odp',$result == null ? 0:$result]);
		
		return JSON::encode($results);
    }

	public function actionUpload()
	{
		$shapeFile = new ShapeFile('uploads/shp/BOUNDARY.shp');
		foreach ($shapeFile as $i => $record) {
			if ($record['dbf']['_deleted']) continue;
			// Record number
			echo "Record number: $i\n";
			// Geometry
			print_r($record['shp']);
			echo "<br /><br />";
			// DBF Data
			print_r($record['dbf']);
			echo "<br /><br /><br />";
		}
	}
    
}
