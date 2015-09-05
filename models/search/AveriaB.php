<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mant\Averia;

/**
 * AveriaB represents the model behind the search form about `app\models\mant\Averia`.
 */
class AveriaB extends Averia
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'num_vehiculo'], 'integer'],
            [['fecha', 'hora', 'descripcion', 'gravedad'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Averia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'codigo' => $this->codigo,
            'fecha' => $this->fecha,
            'hora' => $this->hora,
            'num_vehiculo' => $this->num_vehiculo,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'gravedad', $this->gravedad]);

        return $dataProvider;
    }
}
