<?php

class Branchsite extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'branchsite';
	}

	public function rules()
	{
		return array(
			array('street_address, branch_name, organisation, quartier', 'required'),
			array('organisation, quartier', 'numerical', 'integerOnly'=>true),
			array('street_address, url, branch_name', 'length', 'max'=>250),
			array('longitude, latitude, site_phone', 'length', 'max'=>45),
			array('id, street_address, longitude, latitude, url, site_phone, branch_name, organisation, quartier', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'quartier0' => array(self::BELONGS_TO, 'Quartier', 'quartier'),
			'organisation0' => array(self::BELONGS_TO, 'Organisation', 'organisation'),
			'categories' => array(self::MANY_MANY, 'Category', 'branchsite_has_category(branchsite, category)'),
			'sitePrices' => array(self::HAS_MANY, 'SitePrice', 'branchsite'),
		);
	}

	public function behaviors()
	{
		return array('CAdvancedArBehavior',
				array('class' => 'ext.CAdvancedArBehavior')
				);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'street_address' => Yii::t('app', 'Street Address'),
			'longitude' => Yii::t('app', 'Longitude'),
			'latitude' => Yii::t('app', 'Latitude'),
			'url' => Yii::t('app', 'Url'),
			'site_phone' => Yii::t('app', 'Site Phone'),
			'branch_name' => Yii::t('app', 'Branch Name'),
			'organisation' => Yii::t('app', 'Organisation'),
			'quartier' => Yii::t('app', 'Quartier'),
                        'organisation0.name'=> Yii::t('app','Organisation'),
                        'quartier0.name'=>Yii::t('app','Quartier'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('street_address',$this->street_address,true);

		$criteria->compare('longitude',$this->longitude,true);

		$criteria->compare('latitude',$this->latitude,true);

		$criteria->compare('url',$this->url,true);

		$criteria->compare('site_phone',$this->site_phone,true);

		$criteria->compare('branch_name',$this->branch_name,true);

		$criteria->compare('organisation',$this->organisation);

		$criteria->compare('quartier',$this->quartier);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
        
        // List all of the organisation
        
         public function getOrganisations(){
            return CHtml::listData(Organisation::model()->findAll(),'id','name');
                
        }
        
        // return one organisation
        
        public function getOrganisation()
            {
                $oneOrganisation = $this->getOrganisations();
                return $oneOrganisation[$this->name];
            }
}
