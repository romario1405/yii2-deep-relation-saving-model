# Repeater widget for OR models

### Example usages:

```php
echo $form->field($model, 'relationName')->widget(TabularRelation::class, [
    'columns'             => [
        [
            'attribute'      => 'title',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
        [
            'attribute'      => 'article_id',
            'label'          => false,
            'wrapperOptions' => [
                'options' => [
                    'class' => 'hide left',
                ],
            ],
        ],
        [
            'attribute'      => 'slug',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
        [
            'attribute'      => 'body',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
        [
            'attribute'      => 'language',
            'wrapperOptions' => [
                'options' => [
                    'class' => 'col-md-2',
                ],
            ],
        ],
    ],
    'headerTemplate'      => '<div class=\'col-md-2\'>{label}</div>',
    'repeaterItemOptions' => [
        'class' => 'repeater-item',
    ],
    'form'                => $form,
    'min'                 => 2,
]);
```

## Using nested models


## Options

All fields with `*` are required!

| Option | Type | Description |
| ------ | ---- | ----------- |
| form* | yii\widgets\ActiveForm | Form object |
| model* | \yii\db\ActiveRecord | Parent model |
| columns | array | Columns config for repeaters |
| renderLabels | bool | If false attribute labels does not rendering |
| pluginOptions | array | Options for jquery.repeater widget |
| rowWrapperOptions | array | Row wrapper options |
| repeaterItemOptions | array | Repeater item wrapper options |
| repeaterTitle | string | Widget title |

### Columns config options

| Option | Type | Desctiption |
| ------ | ---- | ----------- |

