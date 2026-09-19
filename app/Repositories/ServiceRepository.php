<?php

namespace App\Repositories;

use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function __construct(protected Service $model) {}

    public function find($id) { return $this->model->findOrFail($id); }

    public function create(array $data)
    {
        $metaData = $data['meta_data'] ?? [];
        $data = $this->payload($data);
        $avatar = $data['avatar'];
        unset($data['avatar']);
        $service = $this->model->create($data);
        if ($metaData) {
            $service->metaCreateOrUpdate($metaData);
        }
        $service->uploadImage($service, null, $avatar, 'avatar');
        return $service;
    }

    public function update($id, array $data)
    {
        $service = $this->find($id);
        $metaData = $data['meta_data'] ?? [];
        $data = $this->payload($data);
        $avatar = $data['avatar'];
        unset($data['avatar']);
        $service->update($data);
        if ($metaData) {
            $service->metaCreateOrUpdate($metaData);
        }
        $service->uploadImage($service, null, $avatar, 'avatar');
        return $service;
    }

    public function delete($id)
    {
        $service = $this->find($id);
        if ($service->avatar && Storage::disk('public')->exists($service->avatar)) Storage::disk('public')->delete($service->avatar);
        return $service->delete();
    }

    public function datatables(array $params)
    {
        return $this->model->query()
            ->when($params['keyword'] ?? null, fn ($query, $keyword) => $query->where(function ($subQuery) use ($keyword) {
                $subQuery->where('name', 'like', "%{$keyword}%")->orWhere('description', 'like', "%{$keyword}%");
            }))
            ->when(isset($params['active']) && $params['active'] !== '', fn ($query) => $query->where('active', $params['active']))
            ->orderBy('position')->orderByDesc('id')->get();
    }

    private function payload(array $data): array
    {
        $payload = array_intersect_key($data, array_flip(['contract_price', 'name', 'slug', 'description', 'benefits', 'content', 'avatar', 'active', 'position']));
        $payload['active'] = (bool) ($payload['active'] ?? false);
        $payload['position'] = (int) ($payload['position'] ?? 0);
        return $payload;
    }
}
