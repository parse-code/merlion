<?php

namespace Merlion\Components\Fields;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Log;
use Merlion\Support\ModelHelper;

class Select extends Field
{
    protected mixed $view = 'merlion::components.fields.select';
    protected iterable|Closure $options;
    protected mixed $multiple = false;

    protected string $relationship;
    protected string $relationshipTitleAttribute = 'name';
    protected bool $allowEmpty = true;

    public function options($options): static
    {
        $this->options = $options;
        return $this;
    }

    public function getOptions(): iterable
    {
        return $this->evaluate($this->options);
    }

    public function multiple($multiple = true): static
    {
        $this->multiple = $multiple;
        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->evaluate($this->multiple);
    }

    public function getRelationship(): Relation
    {
        $model = $this->getModel();
        if(is_string($model)) {
            $model = new $model;
        }
        return ModelHelper::getRelationshipModels($model, $this->relationship);
    }

    public function allowEmpty($allowEmpty): static
    {
        $this->allowEmpty = $allowEmpty;
        return $this;
    }

    public function isAllowEmpty(): bool
    {
        return $this->allowEmpty;
    }

    public function buildRelationship(): void
    {
        if (empty($this->relationship)) {
            return;
        }
        $relationship = $this->getRelationship();
        $relatedModel = $relationship->getRelated();

        switch (get_class($relationship)) {
            case MorphToMany::class:
            case BelongsToMany::class:
                $this->multiple();
                $this->allowEmpty(false);
                $options = $relatedModel->pluck($this->relationshipTitleAttribute,
                    $relationship->getRelatedKeyName());
                $this->saveUsing(function ($model, $select) {
                    $model->{$select->relationship}()->sync($select->getValueFromRequest());
                    return $model;
                });
                break;
            case BelongsTo::class:
                $this->multiple(false);
                $options = $relatedModel->pluck($this->relationshipTitleAttribute,
                    $relationship->getOwnerKeyName());
                break;
            default:
                $options = [];
        }
        $this->options = $options;

        $values = [];
        $model  = $this->getModel();
        if ($model instanceof Model) {
            $relationship = $this->getRelationship();
            switch (get_class($relationship)) {
                case MorphToMany::class:
                case BelongsToMany::class:
                    $values = $model->{$this->relationship}()->pluck($relationship->getQualifiedRelatedKeyName())->toArray();
                    break;
                case BelongsTo::class:
                    $values = $model->{$this->relationship}->getKey();
                    break;
            }
        }

        $this->getValueUsing = $values;
    }

    public function relationship($name = null, $titleAttribute = 'name'): static
    {
        $this->relationship               = $name ?? $this->getName();
        $this->relationshipTitleAttribute = $titleAttribute;
        return $this;
    }
}
