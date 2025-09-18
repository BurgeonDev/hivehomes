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
        if (method_exists($model, 'canRestoreBasedOnParents') && ! $model->canRestoreBasedOnParents()) {
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
}
