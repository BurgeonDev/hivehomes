<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;

/**
 * Trait CascadesSoftDeletes
 *
 * - Works only on models that also use SoftDeletes.
 * - Models should declare protected $cascadeDeletes = ['relation1','relation2', ...];
 *
 * Behavior summary:
 * - delete(): if normal soft-delete -> soft-delete children that are active and set deleted_by_parent_at
 *             if forceDelete() -> permanently delete children (forceDelete) or detach pivots
 * - restore(): restore only children that have deleted_by_parent_at set AND whose parents are active
 */
trait CascadesSoftDeletes
{
    /**
     * Return cascade relations declared on model.
     *
     * @return array
     */
    public function getCascadeDeletes(): array
    {
        return property_exists($this, 'cascadeDeletes') ? (array) $this->cascadeDeletes : [];
    }

    public static function bootCascadesSoftDeletes()
    {
        // when a model is deleted (soft or force)
        static::deleting(function ($model) {
            foreach ($model->getCascadeDeletes() as $relationName) {
                if (! method_exists($model, $relationName)) {
                    continue;
                }

                $relation = $model->$relationName();

                // Handle pivot relations
                if ($relation instanceof BelongsToMany) {
                    if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
                        $relation->detach();
                    }
                    continue; // on soft-delete we normally leave pivot rows alone
                }

                // If force deleting -> permanently remove children (and include trashed)
                if (method_exists($model, 'isForceDeleting') && $model->isForceDeleting()) {
                    $relation->withTrashed()->cursor()->each(function ($child) {
                        if (method_exists($child, 'forceDelete')) {
                            $child->forceDelete();
                        } else {
                            DB::table($child->getTable())->where('id', $child->getKey())->delete();
                        }
                    });
                    continue;
                }

                // Normal soft-delete: only delete children that are currently active (not trashed)
                $relation->cursor()->each(function ($child) {
                    $trashed = method_exists($child, 'trashed')
                        ? $child->trashed()
                        : (bool) DB::table($child->getTable())
                            ->where('id', $child->getKey())
                            ->whereNotNull('deleted_at')
                            ->exists();

                    if ($trashed) {
                        // child was already deleted earlier — skip
                        return;
                    }

                    // mark as deleted by parent if column exists
                    if (Schema::hasColumn($child->getTable(), 'deleted_by_parent_at')) {
                        try {
                            $child->deleted_by_parent_at = Carbon::now();
                            $child->save();
                        } catch (\Throwable $e) {
                            DB::table($child->getTable())
                                ->where('id', $child->getKey())
                                ->update(['deleted_by_parent_at' => Carbon::now()]);
                        }
                    }

                    // call delete() so SoftDeletes is used if present
                    if (method_exists($child, 'delete')) {
                        $child->delete();
                    } else {
                        DB::table($child->getTable())->where('id', $child->getKey())->delete();
                    }
                });
            }
        });

        // when a model is restored
        static::restoring(function ($model) {
            foreach ($model->getCascadeDeletes() as $relationName) {
                if (! method_exists($model, $relationName)) {
                    continue;
                }

                $relation = $model->$relationName();

                if ($relation instanceof BelongsToMany) {
                    continue;
                }

                $relation->withTrashed()
                    ->whereNotNull('deleted_by_parent_at')
                    ->cursor()
                    ->each(function ($child) {
                        // Try to restore no matter what
                        if (method_exists($child, 'restore')) {
                            $child->restore();
                        }

                        if (Schema::hasColumn($child->getTable(), 'deleted_by_parent_at')) {
                            $child->deleted_by_parent_at = null;
                            $child->save();
                        }
                    });
            }
        });
    }

    /**
     * Default check to decide if a child can be restored, by verifying common parent relations.
     * Child models can implement canRestoreBasedOnParents() for custom logic.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $child
     * @return bool
     */
    protected static function canRestoreChildBasedOnParents($child): bool
    {
        if (method_exists($child, 'canRestoreBasedOnParents')) {
            return (bool) $child->canRestoreBasedOnParents();
        }

        // default parent relation names to probe
        $parentsToCheck = ['user', 'post', 'product', 'serviceProvider', 'society'];

        foreach ($parentsToCheck as $parentRel) {
            if (! method_exists($child, $parentRel)) {
                continue;
            }

            try {
                $parent = $child->$parentRel()->getResults();
            } catch (\Throwable $e) {
                $parent = null;
            }

            if (! $parent) {
                // parent missing -> cannot restore
                return false;
            }

            if (method_exists($parent, 'trashed') && $parent->trashed()) {
                return false;
            }
        }

        return true;
    }
}
