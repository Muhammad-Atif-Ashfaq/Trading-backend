<?php
namespace App\Repositories\Api\Admin;

use App\Helpers\PaginationHelper;
use App\Models\SymbelSetting;


class SymbelSettingRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new SymbelSetting();

    }

    public function getAllSymbelSettings($request)
    {
        $symbelSettings = $this->model::query();
        $symbelSettings = PaginationHelper::paginate(
            $symbelSettings,
            $request->input('per_page', config('systemSetting.system_per_page_count')),
            $request->input('page', config('systemSetting.system_per_page_count'))
        );
        return $symbelSettings;
    }

    public function createSymbelSetting(array $data)
    {

        $symbelSetting = $this->model->create([
            'name' => $data['name'],
            'symbel_group_id'  => $data['symbel_group_id'],
            'feed_name' => $data['feed_name'],
            'feed_name_fetch' => $data['feed_name_fetch'],
            'feed_price_fetch'  => $data['feed_price_fetch'],
            'speed_max'  => $data['speed_max'],
            'leverage'=> $data['leverage'],
            'swap' => $data['swap'],
            'lot_size'=> $data['lot_size'],
            'lot_step'=> $data['lot_step'],
            'vol_min'=> $data['vol_min'],
            'vol_max'=> $data['vol_max'],
            'commission'=> $data['commission'],
            'enabled'   => $data['enabled'] ?? 0,

        ]);


        return $symbelSetting;
    }

    public function findSymbelSettingById($id)
    {
        return $this->model::findOrFail($id);
    }

    public function updateSymbelSetting(array $data, $id)
    {
        $symbelSetting = $this->model::findOrFail($id);
        $symbelSetting->update([
            'name' => $data['name'] ?? $symbelSetting->name,
            'symbel_group_id'  => $data['symbel_group_id'] ?? $symbelSetting->symbel_group_id,
            'feed_name' => $data['feed_name'] ?? $symbelSetting->feed_name,
            'feed_name_fetch' => $data['feed_name_fetch'] ?? $symbelSetting->feed_name_fetch,
            'feed_price_fetch'  => $data['feed_price_fetch'] ?? $symbelSetting->feed_price_fetch,
            'speed_max'  => $data['speed_max'] ?? $symbelSetting->speed_max,
            'leverage'=> $data['leverage'] ?? $symbelSetting->leverage,
            'swap' => $data['swap'] ?? $symbelSetting->swap,
            'lot_size'=> $data['lot_size'] ?? $symbelSetting->lot_size,
            'lot_step'=> $data['lot_step'] ?? $symbelSetting->lot_step,
            'vol_min'=> $data['vol_min'] ?? $symbelSetting->vol_min,
            'vol_max'=> $data['vol_max'] ?? $symbelSetting->vol_max,
            'commission'=> $data['commission'] ?? $symbelSetting->commission,
            'enabled'   => $data['enabled'] ?? $symbelSetting->enabled,

        ]);
        return $symbelSetting;
    }

    public function deleteSymbelSetting($id)
    {
        $this->model::findOrFail($id)->delete();
    }
}
