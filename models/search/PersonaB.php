<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\mant\Persona;

/**
 * PersonaB represents the model behind the search form about `app\models\mant\Persona`.
 */
class PersonaB extends Persona
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codigo', 'cod_municipio', 'cod_nacionalidad', 'cod_estado_civil'], 'integer'],
            [['nombre', 'apellido', 'dui', 'nit', 'fecha_nacimiento', 'genero', 'direccion', 'profesion', 'estado', 'nombre_usuario'], 'safe'],
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
        $query = Persona::find();

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
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'cod_municipio' => $this->cod_municipio,
            'cod_nacionalidad' => $this->cod_nacionalidad,
            'cod_estado_civil' => $this->cod_estado_civil,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'dui', $this->dui])
            ->andFilterWhere(['like', 'nit', $this->nit])
            ->andFilterWhere(['like', 'genero', $this->genero])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'profesion', $this->profesion])
            ->andFilterWhere(['like', 'estado', $this->estado])
            ->andFilterWhere(['like', 'nombre_usuario', $this->nombre_usuario]);

        return $dataProvider;
    }
}
