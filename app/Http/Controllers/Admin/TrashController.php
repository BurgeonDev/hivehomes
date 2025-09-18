<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use App\Models\Society;

class TrashController extends Controller
{
    public function index($type)
    {
        switch ($type) {
            case 'posts':
                $data = Post::onlyTrashed()->get();
                break;
            case 'products':
                $data = Product::onlyTrashed()->get();
                break;
            case 'users':
                $data = User::onlyTrashed()->get();
                break;
            case 'societies':
                $data = Society::onlyTrashed()->get();
                break;
            default:
                abort(404);
        }

        return view("admin.trash.index", [
            'type' => $type,
            'items' => $data,
        ]);
    }

    public function restore($type, $id)
    {
        $model = $this->getModel($type)::onlyTrashed()->findOrFail($id);

        // Check parent status before restoring
        if (! $this->canRestoreBasedOnParents($type, $model)) {
            return back()->with('error', 'Restore failed. Please restore the parent first.');
        }

        $model->restore();

        return back()->with('success', ucfirst($type) . ' restored successfully!');
    }



    public function forceDelete($type, $id)
    {
        $model = $this->getModel($type)::onlyTrashed()->findOrFail($id);
        $model->forceDelete();

        return back()->with('success', ucfirst($type) . ' permanently deleted!');
    }

    private function getModel($type)
    {
        return match ($type) {
            'posts' => Post::class,
            'products' => Product::class,
            'users' => User::class,
            'societies' => Society::class,
            default => abort(404),
        };
    }
    private function canRestoreBasedOnParents(string $type, $model): bool
    {
        // Universal check → block if deleted_by_parent_at is set
        if (! empty($model->deleted_by_parent_at)) {
            return false;
        }

        switch ($type) {
            case 'users':
                // User must have society, and society must not be trashed
                if (! $model->society_id) return false;
                if ($model->society && $model->society->trashed()) return false;
                break;

            case 'posts':
                // Example: post belongs to user
                if (! $model->user_id) return false;
                if ($model->user && $model->user->trashed()) return false;
                break;

            case 'products':
                // Example: product belongs to society
                if (! $model->society_id) return false;
                if ($model->society && $model->society->trashed()) return false;
                break;

            // Societies don’t have a parent → always restorable
            case 'societies':
                return true;
        }

        return true;
    }
}
