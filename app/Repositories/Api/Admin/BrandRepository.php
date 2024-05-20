<?php

namespace App\Repositories\Api\Admin;

use App\Helpers\PaginationHelper;
use App\Helpers\SystemHelper;
use App\Interfaces\Api\Admin\BrandInterface;
use App\Models\Role;
use App\Models\User;
use App\Models\Brand;
use App\Services\GenerateRandomService;
use Str;

class BrandRepository implements BrandInterface
{
    private $model;
    private $user;

    public function __construct()
    {
        $this->model = new Brand();
        $this->user = new User();
    }

    // TODO: Get all brands.
    public function getAllBrands($request)
    {

        $brands = $this->model->whereSearch($request);
        $brands = PaginationHelper::paginate(
            $brands,
            $request->input('per_page', config('systemSetting.system_per_page_count')),
            $request->input('page', config('systemSetting.system_current_page'))
        );
        return $brands;
    }

    // TODO: Get all brands list.
    public function getAllBrandList()
    {
        $brands = $this->model
            ->select('name', 'id','public_key','leverage','margin_call')
            ->get();
        return $brands;
    }

    // TODO: Create a brand.
    public function createBrand(array $data)
    {
        $password = Str::random(6);
        $user = $this->user->create([
            'name' => $data['name'],
            'email' => $data['name'] . '@broker.com',
            'password' => bcrypt($password),
            'original_password' => $password
        ]);

        $brand = $this->model->create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'public_key' => GenerateRandomService::getBrandPublicKey(),
            'domain' => $data['domain'],
            'margin_call' => $data['margin_call'],
            'leverage' => $data['leverage'] ?? 1,
            'stop_out' => $data['stop_out'] ?? 0,
        ]);

        $user->assignRole(Role::BRAND);

        return $user;
    }

    // TODO: Find a brand by ID.
    public function findBrandById($id)
    {
        return $this->model->findOrFail($id);
    }

    // TODO: Update a brand.
    public function updateBrand(array $data, $id)
    {
        $brand = $this->model->findOrFail($id);
        $brand->update(prepareUpdateCols($data, 'brands'));
        return $brand;
    }

    // TODO: Delete a brand.
    public function deleteBrand($id)
    {
        $this->model->findOrFail($id)->delete();
    }
}
